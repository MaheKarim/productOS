<?php

namespace App\Services\Resume;

use App\Models\ResumeAnalysis;
use App\Services\AiProviderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResumeAnalyzerService
{
  protected AiProviderService $aiService;
  protected ResumeParserService $parserService;

  public function __construct(AiProviderService $aiService, ResumeParserService $parserService)
  {
    $this->aiService = $aiService;
    $this->parserService = $parserService;
  }

  /**
   * Analyze a resume and return ATS compatibility report.
   */
  public function analyze(string $resumeText, ?string $fileName = null): array
  {
    $provider = $this->aiService->getActiveProvider();

    if (!$provider) {
      throw new \Exception('No AI provider available for analysis.');
    }

    // Increase time limit for AI processing
    set_time_limit(180);

    // Truncate text to prevent timeout
    $truncatedText = mb_substr($resumeText, 0, 10000);

    $prompt = $this->buildAnalysisPrompt($truncatedText);

    try {
      $response = $this->aiService->makeCompletionRequestWithFailover(
        $provider,
        $provider->default_model,
        [['role' => 'user', 'content' => $prompt]],
        ['max_tokens' => 4096] // Increased for detailed JSON response
      );

      if (!$response['success']) {
        Log::error('ATS Analysis AI request failed: ' . ($response['error'] ?? 'Unknown'));
        throw new \Exception('AI analysis failed. Please try again.');
      }

      $content = $response['data']['choices'][0]['message']['content'];
      $analysisData = $this->parseAnalysisResponse($content);

      // Save to database
      $analysis = $this->saveAnalysis($analysisData, $resumeText, $fileName);

      return [
        'success' => true,
        'analysis' => $analysis,
        'data' => $analysisData,
      ];

    } catch (\Exception $e) {
      Log::error('Resume analysis error: ' . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Build the AI prompt for ATS analysis.
   */
  protected function buildAnalysisPrompt(string $resumeText): string
  {
    return <<<PROMPT
You are an ATS analyzer. Return ONLY valid JSON, no markdown or explanation.

RESUME:
{$resumeText}

Return this JSON structure:
{
  "overall_score": 0-100,
  "priority_summary": {"critical": 0, "important": 0, "optional": 0},
  "section_breakdown": [
    {"section": "Section Name", "status": "complete|present|needs_improvement|missing", "word_count": 0, "issues": []}
  ],
  "content_metrics": {
    "total_words": 0,
    "action_verb_percentage": 0,
    "quantifiable_achievements": 0,
    "recommended_achievements": 15,
    "keywords_found": 0,
    "bullet_points_count": 0
  },
  "ats_checklist": [
    {"item": "Check item", "passed": true, "note": ""}
  ],
  "improvement_examples": [
    {"section": "Experience", "current": "weak text", "improved": "strong improved text with metrics"}
  ],
  "contact_validation": {
    "email": {"present": true, "professional": true, "issue": ""},
    "phone": {"present": true, "format_correct": true, "issue": ""},
    "linkedin": {"present": true, "clickable": true, "issue": ""},
    "location": {"present": true, "issue": ""}
  },
  "resume_length": {
    "estimated_pages": 1,
    "recommended_pages": 1,
    "content_density": "sparse|good|dense",
    "verdict": "Brief assessment"
  },
  "missing_sections": [
    {"section": "Section Name", "priority": "critical|important|optional", "suggestion": "How to add it"}
  ],
  "section_scores": {
    "contact_info": {"score": 0, "feedback": ""},
    "summary": {"score": 0, "feedback": ""},
    "experience": {"score": 0, "feedback": ""},
    "education": {"score": 0, "feedback": ""},
    "skills": {"score": 0, "feedback": ""}
  },
  "keyword_suggestions": [
    {"keyword": "keyword", "relevance": "high|medium|low", "where_to_add": "section"}
  ],
  "formatting_issues": [
    {"issue": "Issue", "severity": "high|medium|low", "fix": "How to fix"}
  ],
  "action_verbs": {
    "weak_verbs_found": [],
    "strong_verbs_percentage": 0,
    "suggested_replacements": [{"weak": "weak verb", "strong": "better alternatives"}]
  },
  "recommendations": [
    {"title": "Title", "priority": "critical|important|optional", "description": "Actionable advice"}
  ]
}

Analyze thoroughly. Include 2+ improvement_examples. Count issues for priority_summary.
PROMPT;
  }



  /**
   * Parse the AI response into structured data.
   */
  protected function parseAnalysisResponse(string $content): array
  {
    // Log raw response for debugging (first 500 chars)
    Log::info('ATS Analysis raw response (first 500 chars): ' . substr($content, 0, 500));

    $json = $content;

    // Try to extract JSON from markdown code block
    if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $content, $matches)) {
      $json = $matches[1];
    }
    // Try to find JSON object pattern
    elseif (preg_match('/\{[\s\S]*"overall_score"[\s\S]*\}/', $content, $matches)) {
      $json = $matches[0];
    }

    // Clean up common issues
    $json = trim($json);

    // Try to fix truncated JSON by finding the last complete object
    if (substr($json, -1) !== '}') {
      // Find the last closing brace
      $lastBrace = strrpos($json, '}');
      if ($lastBrace !== false) {
        $json = substr($json, 0, $lastBrace + 1);
      }
    }

    $decoded = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      Log::warning('Failed to parse ATS analysis JSON: ' . json_last_error_msg());
      Log::warning('Attempted to parse: ' . substr($json, 0, 1000));
      // Return default structure
      return $this->getDefaultAnalysis();
    }

    return $decoded;
  }


  /**
   * Get default analysis structure for fallback.
   */
  protected function getDefaultAnalysis(): array
  {
    return [
      'overall_score' => 50,
      'missing_sections' => [],
      'section_scores' => [],
      'keyword_suggestions' => [],
      'formatting_issues' => [],
      'action_verbs' => ['weak_verbs' => [], 'suggested_replacements' => []],
      'recommendations' => [
        ['title' => 'Analysis Incomplete', 'priority' => 'critical', 'description' => 'We could not fully analyze your resume. Please try again or contact support.']
      ],
    ];
  }

  /**
   * Save analysis to database.
   */
  protected function saveAnalysis(array $data, string $rawText, ?string $fileName): ResumeAnalysis
  {
    return ResumeAnalysis::create([
      'user_id' => Auth::id(),
      'file_name' => $fileName,
      'overall_score' => $data['overall_score'] ?? 0,
      'priority_summary' => $data['priority_summary'] ?? [],
      'section_breakdown' => $data['section_breakdown'] ?? [],
      'content_metrics' => $data['content_metrics'] ?? [],
      'ats_checklist' => $data['ats_checklist'] ?? [],
      'improvement_examples' => $data['improvement_examples'] ?? [],
      'contact_validation' => $data['contact_validation'] ?? [],
      'resume_length' => $data['resume_length'] ?? [],
      'missing_sections' => $data['missing_sections'] ?? [],
      'keyword_suggestions' => $data['keyword_suggestions'] ?? [],
      'formatting_issues' => $data['formatting_issues'] ?? [],
      'section_scores' => $data['section_scores'] ?? [],
      'recommendations' => $data['recommendations'] ?? [],
      'action_verbs' => $data['action_verbs'] ?? [],
      'raw_resume_text' => $rawText,
    ]);
  }

}
