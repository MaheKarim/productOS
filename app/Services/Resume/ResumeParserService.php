<?php

namespace App\Services\Resume;

use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Services\AiProviderService;

class ResumeParserService
{
    protected PdfParser $pdfParser;
    protected AiProviderService $aiService;

    public function __construct(PdfParser $pdfParser, AiProviderService $aiService)
    {
        $this->pdfParser = $pdfParser;
        $this->aiService = $aiService;
    }

    /**
     * Parse uploaded resume file.
     */
    public function parse(UploadedFile $file): array
    {
        $extension = $file->getClientOriginalExtension();
        $text = '';

        try {
            if (strtolower($extension) === 'pdf') {
                $text = $this->parsePdf($file->getPathname());
            } elseif (in_array(strtolower($extension), ['doc', 'docx'])) {
                $text = $this->parseDocx($file->getPathname());
            } else {
                throw new \Exception('Unsupported file format');
            }

            return $this->extractStructuredDataWithAi($text);

        } catch (\Exception $e) {
            Log::error('Resume parsing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function parsePdf(string $path): string
    {
        $pdf = $this->pdfParser->parseFile($path);
        return $pdf->getText();
    }

    protected function parseDocx(string $path): string
    {
        $phpWord = IOFactory::load($path);
        $text = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . "\n";
                } elseif (method_exists($element, 'getTextElements')) {
                    // Handle TextRun
                    foreach ($element->getTextElements() as $textElement) {
                        $text .= $textElement->getText();
                    }
                    $text .= "\n";
                }
            }
        }
        return $text;
    }

    /**
     * Use AI to extract structured resume data from raw text.
     */
    protected function extractStructuredDataWithAi(string $text): array
    {
        $provider = $this->aiService->getActiveProvider();
        if (!$provider) {
            // Fallback to basic extraction if no AI provider
            return $this->extractStructuredDataBasic($text);
        }

        // Increase time limit for AI processing
        set_time_limit(120);

        // Truncate text to prevent timeout (first 8000 chars should contain most resume info)
        $truncatedText = mb_substr($text, 0, 8000);

        $prompt = <<<PROMPT
Parse this resume and return JSON only. No markdown, no explanation.

RESUME:
{$truncatedText}

Return this exact JSON structure:
{"name":"Full Name","email":"email@example.com","phone":"phone","location":"City","summary":"2-3 sentence summary","experience":[{"title":"Job Title","company":"Company","duration":"Dates","description":"Key achievements"}],"education":[{"degree":"Degree","institution":"School","year":"Year"}],"skills":["skill1","skill2"]}

Extract all jobs, education entries, and skills. Use null for missing fields.
PROMPT;

        try {
            $response = $this->aiService->makeCompletionRequestWithFailover($provider, $provider->default_model, [
                ['role' => 'user', 'content' => $prompt]
            ]);

            if (!$response['success']) {
                Log::warning('AI extraction failed, falling back to basic: ' . ($response['error'] ?? 'Unknown'));
                return $this->extractStructuredDataBasic($text);
            }

            $content = $response['data']['choices'][0]['message']['content'];
            return $this->parseJsonFromAi($content, $text);

        } catch (\Exception $e) {
            Log::error('AI resume extraction error: ' . $e->getMessage());
            return $this->extractStructuredDataBasic($text);
        }
    }

    /**
     * Parse JSON from AI response, with fallback handling.
     */
    protected function parseJsonFromAi(string $content, string $originalText): array
    {
        // Remove markdown code block if present
        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $content, $matches)) {
            $json = $matches[1];
        } else {
            $json = $content;
        }

        $decoded = json_decode(trim($json), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::warning('Failed to parse AI JSON response: ' . json_last_error_msg());
            return $this->extractStructuredDataBasic($originalText);
        }

        // Ensure required fields exist
        $decoded['raw_text'] = $originalText;

        return $decoded;
    }

    /**
     * Basic extraction logic (Regex-based fallback).
     */
    protected function extractStructuredDataBasic(string $text): array
    {
        $data = [
            'raw_text' => $text,
            'name' => 'Unknown',
            'email' => null,
            'phone' => null,
            'location' => null,
            'summary' => null,
            'skills' => [],
            'experience' => [],
            'education' => []
        ];

        // Extract Email
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $matches)) {
            $data['email'] = $matches[0];
        }

        // Extract Phone (Simple US/Intl regex)
        if (preg_match('/(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}/', $text, $matches)) {
            $data['phone'] = $matches[0];
        }

        // Extract Name (Heuristic: First non-empty line usually)
        $lines = array_filter(explode("\n", $text), fn($l) => !empty(trim($l)));
        if (!empty($lines)) {
            $data['name'] = trim(reset($lines));
        }

        // Try to extract skills section
        if (preg_match('/(?:skills|technologies|tech stack)[:\s]*(.*?)(?:\n\n|\z)/is', $text, $matches)) {
            $skillsText = $matches[1];
            $skillsList = preg_split('/[,\n•·\-|]/', $skillsText);
            $data['skills'] = array_filter(array_map('trim', $skillsList), fn($s) => strlen($s) > 1 && strlen($s) < 50);
            $data['skills'] = array_values($data['skills']);
        }

        return $data;
    }
}

