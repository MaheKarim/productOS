<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\BookChapter;
use App\Models\BookSummary;
use App\Models\AiProvider;
use App\Services\AI\AiProcessingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class ProcessBookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // 1 hour timeout for large books

    protected $book;
    protected $providerId;
    protected $processType;
    protected $translate;

    public function __construct(Book $book, $providerId, $processType, $translate)
    {
        $this->book = $book;
        $this->providerId = $providerId;
        $this->processType = $processType;
        $this->translate = $translate;
    }

    public function handle(AiProcessingService $aiService)
    {
        $this->book->update(['status' => 'extracting']);

        try {
            // 1. Extract Text & Chunk (if not already done)
            if ($this->book->chapters()->count() == 0) {
                $this->extractAndChunk();
            }

            $this->book->update(['status' => 'processing']);
            $provider = AiProvider::find($this->providerId);

            if (!$provider) {
                throw new \Exception("AI Provider not found");
            }

            // 2. Process Summaries
            if ($this->processType === 'chapter' || $this->processType === 'both') {
                $this->generateChapterSummaries($aiService, $provider);
            }

            if ($this->processType === 'full' || $this->processType === 'both') {
                $this->generateFullSummary($aiService, $provider);
            }

            $this->book->update(['status' => 'completed']);

        } catch (\Exception $e) {
            Log::error("Book Processing Failed: " . $e->getMessage());
            $this->book->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function extractAndChunk()
    {
        $path = Storage::disk('public')->path($this->book->file_path);

        // Use a memory safe approach if possible, but for now standard parser
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        $pages = $pdf->getPages();

        // Chunk by 10 pages to be safe with context windows (approx 3-5k words)
        $chunkSize = 10;
        $chunks = array_chunk($pages, $chunkSize);
        $totalChunks = count($chunks);

        foreach ($chunks as $index => $chunkPages) {
            $content = '';
            $startPage = ($index * $chunkSize) + 1;
            $endPage = $startPage + count($chunkPages) - 1;

            foreach ($chunkPages as $page) {
                $content .= $page->getText() . "\n";
            }

            // Simple sanitation
            $content = preg_replace('/[^\P{C}\n]+/u', '', $content);

            BookChapter::create([
                'book_id' => $this->book->id,
                'title' => "Part " . ($index + 1) . " (Pages $startPage-$endPage)",
                'content' => $content,
                'order' => $index + 1,
                'start_page' => $startPage,
                'end_page' => $endPage,
            ]);
        }
    }

    protected function generateChapterSummaries(AiProcessingService $aiService, AiProvider $provider)
    {
        $chapters = $this->book->chapters;
        foreach ($chapters as $chapter) {
            // Check if summary exists to avoid re-doing? 
            // For now, overwrite or simple create
            // Let's create specific logic

            $systemPrompt = <<<EOT
You are an expert literary analyst and translator.
Analyze the provided text (a book chapter or part) and generate a summary.
Output MUST be valid JSON only.

Required JSON Structure:
{
    "summary_english": "The summary in English...",
    "summary_bangla": "The summary translated into Bengali..."
}
EOT;

            if (!$this->translate) {
                $systemPrompt = <<<EOT
You are an expert literary analyst.
Analyze the provided text and generate a summary.
Output MUST be valid JSON only.

Required JSON Structure:
{
    "summary_english": "The summary in English..."
}
EOT;
            }

            try {
                $response = $aiService->processText($chapter->content, $systemPrompt, $provider);

                BookSummary::updateOrCreate(
                    [
                        'book_id' => $this->book->id,
                        'book_chapter_id' => $chapter->id,
                        'type' => 'chapter'
                    ],
                    [
                        'summary' => $response['summary_english'] ?? ($response['text'] ?? ''),
                        'translation_bn' => $response['summary_bangla'] ?? null,
                        'ai_provider_id' => $provider->id,
                    ]
                );

            } catch (\Exception $e) {
                Log::error("Chapter processing failed for Chapter {$chapter->id}: " . $e->getMessage());
                // Continue to next chapter instead of failing everything?
            }
        }
    }

    protected function generateFullSummary(AiProcessingService $aiService, AiProvider $provider)
    {
        // For full summary, we aggregate chapter summaries if they exist, or chunked content
        // If chapter summaries exist, it's MUCH cheaper and better to summarize the summaries.

        $chapterSummaries = $this->book->summaries()->where('type', 'chapter')->orderBy('id')->pluck('summary')->implode("\n\n");

        if (empty($chapterSummaries) && $this->book->chapters()->count() > 0) {
            // Fallback: grab content from chapters (might be too huge)
            $content = $this->book->chapters()->orderBy('order')->limit(5)->pluck('content')->implode("\n") . "\n... (truncated)";
        } else {
            $content = $chapterSummaries;
        }

        $systemPrompt = <<<EOT
You are an expert literary analyst and translator.
Create a comprehensive summary of the entire book based on the provided text sections.
Output MUST be valid JSON only.

Required JSON Structure:
{
    "summary_english": "Comprehensive summary in English...",
    "summary_bangla": "Comprehensive summary translated into Bengali..."
}
EOT;

        if (!$this->translate) {
            $systemPrompt = <<<EOT
You are an expert literary analyst.
Create a comprehensive summary of the entire book based on the provided text sections.
Output MUST be valid JSON only.

Required JSON Structure:
{
    "summary_english": "Comprehensive summary in English..."
}
EOT;
        }

        try {
            $response = $aiService->processText($content, $systemPrompt, $provider);

            BookSummary::updateOrCreate(
                [
                    'book_id' => $this->book->id,
                    'type' => 'full'
                ],
                [
                    'summary' => $response['summary_english'] ?? ($response['text'] ?? ''),
                    'translation_bn' => $response['summary_bangla'] ?? null,
                    'ai_provider_id' => $provider->id,
                    'book_chapter_id' => null,
                ]
            );

        } catch (\Exception $e) {
            Log::error("Full summary failed: " . $e->getMessage());
        }
    }
}
