<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;

class TamSamSomSeeder extends Seeder
{
    public function run()
    {
        $tool = Tool::where('slug', 'tam-sam-som')->first();

        if (!$tool) {
            $this->command->error('TAM/SAM/SOM tool not found. Please run ToolSeeder first.');
            return;
        }

        $tool->update([
            'description' => 'Calculate your Total Addressable Market (TAM), Serviceable Available Market (SAM), and Serviceable Obtainable Market (SOM) to validate your business opportunity.',
            'content' => $this->getMarkdownContent(),
            'faqs' => $this->getFaqs(),
            'time_estimate' => '15 mins',
            'difficulty' => 'Advanced'
        ]);

        $this->command->info('TAM/SAM/SOM content updated successfully.');
    }

    private function getMarkdownContent()
    {
        return <<<EOT
## Understanding Market Sizing

Market sizing is the process of estimating the potential of a market. It's crucial for understanding the viability of a business idea, securing investment, and setting realistic growth targets. The most common framework for this is **TAM, SAM, SOM**.

### 1. TAM (Total Addressable Market)
**"How big is the universe?"**

TAM represents the total market demand for a product or service. It's the maximum amount of revenue a business could generate if it had 100% market share and faced no competition.

*   **Example**: The global market for project management software.
*   **Why it matters**: It shows the long-term potential and scalability of the opportunity.

### 2. SAM (Serviceable Available Market)
**"How much of the universe can my reach?"**

SAM is the segment of the TAM targeted by your products and services which is within your geographical reach.

*   **Example**: Project management software for small creative agencies in North America (English speaking).
*   **Why it matters**: It sets the realistic ceiling for your medium-term growth.

### 3. SOM (Serviceable Obtainable Market)
**"How much can I capture?"**

SOM is the portion of the SAM that you can capture. It considers your current resources, competition, and go-to-market strategy. This is your short-term target (1-3 years).

*   **Example**: Capturing 5% of the creative agency market in North America within 2 years.
*   **Why it matters**: It's your most important metric for short-term financial planning and sales targets.

---

## Calculation Approaches

### Top-Down Approach
Uses industry reports and market research data.
*   **Formula**: Total Industry Value x % of Market Relevant to You
*   **Pros**: Fast, good for macro validation.
*   **Cons**: Often overly optimistic, lacks specific detail.

### Bottom-Up Approach
Uses your own data (pricing, expected customers).
*   **Formula**: (Total Number of Potential Customers) x (Average Annual Revenue per Customer)
*   **Pros**: More accurate, defensible to investors.
*   **Cons**: Requires more research and specific data points.
EOT;
    }

    private function getFaqs()
    {
        return [
            [
                'question' => 'Why is SOM usually much smaller than SAM?',
                'answer' => 'SOM accounts for real-world constraints like competition, lack of brand awareness, limited marketing budget, and operational capacity. It represents what you can actually execute on, not just what\'s theoretically available.'
            ],
            [
                'question' => 'Should I use Top-Down or Bottom-Up?',
                'answer' => 'Investors heavily prefer the Bottom-Up approach because it proves you understand your unit economics and customer base. Top-Down is useful for a quick "sanity check" but shouldn\'t be your primary method.'
            ],
            [
                'question' => 'What is a "good" TAM?',
                'answer' => 'It depends on your goals. For venture-backed startups, investors typically look for a TAM >$1 Billion to justify the risk. For lifestyle or niche businesses, a smaller TAM (e.g., $50M) can still support a highly profitable company.'
            ],
            [
                'question' => 'How often should I update these numbers?',
                'answer' => 'You should revisit your SOM every 6-12 months as your capacity and market share change. TAM and SAM should be reviewed if you pivot your product, enter new markets, or if there are significant industry shifts.'
            ]
        ];
    }
}
