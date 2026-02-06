<?php

namespace App\Services;

use App\Models\AiProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JobParsingService
{
    protected AiProviderService $aiService;

    public function __construct(AiProviderService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Parse a job description using AI to extract structured data.
     *
     * @param string $text The raw job description text
     * @param int|null $providerId Optional specific AI provider to use
     * @return array Structured job data
     */
    public function parse(string $text, ?int $providerId = null): array
    {
        // Normalize text
        $text = trim($text);

        // Try AI-powered parsing first
        $aiResult = $this->parseWithAI($text, $providerId);

        if ($aiResult !== null) {
            return $aiResult;
        }

        // Fallback to regex-based parsing if AI fails
        Log::warning('AI parsing failed, falling back to regex parsing');
        return $this->parseWithRegex($text);
    }

    /**
     * Parse job description using AI provider.
     */
    protected function parseWithAI(string $text, ?int $providerId = null): ?array
    {
        try {
            // Use specific provider if provided, otherwise use active/default
            if ($providerId) {
                $provider = AiProvider::find($providerId);
            } else {
                $provider = $this->aiService->getActiveProvider();
            }

            if (!$provider) {
                Log::warning('No active AI provider available for job parsing');
                return null;
            }

            $systemPrompt = <<<PROMPT
You are a job description parser. Extract structured information from job descriptions and return ONLY valid JSON.

Extract the following fields:
- job_title: The job title/position name
- company_name: The company/organization name
- location: Work location (city, country, or "Remote", "Hybrid", etc.)
- job_type: One of "Full-time", "Part-time", "Contract", "Freelance", "Internship"
- experience_level: One of "Entry", "Mid-Level", "Senior", "Lead", "Manager", "Executive"
- salary_range: Salary information if mentioned (e.g., "$100k - $150k")
- skills: Array of required skills/technologies

Return ONLY a valid JSON object with these exact fields. If a field cannot be determined, use null or empty array for skills.
PROMPT;

            $userMessage = "Parse this job description and extract the details as JSON:\n\n" . $text;

            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userMessage],
            ];

            $model = $provider->default_model ?? 'llama-3.3-70b-versatile';

            $result = $this->aiService->makeCompletionRequestWithFailover(
                $provider,
                $model,
                $messages,
                [
                    'max_tokens' => 1024,
                    'temperature' => 0.1, // Low temperature for consistent extraction
                ]
            );

            if (!$result['success']) {
                Log::error('AI parsing request failed', ['error' => $result['error'] ?? 'Unknown error']);
                return null;
            }

            // Extract the content from the response
            $content = $result['data']['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                Log::error('AI response has no content');
                return null;
            }

            // Parse the JSON from the response
            $parsed = $this->extractJsonFromResponse($content);

            if (!$parsed) {
                Log::error('Failed to parse JSON from AI response', ['content' => $content]);
                return null;
            }

            // Normalize and validate the parsed data
            return $this->normalizeAIOutput($parsed, $text);

        } catch (\Exception $e) {
            Log::error('AI parsing exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Extract JSON from AI response (handles markdown code blocks).
     */
    protected function extractJsonFromResponse(string $content): ?array
    {
        // Remove markdown code blocks if present
        $content = trim($content);

        // Check for ```json ... ``` format
        if (preg_match('/```(?:json)?\s*([\s\S]*?)```/', $content, $matches)) {
            $content = trim($matches[1]);
        }

        // Try to parse as JSON
        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return null;
    }

    /**
     * Normalize AI output to match expected format.
     */
    protected function normalizeAIOutput(array $parsed, string $originalText): array
    {
        // Map experience level to valid options
        $experienceLevel = $this->normalizeExperienceLevel($parsed['experience_level'] ?? null);

        // Map job type to valid options
        $jobType = $this->normalizeJobType($parsed['job_type'] ?? null);

        // Ensure skills is an array
        $skills = [];
        if (isset($parsed['skills'])) {
            if (is_array($parsed['skills'])) {
                $skills = array_filter($parsed['skills'], fn($s) => is_string($s) && !empty(trim($s)));
            } elseif (is_string($parsed['skills'])) {
                $skills = array_filter(array_map('trim', explode(',', $parsed['skills'])));
            }
        }

        return [
            'job_title' => $parsed['job_title'] ?? $this->extractTitleFallback($originalText),
            'company_name' => $parsed['company_name'] ?? 'Unknown Company',
            'location' => $parsed['location'] ?? null,
            'job_type' => $jobType,
            'experience_level' => $experienceLevel,
            'salary_range' => $parsed['salary_range'] ?? null,
            'job_details' => $originalText,
            'requirements' => [],
            'job_data' => [
                'skills' => array_values($skills),
                'email' => $this->extractEmail($originalText),
                'benefits' => [],
                'summary' => Str::limit($originalText, 200),
                'full_description' => $originalText,
            ]
        ];
    }

    /**
     * Normalize experience level to valid option.
     */
    protected function normalizeExperienceLevel(?string $level): string
    {
        if (!$level) {
            return 'Mid-Level';
        }

        $level = strtolower(trim($level));

        $mapping = [
            'entry' => 'Entry',
            'entry level' => 'Entry',
            'entry-level' => 'Entry',
            'junior' => 'Entry',
            'mid' => 'Mid-Level',
            'mid level' => 'Mid-Level',
            'mid-level' => 'Mid-Level',
            'intermediate' => 'Mid-Level',
            'senior' => 'Senior',
            'sr' => 'Senior',
            'lead' => 'Lead',
            'principal' => 'Lead',
            'staff' => 'Lead',
            'manager' => 'Manager',
            'management' => 'Manager',
            'executive' => 'Executive',
            'director' => 'Executive',
            'vp' => 'Executive',
            'c-level' => 'Executive',
        ];

        foreach ($mapping as $key => $value) {
            if (str_contains($level, $key)) {
                return $value;
            }
        }

        return 'Mid-Level';
    }

    /**
     * Normalize job type to valid option.
     */
    protected function normalizeJobType(?string $type): string
    {
        if (!$type) {
            return 'Full-time';
        }

        $type = strtolower(trim($type));

        if (str_contains($type, 'full')) {
            return 'Full-time';
        }
        if (str_contains($type, 'part')) {
            return 'Part-time';
        }
        if (str_contains($type, 'contract')) {
            return 'Contract';
        }
        if (str_contains($type, 'freelance')) {
            return 'Freelance';
        }
        if (str_contains($type, 'intern')) {
            return 'Internship';
        }

        return 'Full-time';
    }

    /**
     * Fallback title extraction.
     */
    protected function extractTitleFallback(string $text): string
    {
        $lines = array_filter(explode("\n", $text));
        return reset($lines) ?: 'Untitled Job';
    }

    /**
     * Extract email from text.
     */
    protected function extractEmail(string $text): ?string
    {
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $matches)) {
            return $matches[0];
        }
        return null;
    }

    /**
     * Fallback: Parse job description using regex patterns.
     */
    protected function parseWithRegex(string $text): array
    {
        return [
            'job_title' => $this->extractTitleFallback($text),
            'company_name' => $this->extractCompanyRegex($text) ?? 'Unknown Company',
            'location' => $this->extractLocationRegex($text),
            'job_type' => $this->extractJobTypeRegex($text),
            'experience_level' => $this->extractExperienceLevelRegex($text),
            'salary_range' => $this->extractSalaryRegex($text),
            'job_details' => $text,
            'requirements' => [],
            'job_data' => [
                'skills' => $this->extractSkillsRegex($text),
                'email' => $this->extractEmail($text),
                'benefits' => [],
                'summary' => Str::limit($text, 200),
                'full_description' => $text,
            ]
        ];
    }

    // Regex fallback methods
    protected function extractCompanyRegex(string $text): ?string
    {
        if (preg_match('/(at|@)\s+([A-Z][a-zA-Z0-9\s&\-\.]+)(?:\s|$|\n|,)/u', $text, $matches)) {
            return trim($matches[2]);
        }
        if (preg_match('/Company(?:\s+Name)?:\s*([A-Z][a-zA-Z0-9\s&\-\.]+)(?:\s|$|\n)/iu', $text, $matches)) {
            return trim($matches[1]);
        }
        $lines = array_filter(explode("\n", $text), fn($l) => trim($l) !== '');
        $lines = array_values($lines);
        if (count($lines) >= 2) {
            $secondLine = trim($lines[1]);
            if (
                strlen($secondLine) < 100 && preg_match('/^[A-Z]/', $secondLine) &&
                !preg_match('/^(Location|Remote|Hybrid|Full-time|Part-time|Job Type|Experience|Salary|About|Requirements)/i', $secondLine)
            ) {
                return $secondLine;
            }
        }
        return null;
    }

    protected function extractLocationRegex(string $text): ?string
    {
        if (preg_match('/Location:\s*([A-Za-z\s,\-\/]+?)(?:\n|$|Job|Experience|Salary)/i', $text, $matches)) {
            return trim(rtrim($matches[1], ','));
        }
        if (stripos($text, 'Remote') !== false) {
            return 'Remote';
        }
        if (stripos($text, 'Hybrid') !== false) {
            return 'Hybrid';
        }
        return null;
    }

    protected function extractJobTypeRegex(string $text): string
    {
        $types = ['Full-time', 'Part-time', 'Contract', 'Internship', 'Freelance'];
        foreach ($types as $type) {
            if (stripos($text, $type) !== false) {
                return $type;
            }
        }
        return 'Full-time';
    }

    protected function extractExperienceLevelRegex(string $text): string
    {
        if (stripos($text, 'Senior') !== false || stripos($text, 'Sr.') !== false)
            return 'Senior';
        if (stripos($text, 'Junior') !== false || stripos($text, 'Jr.') !== false || stripos($text, 'Entry') !== false)
            return 'Entry';
        if (stripos($text, 'Lead') !== false || stripos($text, 'Principal') !== false)
            return 'Lead';
        if (stripos($text, 'Manager') !== false)
            return 'Manager';
        return 'Mid-Level';
    }

    protected function extractSalaryRegex(string $text): ?string
    {
        if (preg_match('/\$[\d,]+(k)?\s*-\s*\$[\d,]+(k)?/i', $text, $matches)) {
            return $matches[0];
        }
        if (preg_match('/\$[\d,]{2,}/', $text, $matches)) {
            return $matches[0];
        }
        return null;
    }

    protected function extractSkillsRegex(string $text): array
    {
        $commonSkills = ['PHP', 'Laravel', 'Vue', 'React', 'JavaScript', 'Python', 'Java', 'SQL', 'AWS', 'Docker', 'Git', 'Agile', 'Product Management', 'Roadmapping', 'User Research', 'Figma', 'Sketch', 'Project Management', 'Microsoft Office', 'RAID', 'Communication'];
        $found = [];
        foreach ($commonSkills as $skill) {
            if (stripos($text, $skill) !== false) {
                $found[] = $skill;
            }
        }
        return $found;
    }
}
