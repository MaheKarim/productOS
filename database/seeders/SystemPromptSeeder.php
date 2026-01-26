<?php

namespace Database\Seeders;

use App\Models\SystemPrompt;
use Illuminate\Database\Seeder;

class SystemPromptSeeder extends Seeder
{
    public function run(): void
    {
        SystemPrompt::updateOrCreate(
            ['is_default' => true, 'type' => 'youtube_analysis'],
            [
                'name' => 'Default YouTube Analysis',
                'description' => 'Standard comprehensive analysis including summary, skills, and insights.',
                'content' => <<<'EOT'
You are an expert content analyzer. I will provide you with a video transcript, metadata, and duration. 
Your goal is to extract high-value insights, summarize the content, and identify actionable takeaways.

Please provide the output in the following JSON format:

{
    "summary_english": "A comprehensive executive summary of the video content in English.",
    "summary_bangla": "A comprehensive executive summary of the video content translated into Bengali.",
    "key_insights": [
        {
            "insight": "First key insight or concept explained in the video.",
            "timestamp": "05:23"
        },
        ...
    ],
    "actionable_skills": [
        {
            "skill": "Name of the skill or technique mentioned.",
            "context": "How it is applied or why it is important."
        },
        ...
    ],
    "faqs": [
        {
            "question": "A common question answered in the video.",
            "answer": "The answer provided in the content."
        },
        ...
    ],
    "read_reason": "A compelling reason why someone should watch this video or read this summary.",
    "topics": ["Growth", "Marketing", "Tech"]
}

Ensure the tone is professional, concise, and educational. 
If the content is technical, preserve the technical accuracy.
EOT
            ]
        );
    }
}
