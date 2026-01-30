<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemPrompt;

class StrategicRoadmapPromptSeeder extends Seeder
{
    public function run()
    {
        $prompts = [
            [
                'name' => 'Junior PM Roadmap Guide',
                'description' => 'Guidance for Junior PMs focusing on fundamentals and 90-day action plans.',
                'content' => "ROLE: Senior Product Strategy Consultant specializing in {product_type}\nCONTEXT: User is at {product_stage} with {team_size} team, targeting {market}\nUSER LEVEL: {user_experience_level}\nCHALLENGES: {challenges_list}\nUSER GOAL: {user_goal}\n\nTASK: Generate {roadmap_type} roadmap with:\n1. {framework_type} metric framework\n2. {timeline} strategic plan\n3. {complexity_level} execution detail\n4. {communication_style} recommendations\n\nOUTPUT: JSON structured for {ui_component} visualization",
                'type' => 'strategic_roadmap',
                'is_default' => true,
            ],
            [
                'name' => 'Mid-Level PM Roadmap Guide',
                'description' => 'Guidance for Mid-Level PMs focusing on OKRs, prioritization, and execution.',
                'content' => "ROLE: Senior Product Strategy Consultant specializing in {product_type}\nCONTEXT: User is at {product_stage} with {team_size} team, targeting {market}\nUSER LEVEL: {user_experience_level}\nCHALLENGES: {challenges_list}\nUSER GOAL: {user_goal}\n\nTASK: Generate {roadmap_type} roadmap with:\n1. {framework_type} metric framework\n2. {timeline} strategic plan\n3. {complexity_level} execution detail\n4. {communication_style} recommendations\n\nOUTPUT: JSON structured for {ui_component} visualization",
                'type' => 'strategic_roadmap',
                'is_default' => true,
            ],
            [
                'name' => 'Senior PM / Founder Strategic Guide',
                'description' => 'Guidance for Executives focusing on long-term strategy, org design, and market leadership.',
                'content' => "ROLE: Senior Product Strategy Consultant specializing in {product_type}\nCONTEXT: User is at {product_stage} with {team_size} team, targeting {market}\nUSER LEVEL: {user_experience_level}\nCHALLENGES: {challenges_list}\nUSER GOAL: {user_goal}\n\nTASK: Generate {roadmap_type} roadmap with:\n1. {framework_type} metric framework\n2. {timeline} strategic plan\n3. {complexity_level} execution detail\n4. {communication_style} recommendations\n\nOUTPUT: JSON structured for {ui_component} visualization",
                'type' => 'strategic_roadmap',
                'is_default' => true,
            ],
        ];

        foreach ($prompts as $prompt) {
            SystemPrompt::updateOrCreate(
                ['name' => $prompt['name']],
                $prompt
            );
        }
    }
}
