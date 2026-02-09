<?php

namespace App\Services\Resume;

use App\Models\ResumeAnalysis;
use App\Models\SystemPrompt;
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
    // Fetch prompt from database
    $systemPrompt = SystemPrompt::where('type', 'resume_ats_analysis')
      ->where('is_default', true)
      ->first();

    if ($systemPrompt) {
      // Replace placeholder with actual resume text
      return str_replace('{{resume_text}}', $resumeText, $systemPrompt->content);
    }

    // Fallback to default prompt if not found in database
    return $this->getDefaultAtsPrompt($resumeText);
  }

  /**
   * Get the default ATS analysis prompt (fallback).
   */
  protected function getDefaultAtsPrompt(string $resumeText): string
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
   * Save analysis to database (replaces any existing analysis for user).
   */
  protected function saveAnalysis(array $data, string $rawText, ?string $fileName): ResumeAnalysis
  {
    $userId = Auth::id();

    // Delete any existing analyses for this user (keep only latest)
    ResumeAnalysis::where('user_id', $userId)->delete();

    return ResumeAnalysis::create([
      'user_id' => $userId,
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

  /**
   * Analyze resume against a specific job posting.
   */
  public function analyzeAgainstJob(string $resumeText, array $jobDetails): array
  {
    $provider = $this->aiService->getActiveProvider();

    if (!$provider) {
      throw new \Exception('No AI provider available for analysis.');
    }

    // Increase time limit for AI processing
    set_time_limit(180);

    // Truncate text to prevent timeout
    $truncatedResume = mb_substr($resumeText, 0, 8000);
    $truncatedJobDesc = mb_substr($jobDetails['description'] ?? '', 0, 4000);

    $prompt = $this->buildJobAnalysisPrompt($truncatedResume, $jobDetails);

    try {
      $response = $this->aiService->makeCompletionRequestWithFailover(
        $provider,
        $provider->default_model,
        [['role' => 'user', 'content' => $prompt]],
        ['max_tokens' => 4096]
      );

      if (!$response['success']) {
        Log::error('Job-Resume Analysis AI request failed: ' . ($response['error'] ?? 'Unknown'));
        throw new \Exception('AI analysis failed. Please try again.');
      }

      $content = $response['data']['choices'][0]['message']['content'];
      $analysisData = $this->parseJobAnalysisResponse($content);

      return $analysisData;

    } catch (\Exception $e) {
      Log::error('Job-resume analysis error: ' . $e->getMessage());
      throw $e;
    }
  }

  /**
   * Build the AI prompt for job-resume analysis.
   */
  protected function buildJobAnalysisPrompt(string $resumeText, array $jobDetails): string
  {
    $jobTitle = $jobDetails['title'] ?? 'Unknown Position';
    $company = $jobDetails['company'] ?? 'Unknown Company';
    $jobDescription = $jobDetails['description'] ?? '';
    $requiredSkills = implode(', ', $jobDetails['skills'] ?? []);
    $experienceLevel = $jobDetails['experience_level'] ?? 'Not specified';

    // Fetch prompt from database
    $systemPrompt = SystemPrompt::where('type', 'resume_job_analysis')
      ->where('is_default', true)
      ->first();

    if ($systemPrompt) {
      // Replace placeholders with actual values
      $prompt = str_replace([
        '{{job_title}}',
        '{{company}}',
        '{{experience_level}}',
        '{{required_skills}}',
        '{{job_description}}',
        '{{resume_text}}',
      ], [
        $jobTitle,
        $company,
        $experienceLevel,
        $requiredSkills,
        $jobDescription,
        $resumeText,
      ], $systemPrompt->content);

      return $prompt;
    }

    // Fallback to default prompt
    return $this->getDefaultJobAnalysisPrompt($resumeText, $jobTitle, $company, $experienceLevel, $requiredSkills, $jobDescription);
  }

  /**
   * Get the default job analysis prompt (fallback).
   */
  protected function getDefaultJobAnalysisPrompt(
    string $resumeText,
    string $jobTitle,
    string $company,
    string $experienceLevel,
    string $requiredSkills,
    string $jobDescription
  ): string {
    return <<<PROMPT
You are an expert resume analyst. Compare the candidate's resume against the job posting and provide a comprehensive analysis.

JOB POSTING:
Title: {$jobTitle}
Company: {$company}
Experience Level: {$experienceLevel}
Required Skills: {$requiredSkills}

Job Description:
{$jobDescription}

CANDIDATE RESUME:
{$resumeText}

Return ONLY valid JSON with this structure:
{
  "overall_match_score": 0-100,
  "match_summary": "Brief summary of overall fit",
  "gap_analysis": {
    "missing_skills": [{"skill": "skill name", "importance": "critical|important|nice_to_have", "suggestion": "how to address"}],
    "missing_qualifications": [{"qualification": "qualification", "importance": "critical|important", "suggestion": "how to address"}],
    "experience_gaps": [{"area": "area", "current": "current level", "required": "required level", "gap": "description"}]
  },
  "strengths_assessment": {
    "skill_matches": [{"skill": "skill name", "proficiency": "high|medium|low", "evidence": "where shown in resume"}],
    "relevant_experience": [{"experience": "experience description", "relevance": "high|medium|low", "years": "duration"}],
    "achievements_aligned": [{"achievement": "achievement", "alignment": "how it aligns with job", "impact": "high|medium|low"}]
  },
  "weakness_identification": {
    "skill_weaknesses": [{"skill": "skill area", "current_level": "current assessment", "improvement_needed": "what needs improvement"}],
    "experience_shortfalls": [{"area": "experience area", "shortfall": "what's missing", "recommendation": "how to gain experience"}],
    "presentation_issues": [{"issue": "presentation problem", "impact": "severity", "solution": "how to fix"}]
  },
  "resume_optimization_suggestions": {
    "keyword_optimizations": [{"keyword": "important keyword", "current_usage": "how used now", "recommended_usage": "how to use better"}],
    "content_recommendations": [{"section": "resume section", "current_state": "current content", "recommended_change": "what to change"}],
    "formatting_improvements": [{"aspect": "formatting aspect", "current_issue": "current problem", "improvement": "how to improve"}]
  },
  "interview_prep_focus_areas": {
    "strengths_to_emphasize": ["strength 1", "strength 2"],
    "weaknesses_to_address": ["weakness 1", "weakness 2"],
    "key_stories_to_prepare": [{"story": "achievement or experience", "relevance": "why it's important for this job"}],
    "technical_topics_to_review": ["topic 1", "topic 2"]
  },
  "next_steps": {
    "immediate_actions": ["action 1", "action 2"],
    "long_term_improvements": ["improvement 1", "improvement 2"],
    "interview_preparation_priority": "high|medium|low"
  }
}

Be specific and actionable. Provide concrete examples and clear recommendations. Focus on practical advice that will help the candidate improve their chances.
PROMPT;
  }

  /**
   * Parse the AI response for job analysis.
   */
  protected function parseJobAnalysisResponse(string $content): array
  {
    Log::info('Job Analysis raw response (first 500 chars): ' . substr($content, 0, 500));

    $json = $content;

    // Try to extract JSON from markdown code block
    if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $content, $matches)) {
      $json = $matches[1];
    }
    // Try to find JSON object pattern
    elseif (preg_match('/\{[\s\S]*"overall_match_score"[\s\S]*\}/', $content, $matches)) {
      $json = $matches[0];
    }

    $json = trim($json);

    // Try to fix truncated JSON
    if (substr($json, -1) !== '}') {
      $lastBrace = strrpos($json, '}');
      if ($lastBrace !== false) {
        $json = substr($json, 0, $lastBrace + 1);
      }
    }

    $decoded = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      Log::warning('Failed to parse job analysis JSON: ' . json_last_error_msg());
      return $this->getDefaultJobAnalysis();
    }

    return $decoded;
  }

  /**
   * Get default job analysis structure for fallback.
   */
  protected function getDefaultJobAnalysis(): array
  {
    return [
      'overall_match_score' => 0,
      'match_summary' => 'Analysis could not be completed. Please try again.',
      'gap_analysis' => ['missing_skills' => [], 'missing_qualifications' => [], 'experience_gaps' => []],
      'strengths_assessment' => ['skill_matches' => [], 'relevant_experience' => [], 'achievements_aligned' => []],
      'weakness_identification' => ['skill_weaknesses' => [], 'experience_shortfalls' => [], 'presentation_issues' => []],
      'resume_optimization_suggestions' => ['keyword_optimizations' => [], 'content_recommendations' => [], 'formatting_improvements' => []],
      'interview_prep_focus_areas' => ['strengths_to_emphasize' => [], 'weaknesses_to_address' => [], 'key_stories_to_prepare' => [], 'technical_topics_to_review' => []],
      'next_steps' => ['immediate_actions' => [], 'long_term_improvements' => [], 'interview_preparation_priority' => 'medium'],
    ];
  }

}
