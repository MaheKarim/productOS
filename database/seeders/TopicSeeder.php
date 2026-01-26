<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'Growth Strategy' => ['growth', 'marketing', 'user acquisition', 'scaling', 'virality'],
            'Leadership & Management' => ['leadership', 'hiring', 'team building', 'culture', 'management'],
            'Product Management' => ['product', 'roadmap', 'prioritization', 'discovery', 'user research'],
            'Fundraising & VC' => ['fundraising', 'venture capital', 'pitching', 'investor', 'equity'],
            'Marketing & Positioning' => ['branding', 'positioning', 'storytelling', 'copywriting'],
            'Sales & Customer Acquisition' => ['sales', 'b2b', 'negotiation', 'closing', 'pipeline'],
            'Engineering & Technical' => ['engineering', 'tech stack', 'architecture', 'coding', 'cto'],
            'Design & UX' => ['design', 'ui', 'ux', 'user experience', 'prototyping'],
            'Operations & Scaling' => ['operations', 'processes', 'workflow', 'automation', 'logistics'],
            'Mental Models & Frameworks' => ['mental models', 'decision making', 'frameworks', 'productivity'],
            'SaaS' => ['saas', 'subscription', 'churn', 'arr', 'mrr'],
            'E-commerce' => ['e-commerce', 'dtc', 'retail', 'inventory', 'shopify'],
        ];

        foreach ($topics as $name => $keywords) {
            Topic::firstOrCreate(
                ['name' => $name],
                [
                    'slug' => \Illuminate\Support\Str::slug($name),
                    'keywords' => $keywords,
                ]
            );
        }
    }
}
