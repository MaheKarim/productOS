<?php

namespace App\Services\Resume;

use App\Models\User;
use App\Services\AiProviderService;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Str;

class ResumeBuilderService
{
    protected ResumeParserService $parserService;
    protected AiProviderService $aiService;

    public function __construct(ResumeParserService $parserService, AiProviderService $aiService)
    {
        $this->parserService = $parserService;
        $this->aiService = $aiService;
    }

    /**
     * Generate optimized resume JSON using AI.
     */
    public function generateOptimizedResume(User $user, string $jobDescription): array
    {
        $currentResume = $user->resume_data;
        if (!$currentResume) {
            throw new \Exception("No resume data found. Please upload a resume first.");
        }

        // Increase time limit for AI processing
        set_time_limit(120);

        // Construct a more explicit prompt for JSON output
        $resumeJson = json_encode($currentResume, JSON_PRETTY_PRINT);

        $prompt = <<<PROMPT
You are an ATS resume optimizer. Rewrite the resume below to match the job description. Return ONLY valid JSON, no explanations.

JOB DESCRIPTION:
{$jobDescription}

CURRENT RESUME (JSON):
{$resumeJson}

INSTRUCTIONS:
1. Keep the EXACT same JSON structure
2. Optimize "summary" with JD keywords
3. Rewrite "experience" descriptions to match JD requirements
4. Ensure "skills" include relevant JD keywords
5. Return ONLY the JSON object, nothing else

OUTPUT FORMAT: Return raw JSON only. No markdown code blocks. No explanations before or after.
PROMPT;

        $provider = $this->aiService->getActiveProvider();
        if (!$provider) {
            throw new \Exception("No active AI provider.");
        }

        $response = $this->aiService->makeCompletionRequestWithFailover($provider, $provider->default_model, [
            ['role' => 'user', 'content' => $prompt]
        ]);

        if (!$response['success']) {
            throw new \Exception("AI generation failed: " . ($response['error'] ?? 'Unknown error'));
        }

        $content = $response['data']['choices'][0]['message']['content'];

        // Log the AI response for debugging
        \Illuminate\Support\Facades\Log::info('AI Resume Response (first 500 chars): ' . substr($content, 0, 500));

        return $this->parseJsonFromAi($content, $currentResume);
    }

    /**
     * Export resume data to PDF.
     */
    public function exportToPdf(array $data)
    {
        $pdf = Pdf::loadView('components.resume-templates.modern', ['resume' => $data]);
        return $pdf->download('resume.pdf');
    }

    /**
     * Export resume data to DOCX.
     */
    public function exportToDocx(array $data): string
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Header
        $section->addText($data['name'] ?? 'Name', ['bold' => true, 'size' => 16]);
        $section->addText(($data['email'] ?? '') . ' | ' . ($data['phone'] ?? ''), ['size' => 10]);
        $section->addTextBreak(1);

        // Summary
        if (!empty($data['summary'])) {
            $section->addText('Professional Summary', ['bold' => true, 'size' => 12]);
            $section->addText($data['summary']);
            $section->addTextBreak(1);
        }

        // Experience
        if (!empty($data['experience'])) {
            $section->addText('Experience', ['bold' => true, 'size' => 12]);
            foreach ($data['experience'] as $exp) {
                $title = ($exp['title'] ?? '') . ' at ' . ($exp['company'] ?? '');
                $section->addText($title, ['bold' => true]);
                $section->addText($exp['duration'] ?? '', ['italic' => true, 'size' => 9]);
                $section->addText($exp['description'] ?? '');
                $section->addTextBreak(1);
            }
        }

        // Skills
        if (!empty($data['skills'])) {
            $section->addText('Skills', ['bold' => true, 'size' => 12]);
            $skills = is_array($data['skills']) ? implode(', ', $data['skills']) : $data['skills'];
            $section->addText($skills);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'resume_' . Str::random(10) . '.docx';
        $path = storage_path('app/public/' . $fileName);
        $objWriter->save($path);

        return $path;
    }

    /**
     * Parse JSON from AI response with multiple fallback strategies.
     */
    protected function parseJsonFromAi(string $content, array $fallbackData = []): array
    {
        $json = $content;

        // Strategy 1: Try to find JSON in markdown code block
        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $content, $matches)) {
            $json = $matches[1];
        }

        // Strategy 2: Try to find JSON object directly (starts with { and ends with })
        if (preg_match('/\{[\s\S]*\}/', $json, $matches)) {
            $json = $matches[0];
        }

        // Clean up common issues
        $json = trim($json);

        // Try to decode
        $decoded = json_decode($json, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Log the parsing failure for debugging
        \Illuminate\Support\Facades\Log::warning('JSON parse failed: ' . json_last_error_msg() . '. Content: ' . substr($content, 0, 300));

        // Fallback: Return original data with a note
        if (!empty($fallbackData)) {
            \Illuminate\Support\Facades\Log::info('Using fallback resume data');
            // Add a flag to indicate this is fallback data
            $fallbackData['_ai_optimized'] = false;
            $fallbackData['_optimization_note'] = 'AI optimization could not parse response, using original data';
            return $fallbackData;
        }

        throw new \Exception("Failed to parse AI response as JSON");
    }
}

