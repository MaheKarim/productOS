<?php

namespace App\Services\AI;

use App\Models\AiProvider;
use Illuminate\Support\Facades\Log;

class AiGradingService
{
    protected $aiProcessingService;

    public function __construct(AiProcessingService $aiProcessingService)
    {
        $this->aiProcessingService = $aiProcessingService;
    }

    public function gradeAnswer(string $question, string $userAnswer, array $modelAnswers, string $explanation = null)
    {
        // Use default provider or configurable
        $provider = AiProvider::first(); // Simplification: Grab first available
        if (!$provider) {
            throw new \Exception("No AI Provider configured for grading.");
        }

        $modelAnswerText = implode("\nOR\n", $modelAnswers);

        $prompt = <<<EOT
You are an expert examiner grading a student's answer.

Question: "{$question}"

Model Answer(s):
"{$modelAnswerText}"

Additional Context/Explanation:
"{$explanation}"

Student Answer:
"{$userAnswer}"

Task:
1. Evaluate the student's answer against the model answer and context.
2. Assign a score from 0 to 10 (10 being perfect).
3. Provide brief, constructive feedback explaining the score and how to improve.

Output JSON only:
{
    "score": 8,
    "feedback": "Good understanding of the core concept, but missed..."
}
EOT;

        try {
            $result = $this->aiProcessingService->processText($userAnswer, $prompt, $provider);

            // Handle cases where processText might return a string if JSON parse fails inside it (depending on implementation)
            // Assuming processText returns array if JSON is valid.
            if (is_array($result) && isset($result['score'])) {
                return $result;
            }

            // If standard JSON parsing in service failed but we got text, try to extract JSON? 
            // Ideally service handles this. We'll assume service returns array.

            return [
                'score' => 0,
                'feedback' => 'Failed to parse AI response.',
                'raw' => $result
            ];

        } catch (\Exception $e) {
            Log::error("Grading failed: " . $e->getMessage());
            return [
                'score' => 0,
                'feedback' => 'Error during grading process. Please try again later.'
            ];
        }
    }
}
