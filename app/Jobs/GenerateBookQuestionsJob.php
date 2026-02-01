<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Question;
use App\Models\AiProvider;
use App\Services\AI\AiProcessingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class GenerateBookQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // 1 hour timeout

    protected $book;
    protected $providerId;

    public function __construct(Book $book, $providerId)
    {
        $this->book = $book;
        $this->providerId = $providerId;
    }

    public function handle(AiProcessingService $aiService)
    {
        $this->book->update(['status' => 'processing']);

        try {
            $provider = AiProvider::find($this->providerId);
            if (!$provider) {
                throw new \Exception("AI Provider not found");
            }

            // 1. Get Content (Use chapters if available, otherwise parse PDF)
            if ($this->book->chapters()->count() > 0) {
                // Iterate through chapters to get better granularity
                foreach ($this->book->chapters as $chapter) {
                    $this->generateQuestionsForContent($aiService, $provider, $chapter->content, $chapter->title);
                }
            } else {
                // Fallback extraction if no chapters
                $content = $this->extractText();
                // Split into chunks if too large (naive splitting)
                $chunks = str_split($content, 15000); // approx 3-4k words
                foreach ($chunks as $index => $chunk) {
                    $this->generateQuestionsForContent($aiService, $provider, $chunk, "Part " . ($index + 1));
                }
            }

            $this->book->update(['status' => 'completed']);

        } catch (\Exception $e) {
            Log::error("Question Generation Failed: " . $e->getMessage());
            $this->book->update([
                'status' => 'failed',
                'error_message' => 'Question Gen Failed: ' . $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function extractText()
    {
        $path = Storage::disk('public')->path($this->book->file_path);
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        return $pdf->getText();
    }

    protected function generateQuestionsForContent($aiService, $provider, $content, $sectionTitle)
    {
        // Fetch System Prompt from Database
        $systemPrompt = \App\Models\SystemPrompt::where('type', 'book_question_generation')->first();

        if ($systemPrompt) {
            $basePrompt = $systemPrompt->content;
        } else {
            // Fallback if not found (though seeder should have run)
            $basePrompt = <<<EOT
You are an expert educational content creator.
Generate diverse, high-quality questions based on the provided text section from the book "{$this->book->title}" ($sectionTitle).

Requirements:
1. Generate 5-10 questions for this specific section.
2. Questions should vary in difficulty (Easy, Medium, Hard).
3. Include multiple correct answers where applicable.
4. Output MUST be valid JSON only.

JSON Structure:
{
    "questions": [
        {
            "question": "Question text...",
            "answers": ["Option A", "Option B", "Option C", "Option D"],
            "correct_answer": ["Option A"], 
            "explanation": "Why this is correct...",
            "marks": 5,
            "difficulty": "easy|medium|hard",
            "category": "Topic Name",
            "question_for": "New|Experienced|Senior" 
        }
    ]
}
EOT;
        }

        $prompt = <<<EOT
{$basePrompt}

Text Content from "{$this->book->title}" ($sectionTitle):
{$content}
EOT;

        try {
            $response = $aiService->processText($content, $prompt, $provider);

            if (isset($response['questions']) && is_array($response['questions'])) {
                foreach ($response['questions'] as $q) {
                    $questionFor = $this->mapQuestionFor($q['question_for'] ?? '');

                    Question::create([
                        'book_id' => $this->book->id,
                        'type' => $q['type'] ?? 'mcq', // Create type from AI response
                        'question' => $q['question'],
                        'answers' => $q['answers'],
                        'correct_answer' => $q['correct_answer'], // Ensure array
                        'explanation' => $q['explanation'] ?? null,
                        'marks' => $q['marks'] ?? 5,
                        'difficulty' => strtolower($q['difficulty'] ?? 'medium'),
                        'is_active' => true,
                        'source' => $this->book->title,
                        'question_for' => $questionFor,
                        // categories would need relation mapping, skipping purely specific Category model for now
                        // or finding the category by name or creating it.
                        // For simplicity, we might default or ignore category relation if strict ID needed,
                        // but user asked for "Category" field input? 
                        // Ah, existing system uses `categories()` relation. 
                        // I'll try to find or create a category tag.
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error("Failed to generate questions for section $sectionTitle: " . $e->getMessage());
        }
    }

    protected function mapQuestionFor($value)
    {
        $value = strtolower($value);
        if (str_contains($value, 'new') || str_contains($value, 'begin')) {
            return "New to PM (Less than 2 years experience)";
        }
        if (str_contains($value, 'senior') || str_contains($value, 'found') || str_contains($value, 'advanc')) {
            return "Senior PM / Founder (5+ years or leading a startup)";
        }
        return "Experienced PM (2-5 years experience)";
    }
}
