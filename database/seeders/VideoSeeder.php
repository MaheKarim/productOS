<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;
use App\Models\AiOutput;
use App\Models\AiProvider;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure at least one AI provider exists
        if (AiProvider::count() === 0) {
            AiProvider::create([
                'name' => 'OpenAI',
                'slug' => 'openai',
                'is_active' => true,
                'default_model' => 'gpt-4o'
            ]);
        }

        // Create 10 Free Videos (Completed)
        Video::factory()
            ->count(10)
            ->free()
            ->completed()
            ->create()
            ->each(function ($video) {
                $this->createAiOutput($video);
            });

        // Create 10 Premium Videos (Completed)
        Video::factory()
            ->count(10)
            ->premium()
            ->completed()
            ->create()
            ->each(function ($video) {
                $this->createAiOutput($video);
            });

        $this->command->info('20 Demo Videos created (10 Free, 10 Premium) with AI Outputs.');
    }

    private function createAiOutput(Video $video)
    {
        AiOutput::create([
            'video_id' => $video->id,
            'summary_english' => 'This is a demo executive summary for the video titled "' . $video->title . '". It covers the main points discussed in the video.',
            'summary_bangla' => 'এটি ভিডিওটির একটি ডেমো সারসংক্ষেপ। এটি ভিডিওতে আলোচিত মূল পয়েন্টগুলি কভার করে।',
            'key_insights' => [
                ['insight' => 'First key insight from the video.', 'timestamp' => '01:30'],
                ['insight' => 'Second important takeaway.', 'timestamp' => '03:45'],
                ['insight' => 'Third actionable point.', 'timestamp' => '05:20'],
            ],
            'actionable_skills' => [
                ['skill' => 'Communication', 'context' => 'Effective speaking tips.'],
                ['skill' => 'Coding', 'context' => 'Better code structure.'],
            ],
            'faqs' => [
                ['question' => 'What is this video about?', 'answer' => 'This is a demo video explanation.'],
                ['question' => 'Who is it for?', 'answer' => 'Everyone learning tech.'],
            ],
            'read_reason' => 'You should watch this to learn about key tech concepts quickly.',
            'generated_at' => now(),
        ]);
    }
}
