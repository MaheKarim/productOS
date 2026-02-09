<?php

namespace App\Services\Interview;

use App\Services\AiProviderService;
use Illuminate\Support\Facades\Log;

class InterviewQuestionGeneratorService
{
    protected AiProviderService $aiService;

    public function __construct(AiProviderService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate interview questions based on resume analysis weaknesses.
     */
    public function generateQuestionsFromWeaknesses(array $weaknesses, string $jobTitle, string $jobDescription): array
    {
        $provider = $this->aiService->getActiveProvider();

        if (!$provider) {
            throw new \Exception('No AI provider available for question generation.');
        }

        // Increase time limit for AI processing
        set_time_limit(120);

        $prompt = $this->buildWeaknessBasedPrompt($weaknesses, $jobTitle, $jobDescription);

        try {
            $response = $this->aiService->makeCompletionRequestWithFailover(
                $provider,
                $provider->default_model,
                [['role' => 'user', 'content' => $prompt]],
                ['max_tokens' => 2048]
            );

            if (!$response['success']) {
                Log::error('Interview question generation failed: ' . ($response['error'] ?? 'Unknown'));
                return $this->getDefaultQuestions($weaknesses, $jobTitle);
            }

            $content = $response['data']['choices'][0]['message']['content'];
            $questions = $this->parseQuestionsResponse($content);

            return $questions;

        } catch (\Exception $e) {
            Log::error('Interview question generation error: ' . $e->getMessage());
            return $this->getDefaultQuestions($weaknesses, $jobTitle);
        }
    }

    /**
     * Build AI prompt for generating weakness-based questions.
     */
    protected function buildWeaknessBasedPrompt(array $weaknesses, string $jobTitle, string $jobDescription): string
    {
        $weaknessText = $this->formatWeaknessesForPrompt($weaknesses);
        
        return <<<PROMPT
You are an expert interview coach. Based on the candidate's resume analysis, generate targeted interview questions that address their identified weaknesses and knowledge gaps for the {$jobTitle} position.

JOB DESCRIPTION:
{$jobDescription}

IDENTIFIED WEAKNESSES:
{$weaknessText}

Generate a comprehensive set of interview questions that will help the candidate demonstrate their knowledge and address their weaknesses. Questions should be:

1. Specific to the identified gaps
2. Progressive in difficulty
3. Mix of technical and behavioral questions
4. Include follow-up questions to probe deeper

Return ONLY a JSON array with this structure:
[
  {
    "question": "Main interview question",
    "type": "technical|behavioral|situational",
    "category": "category of weakness being addressed",
    "difficulty": "beginner|intermediate|advanced",
    "follow_up": ["follow-up question 1", "follow-up question 2"],
    "ideal_answer": "What a strong answer should include",
    "common_pitfalls": ["common mistake 1", "common mistake 2"]
  }
]

Generate 8-12 questions that comprehensively cover the identified weaknesses. Make questions challenging but fair.
PROMPT;
    }

    /**
     * Format weaknesses for the AI prompt.
     */
    protected function formatWeaknessesForPrompt(array $weaknesses): string
    {
        if (empty($weaknesses)) {
            return "No specific weaknesses identified. Generate general job-related questions.";
        }

        $formatted = "";
        foreach ($weaknesses as $weakness) {
            $type = ucfirst($weakness['type']);
            $item = $weakness['item'];
            $importance = ucfirst($weakness['importance'] ?? 'medium');
            $suggestion = $weakness['suggestion'] ?? 'No specific suggestion provided';
            
            $formatted .= "- {$type}: {$item} (Importance: {$importance})\n";
            $formatted .= "  Suggestion: {$suggestion}\n\n";
        }

        return trim($formatted);
    }

    /**
     * Parse the AI response for questions.
     */
    protected function parseQuestionsResponse(string $content): array
    {
        Log::info('Interview questions raw response (first 500 chars): ' . substr($content, 0, 500));

        $json = $content;

        // Try to extract JSON from markdown code block
        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $content, $matches)) {
            $json = $matches[1];
        }
        // Try to find JSON array pattern
        elseif (preg_match('/\[[\s\S]*\]/', $content, $matches)) {
            $json = $matches[0];
        }

        $json = trim($json);
        $decoded = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            Log::warning('Failed to parse interview questions JSON: ' . json_last_error_msg());
            return $this->getDefaultQuestions([], 'Unknown Position');
        }

        // Validate and clean the questions
        $validatedQuestions = [];
        foreach ($decoded as $index => $question) {
            if (isset($question['question']) && is_string($question['question'])) {
                $validatedQuestions[] = [
                    'id' => $index + 1,
                    'question' => $question['question'],
                    'type' => $question['type'] ?? 'technical',
                    'category' => $question['category'] ?? 'general',
                    'difficulty' => $question['difficulty'] ?? 'intermediate',
                    'follow_up' => is_array($question['follow_up']) ? $question['follow_up'] : [],
                    'ideal_answer' => $question['ideal_answer'] ?? 'A comprehensive answer addressing the question with specific examples.',
                    'common_pitfalls' => is_array($question['common_pitfalls']) ? $question['common_pitfalls'] : [],
                    'user_answer' => '',
                    'score' => null,
                    'feedback' => '',
                ];
            }
        }

        return $validatedQuestions;
    }

    /**
     * Get default questions when AI fails.
     */
    protected function getDefaultQuestions(array $weaknesses, string $jobTitle): array
    {
        $questions = [
            [
                'id' => 1,
                'question' => "Tell me about a time when you had to learn a new skill quickly to complete a project.",
                'type' => 'behavioral',
                'category' => 'adaptability',
                'difficulty' => 'intermediate',
                'follow_up' => ["What was the outcome?", "How did you approach the learning process?"],
                'ideal_answer' => 'STAR method answer showing initiative, learning strategy, and successful outcome.',
                'common_pitfalls' => ['Being too general', 'Not showing the learning process'],
                'user_answer' => '',
                'score' => null,
                'feedback' => '',
            ],
            [
                'id' => 2,
                'question' => "What interests you most about this {$jobTitle} position?",
                'type' => 'motivational',
                'category' => 'interest',
                'difficulty' => 'beginner',
                'follow_up' => ["How does this align with your career goals?", "What specific aspects excite you?"],
                'ideal_answer' => 'Specific reasons tied to job description and personal growth.',
                'common_pitfalls' => ['Generic answers', 'Focusing only on salary/benefits'],
                'user_answer' => '',
                'score' => null,
                'feedback' => '',
            ],
            [
                'id' => 3,
                'question' => "Describe a challenging situation you faced in your previous role and how you handled it.",
                'type' => 'behavioral',
                'category' => 'problem-solving',
                'difficulty' => 'intermediate',
                'follow_up' => ["What would you do differently now?", "What did you learn from this experience?"],
                'ideal_answer' => 'STAR method showing problem identification, action steps, and positive outcome.',
                'common_pitfalls' => ['Blaming others', 'Not taking responsibility'],
                'user_answer' => '',
                'score' => null,
                'feedback' => '',
            ],
            [
                'id' => 4,
                'question' => "Where do you see yourself in 3-5 years?",
                'type' => 'career',
                'category' => 'goals',
                'difficulty' => 'beginner',
                'follow_up' => ["How does this role fit into that vision?", "What steps are you taking to get there?"],
                'ideal_answer' => 'Ambitious but realistic goals tied to company growth and role progression.',
                'common_pitfalls' => ['No clear direction', 'Unrealistic expectations'],
                'user_answer' => '',
                'score' => null,
                'feedback' => '',
            ],
            [
                'id' => 5,
                'question' => "What questions do you have for me about this role or our company?",
                'type' => 'interactive',
                'category' => 'engagement',
                'difficulty' => 'beginner',
                'follow_up' => [],
                'ideal_answer' => 'Thoughtful questions showing research and genuine interest.',
                'common_pitfalls' => ['No questions', 'Questions easily found online'],
                'user_answer' => '',
                'score' => null,
                'feedback' => '',
            ]
        ];

        return $questions;
    }
}