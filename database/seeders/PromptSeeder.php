<?php

namespace Database\Seeders;

use App\Models\Prompt;
use App\Models\PromptCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = PromptCategory::all()->keyBy('slug');

        $prompts = [
            // Strategy & Planning
            [
                'title' => 'Product Roadmap Generator',
                'category' => 'strategy-planning',
                'ai_tool' => 'claude',
                'difficulty_level' => 'intermediate',
                'use_case_tags' => ['roadmap', 'planning', 'quarterly'],
                'is_featured' => true,
                'description' => 'Generate a comprehensive product roadmap with themes, initiatives, and milestones for the next 4 quarters.',
                'prompt_text' => 'Act as a Senior Product Manager with 10+ years of experience in product strategy and roadmap planning.

I need you to create a comprehensive product roadmap for my product. Here are the details:

**Product Context:**
- Product Name: [Your product name]
- Industry: [Your industry]
- Current Stage: [Early stage / Growth / Mature]
- Team Size: [Number of engineers, designers, etc.]

**Business Goals:**
- [Goal 1]
- [Goal 2]
- [Goal 3]

**Key User Personas:**
- [Persona 1]: [Brief description]
- [Persona 2]: [Brief description]

**Current Pain Points / Opportunities:**
- [Pain point 1]
- [Pain point 2]

Please create a 4-quarter roadmap with:
1. **Quarterly Themes** - High-level focus areas for each quarter
2. **Key Initiatives** - 3-5 major features/improvements per quarter
3. **Success Metrics** - How we\'ll measure success for each initiative
4. **Dependencies & Risks** - What could block or delay delivery
5. **Resource Allocation** - Suggested team distribution

Format the roadmap as a visual timeline with clear milestones and dependencies.',
                'example_output' => '## Q1 2024: Foundation & Core Experience

**Theme:** Strengthen the core product experience

### Key Initiatives:
1. **Performance Optimization** (6 weeks)
   - Target: <2s page load time
   - Metric: 40% improvement in Core Web Vitals

2. **Onboarding Redesign** (4 weeks)
   - Target: 50% reduction in time-to-value
   - Metric: Activation rate from 30% → 50%

...',
                'tips' => [
                    'Be specific about your product context',
                    'Include actual business metrics and goals',
                    'Mention any constraints (budget, team, deadline)',
                ],
            ],

            [
                'title' => 'OKR Setting Framework',
                'category' => 'strategy-planning',
                'ai_tool' => 'chatgpt',
                'difficulty_level' => 'beginner',
                'use_case_tags' => ['okr', 'goals', 'objectives'],
                'is_featured' => true,
                'description' => 'Create well-structured OKRs (Objectives and Key Results) for your team or product.',
                'prompt_text' => 'You are an OKR coach with expertise in helping product teams set ambitious yet achievable goals.

Help me create OKRs for my product/team with the following context:

**Team/Product:** [Name]
**Time Period:** [Q1 2024 / H1 2024 / Annual]
**Company-Level Objectives:** 
- [Company OKR 1]
- [Company OKR 2]

**Current Challenges:**
- [Challenge 1]
- [Challenge 2]

**Available Resources:**
- Team size: [X]
- Budget constraints: [Any limitations]

Please create 3-5 Objectives with 3-4 Key Results each. For each OKR:
1. Make Objectives inspirational and qualitative
2. Make Key Results measurable and specific
3. Include baseline and target metrics
4. Rate confidence level (0-10) for each KR
5. Suggest initiatives that could drive each KR

Follow the format:
**Objective:** [Inspiring statement]
- KR1: [Metric] from [baseline] to [target]
- KR2: ...

Also provide:
- Weekly check-in template
- Red/yellow/green scoring criteria
- Common pitfalls to avoid',
                'example_output' => '## Objective 1: Become the go-to solution for enterprise teams

**Key Results:**
- KR1: Increase enterprise pipeline from $500K to $2M (Confidence: 7/10)
- KR2: Improve enterprise NPS from 32 to 50 (Confidence: 6/10)
- KR3: Reduce time-to-deploy from 4 weeks to 1 week (Confidence: 8/10)

**Initiatives:**
- Launch enterprise onboarding program
- Build SSO and SAML integration
- Create enterprise-specific documentation...',
                'tips' => [
                    'Start with company-level objectives',
                    'Include actual baseline metrics',
                    'Set ambitious but achievable targets',
                ],
            ],

            // Product Execution
            [
                'title' => 'PRD Generator for Features',
                'category' => 'product-execution',
                'ai_tool' => 'claude',
                'difficulty_level' => 'intermediate',
                'use_case_tags' => ['prd', 'feature', 'specification'],
                'is_featured' => true,
                'description' => 'Generate a comprehensive Product Requirements Document for any feature.',
                'prompt_text' => 'Act as a Senior Product Manager at a top-tier tech company. Create a comprehensive PRD (Product Requirements Document) for the following feature:

**Feature Overview:**
- Feature Name: [Name]
- One-liner: [Brief description]
- Target Release: [Timeline]

**Problem Statement:**
[Describe the problem you\'re solving]

**Target Users:**
[Who will use this feature?]

**Business Context:**
- Why now? [Strategic timing]
- Business impact: [Expected outcomes]

Please create a PRD with the following sections:

1. **Executive Summary**
   - Problem statement
   - Proposed solution
   - Key success metrics

2. **Goals & Non-Goals**
   - What we\'re trying to achieve
   - What\'s explicitly out of scope

3. **User Stories**
   - As a [user], I want [goal], so that [benefit]
   - Include acceptance criteria for each

4. **Detailed Requirements**
   - Functional requirements (numbered)
   - Non-functional requirements (performance, security)
   - Edge cases and error handling

5. **Design Considerations**
   - UX principles
   - Key user flows
   - Accessibility requirements

6. **Technical Considerations**
   - Architecture implications
   - API requirements
   - Data model changes

7. **Launch Plan**
   - Rollout strategy (% rollout, beta groups)
   - Feature flags
   - Rollback plan

8. **Success Metrics**
   - Primary metrics
   - Secondary metrics
   - How we\'ll measure

9. **Open Questions & Risks**
   - Unresolved decisions
   - Dependencies
   - Risk mitigation',
                'example_output' => '# PRD: In-App Notifications System

## Executive Summary
### Problem
Users currently miss important updates because we only send email notifications...

### Proposed Solution
Build an in-app notification center with real-time updates...

### Key Metrics
- 40% reduction in support tickets about "missed updates"
- 60% notification open rate within 24 hours...',
                'tips' => [
                    'Include specific user research findings',
                    'Add mockups or wireframe references',
                    'Define clear success criteria upfront',
                ],
            ],

            [
                'title' => 'User Story Generator',
                'category' => 'product-execution',
                'ai_tool' => 'universal',
                'difficulty_level' => 'beginner',
                'use_case_tags' => ['user-story', 'agile', 'backlog'],
                'is_featured' => false,
                'description' => 'Generate well-structured user stories with acceptance criteria for your backlog.',
                'prompt_text' => 'You are an Agile coach and experienced Product Owner. Help me write user stories for the following feature/epic:

**Feature/Epic:** [Name]
**Description:** [Brief overview]
**Target User(s):** [Who uses this]

**Existing User Journey:**
1. [Current step 1]
2. [Current step 2]
3. [Pain points in current journey]

**Desired Outcome:**
[What should the user be able to do after this feature?]

Please generate:

1. **Epic Description** (2-3 sentences)

2. **User Stories** (8-12 stories, prioritized)
   For each story, include:
   - Story: As a [user type], I want [goal] so that [benefit]
   - Acceptance Criteria (3-5 bullet points using Given/When/Then)
   - Estimation: S/M/L/XL
   - Priority: Must-have / Should-have / Nice-to-have
   - Dependencies: [Other stories this depends on]

3. **Edge Cases** (as separate stories)

4. **Technical Stories** (if applicable)

Use the INVEST criteria:
- Independent
- Negotiable
- Valuable
- Estimable
- Small
- Testable',
                'example_output' => '## Epic: User Profile Management

Users can view and edit their profile information, manage preferences, and control privacy settings.

### User Stories

**Story 1: View Profile** (Priority: Must-have, Size: S)
As a registered user, I want to view my profile page so that I can see my current information.

**Acceptance Criteria:**
- Given I am logged in
- When I click on my avatar/profile icon
- Then I see my profile page with: name, email, avatar, bio, join date

...',
                'tips' => [
                    'Include the full user journey context',
                    'Think about error states and edge cases',
                    'Group related stories together',
                ],
            ],

            // User Research
            [
                'title' => 'User Interview Script Generator',
                'category' => 'user-research',
                'ai_tool' => 'chatgpt',
                'difficulty_level' => 'intermediate',
                'use_case_tags' => ['interview', 'research', 'discovery'],
                'is_featured' => true,
                'description' => 'Create a structured user interview script with warm-up, core questions, and follow-ups.',
                'prompt_text' => 'Act as a UX Researcher with expertise in qualitative research methods. Create a comprehensive user interview script for the following research:

**Research Objective:**
[What are you trying to learn?]

**Target Participant:**
- Role/Title: [Job title or user type]
- Experience: [Relevant experience level]
- Screening criteria: [How to identify right participants]

**Product Context:**
- Product: [Your product]
- Feature/Area of focus: [Specific area to explore]

**Research Questions (high-level):**
1. [Question 1]
2. [Question 2]
3. [Question 3]

Please create an interview guide with:

1. **Introduction (5 min)**
   - Greeting and rapport building
   - Research purpose explanation
   - Consent and recording permission
   - Any initial questions from participant

2. **Warm-up Questions (5-10 min)**
   - Background and context questions
   - Current workflow/behavior exploration

3. **Core Questions (25-30 min)**
   - Open-ended questions about the topic
   - Follow-up probes for each question
   - "Tell me about a time when..." prompts

4. **Specific Concept Testing (10 min)**
   - Questions about specific features/ideas
   - Reaction gathering techniques

5. **Wrap-up (5 min)**
   - Summary and clarification
   - Additional thoughts invitation
   - Next steps explanation

Also include:
- 🔍 Probing questions for each section
- ⚠️ Questions to avoid (leading, biased)
- 📝 Note-taking template
- ⏱️ Time allocation per section',
                'example_output' => '## User Interview Script: Onboarding Experience Research

### Introduction (5 min)
"Hi [Name], thank you for taking the time to speak with me today. My name is [Your name] and I\'m researching how people get started with new software tools...

### Warm-up Questions
1. Can you tell me about your role and what a typical day looks like?
   - Probe: What tools do you use most frequently?
   
2. When was the last time you tried a new work tool? Walk me through that experience.
   - Probe: What made you decide to try it?...',
                'tips' => [
                    'Keep questions open-ended',
                    'Prepare more questions than you need',
                    'Practice the flow beforehand',
                    'Leave room for unexpected insights',
                ],
            ],

            // Analytics & Metrics
            [
                'title' => 'Product Metrics Framework',
                'category' => 'analytics-metrics',
                'ai_tool' => 'claude',
                'difficulty_level' => 'advanced',
                'use_case_tags' => ['metrics', 'kpi', 'analytics'],
                'is_featured' => false,
                'description' => 'Define a comprehensive metrics framework for measuring product success.',
                'prompt_text' => 'You are a data-driven Product Manager with expertise in product analytics. Help me create a comprehensive metrics framework for my product:

**Product Context:**
- Product: [Name and description]
- Business Model: [SaaS / Marketplace / E-commerce / etc.]
- Stage: [Early / Growth / Mature]
- Current North Star Metric: [If any]

**Key User Actions:**
1. [Action 1 - e.g., "Creates a project"]
2. [Action 2 - e.g., "Invites team member"]
3. [Action 3 - e.g., "Exports report"]

**Business Goals:**
- [Goal 1]
- [Goal 2]

Please create a metrics framework with:

1. **North Star Metric**
   - The single metric that captures core value
   - Why this metric matters
   - How to calculate it

2. **Input Metrics (3-5)**
   - Metrics that drive the North Star
   - Leading indicators of success

3. **Health Metrics by Category:**
   
   **Acquisition**
   - Metric, calculation, benchmark, alert threshold
   
   **Activation**
   - Time to value metrics
   - Activation rate definition
   
   **Engagement**
   - DAU/WAU/MAU and ratios
   - Feature adoption metrics
   
   **Retention**
   - Cohort retention curves
   - Churn indicators
   
   **Revenue** (if applicable)
   - MRR/ARR, expansion, contraction

4. **Instrumentation Plan**
   - Events to track
   - Properties for each event
   - Recommended tools

5. **Dashboard Design**
   - Key charts and visualizations
   - Refresh frequency
   - Alert rules',
                'example_output' => '## Metrics Framework: [Product Name]

### North Star Metric
**Weekly Active Projects Created**
- Definition: Number of unique projects with at least 3 tasks created in the past 7 days
- Why: Represents core value delivery - users actively using the product to manage work

### Input Metrics
1. **New User Activation Rate**
   - % of signups who create first project within 24 hours
   - Target: 40%

2. **Team Collaboration Score**
   - Average team members per project
   - Target: 3+...',
                'tips' => [
                    'Start with business outcomes',
                    'Include both leading and lagging indicators',
                    'Define clear calculation methods',
                ],
            ],

            [
                'title' => 'Feature Prioritization (RICE)',
                'category' => 'analytics-metrics',
                'ai_tool' => 'universal',
                'difficulty_level' => 'intermediate',
                'use_case_tags' => ['prioritization', 'RICE', 'roadmap'],
                'is_featured' => true,
                'description' => 'Prioritize your feature backlog using the RICE scoring framework.',
                'prompt_text' => 'Act as a Product Manager experienced in prioritization frameworks. Help me prioritize my feature backlog using the RICE framework (Reach, Impact, Confidence, Effort).

**Product Context:**
- Product: [Name]
- Current user base: [Number]
- Time period for planning: [Quarter/Half]

**Features to Evaluate:**
1. [Feature 1 - brief description]
2. [Feature 2 - brief description]
3. [Feature 3 - brief description]
4. [Feature 4 - brief description]
5. [Feature 5 - brief description]

**Available Data:**
- [Any relevant metrics or user research]

For each feature, please provide:

1. **RICE Score Breakdown:**
   - **Reach**: How many users will this impact per quarter? (number)
   - **Impact**: What is the impact per user? (0.25/0.5/1/2/3 scale)
   - **Confidence**: How confident are we? (100%/80%/50%)
   - **Effort**: Person-months required (number)
   - **Final Score**: (R × I × C) / E

2. **Scoring Rationale:**
   - Why this reach estimate?
   - What\'s the expected impact?
   - What affects confidence?

3. **Final Prioritized List:**
   - Ranked by RICE score
   - Recommendations for next quarter

4. **Sensitivity Analysis:**
   - Which scores are most uncertain?
   - How would different assumptions change ranking?

Also suggest:
- Quick wins (high score, low effort)
- Strategic bets (high impact, lower confidence)
- Features to deprioritize or kill',
                'example_output' => '## RICE Prioritization Results

| Feature | Reach | Impact | Confidence | Effort | Score |
|---------|-------|--------|------------|--------|-------|
| Feature A | 10,000 | 2 | 80% | 2 | 8,000 |
| Feature B | 5,000 | 3 | 50% | 1 | 7,500 |
| Feature C | 20,000 | 1 | 80% | 4 | 4,000 |

### Recommendations
1. **Build Feature A first** - Highest score with good confidence
2. **Consider Feature B** - High impact but validate assumptions first...',
                'tips' => [
                    'Use consistent estimation methods',
                    'Include both quantitative and qualitative data',
                    'Review and adjust scores with the team',
                ],
            ],

            // Stakeholder Management
            [
                'title' => 'Executive Status Update Email',
                'category' => 'stakeholder-management',
                'ai_tool' => 'chatgpt',
                'difficulty_level' => 'beginner',
                'use_case_tags' => ['communication', 'executive', 'status-update'],
                'is_featured' => false,
                'description' => 'Write concise, impactful status update emails for executive stakeholders.',
                'prompt_text' => 'You are a Product Manager who excels at executive communication. Help me write a status update email for leadership.

**Project/Initiative:** [Name]
**Reporting Period:** [Week of X / Month of X]
**Audience:** [CEO, VP Product, entire leadership team]

**Current Status:**
- Overall: [🟢 On Track / 🟡 At Risk / 🔴 Off Track]
- Key milestone: [Latest milestone achieved or upcoming]

**Progress This Period:**
- [Accomplishment 1]
- [Accomplishment 2]
- [Key metric movement]

**Blockers/Risks:**
- [Blocker 1 and mitigation]
- [Risk 1 and mitigation]

**Needs from Leadership:**
- [Decision needed]
- [Resource ask]

Please write:

1. **Subject Line** - Clear and actionable

2. **TL;DR** (2-3 sentences max)
   - Status, key highlight, key ask

3. **Progress Summary** (bullet points)
   - What we accomplished
   - Key metrics

4. **Risks & Mitigations** (if any)
   - Brief, with owner and timeline

5. **Asks/Decisions Needed**
   - Specific and time-bound

6. **What\'s Next**
   - Next milestone and date

Keep total email under 200 words. Use formatting that\'s easy to scan on mobile.',
                'example_output' => '**Subject:** 🟢 Checkout Redesign: On Track | Need UX Review by Friday

**TL;DR:** Checkout redesign is on track for Q2 launch. Conversion tests showing +12% improvement. Need UX leadership review of mobile flows by Friday.

**Progress:**
✅ A/B test showing 12% conversion improvement (target: 10%)
✅ Payment integration complete
✅ Mobile designs finalized

**Risk:** 
🟡 Third-party API rate limits - mitigating with caching layer (ETA: Tuesday)

**Ask:**
Need 30-min review with UX leadership for mobile cart flow by Friday EOD.

**Next:** User acceptance testing starts Monday.',
                'tips' => [
                    'Lead with status and bottom line',
                    'Keep it scannable - executives are busy',
                    'Make asks specific and time-bound',
                ],
            ],

            // Documentation
            [
                'title' => 'Release Notes Generator',
                'category' => 'documentation',
                'ai_tool' => 'universal',
                'difficulty_level' => 'beginner',
                'use_case_tags' => ['release-notes', 'changelog', 'launch'],
                'is_featured' => false,
                'description' => 'Generate user-friendly release notes from technical changelogs.',
                'prompt_text' => 'Act as a Product Marketing Manager who specializes in user communications. Help me transform technical changes into user-friendly release notes.

**Product:** [Name]
**Version/Release:** [Version number or date]
**Release Type:** [Major / Minor / Patch]

**Technical Changes:**
```
[Paste your technical changelog, commit messages, or Jira tickets here]
```

**Target Audience:**
- [End users / Developers / Admins]
- Technical level: [Low / Medium / High]

Please create:

1. **Headline** - Catchy title for this release

2. **TL;DR** - One sentence summary

3. **✨ New Features**
   - Feature name
   - What it does (user benefit, not technical)
   - How to use it (brief)

4. **🔧 Improvements**
   - What improved
   - User impact

5. **🐛 Bug Fixes**
   - What was fixed
   - Who was affected

6. **⚠️ Breaking Changes** (if any)
   - What changed
   - Migration steps

7. **📚 Additional Resources**
   - Links to docs, videos, etc.

Style guidelines:
- Use simple language (8th grade reading level)
- Focus on benefits, not features
- Include example use cases
- Add relevant emojis for scannability',
                'example_output' => '# What\'s New in Version 2.5 🚀

**TL;DR:** Faster exports, dark mode, and a redesigned dashboard to help you work smarter.

## ✨ New Features

### Dark Mode
Finally! Easy on the eyes for late-night work sessions. Toggle it in Settings → Appearance.

### Bulk Export
Export up to 1,000 items at once. Perfect for quarterly reporting.
*How to use: Select items → Click "Export" → Choose format*

## 🔧 Improvements
- **Dashboard loads 40% faster** - No more waiting
- **Search now includes archived items** - Find anything, anytime...',
                'tips' => [
                    'Include technical details in a separate section',
                    'Link to help articles for complex features',
                    'Celebrate the team for major releases',
                ],
            ],

            [
                'title' => 'Competitive Analysis Framework',
                'category' => 'strategy-planning',
                'ai_tool' => 'claude',
                'difficulty_level' => 'advanced',
                'use_case_tags' => ['competitive', 'analysis', 'market-research'],
                'is_featured' => false,
                'description' => 'Conduct a comprehensive competitive analysis with actionable insights.',
                'prompt_text' => 'You are a Strategy Consultant with expertise in competitive intelligence. Help me conduct a comprehensive competitive analysis.

**My Product:**
- Name: [Your product]
- Category: [Product category]
- Target Market: [Who you serve]
- Key Differentiator: [What makes you unique]

**Competitors to Analyze:**
1. [Competitor 1] - [Brief description]
2. [Competitor 2] - [Brief description]
3. [Competitor 3] - [Brief description]

**Focus Areas:**
- [Specific features or aspects to compare]

Please provide:

1. **Market Landscape Overview**
   - Market size and growth
   - Key trends affecting all players
   - Customer segments

2. **Competitor Profiles** (for each)
   - Company overview (size, funding, stage)
   - Target customer
   - Core value proposition
   - Pricing model
   - Key strengths
   - Key weaknesses

3. **Feature Comparison Matrix**
   | Feature | Us | Comp 1 | Comp 2 | Comp 3 |
   
4. **Positioning Map**
   - 2x2 matrix with relevant dimensions
   - Where each competitor sits

5. **Competitive Threats**
   - Short-term (6 months)
   - Long-term (1-2 years)

6. **Opportunities**
   - Gaps in the market
   - Underserved segments
   - Feature whitespace

7. **Strategic Recommendations**
   - Defensive moves
   - Offensive moves
   - Positioning adjustments

8. **Monitoring Plan**
   - Key signals to track
   - Competitive intelligence sources',
                'example_output' => '## Competitive Analysis: Project Management Software

### Market Landscape
The PM software market is valued at $5.5B, growing at 10% CAGR. Key trends include AI-powered automation, async-first collaboration, and industry-specific solutions.

### Competitor: Asana
**Overview:** Public company, $550M ARR, 100K+ customers
**Target:** Mid-market teams (50-500 employees)
**Strength:** Workflow automation, enterprise features
**Weakness:** Steep learning curve, complex pricing...',
                'tips' => [
                    'Use primary sources (websites, pricing pages)',
                    'Include both direct and indirect competitors',
                    'Update quarterly as markets move fast',
                ],
            ],
        ];

        foreach ($prompts as $promptData) {
            $category = $categories[$promptData['category']] ?? null;

            if (!$category) {
                continue;
            }

            unset($promptData['category']);

            Prompt::updateOrCreate(
                ['title' => $promptData['title']],
                array_merge($promptData, [
                    'uuid' => Str::uuid(),
                    'slug' => Str::slug($promptData['title']),
                    'category_id' => $category->id,
                    'status' => 'published',
                    'output_length' => 'medium',
                ])
            );
        }
    }
}
