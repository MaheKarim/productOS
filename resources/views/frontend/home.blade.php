@extends('frontend.layout')

@section('title', 'Home')

@section('content')
    @include('frontend.sections.hero')

    @php
        // UI/UX Pro Max: Populate mock data if DB is empty to showcase the design
        if (!$about) {
            $about = (object) [
                'heading' => 'Bridging the Gap Between User Needs & Business Goals',
                'description' =>
                    "I'm a Product Manager with a background in engineering and design. This hybrid perspective allows me to communicate effectively with cross-functional teams and build products that are technically feasible, visually stunning, and commercially viable.\n\nMy approach is rooted in data but driven by empathy. I believe that the best products are born from a deep understanding of the user's pain points and a relentless pursuit of solving them.",
                'philosophy1_title' => 'User-Obsessed',
                'philosophy1_description' =>
                    'Every decision starts and ends with the user. I advocate for them in every meeting.',
                'philosophy2_title' => 'Data-Informed',
                'philosophy2_description' => 'I use data to guide decisions, but intuition to innovate.',
                'philosophy3_title' => 'Iterative Excellence',
                'philosophy3_description' => 'Shipping fast and learning faster. Perfect is the enemy of done.',
                'philosophy4_title' => 'Outcome over Output',
                'philosophy4_description' => 'I measure success by impact on metrics, not just features shipped.',
                'work_item1' => 'Deep User Research & Discovery',
                'work_item2' => 'Strategic Roadmapping & Prioritization',
                'work_item3' => 'Agile Execution & Sprint Planning',
                'work_item4' => 'Go-to-Market & Growth Experimentation',
                'core_value1' => 'Transparency',
                'core_value2' => 'Empathy',
                'core_value3' => 'Curiosity',
                'core_value4' => 'Resilience',
            ];
        }

        if ($services->isEmpty()) {
            $services = collect([
                (object) [
                    'title' => 'Product Strategy',
                    'full_icon' => 'fa-solid fa-chess',
                    'problem_solves' => 'Lack of clear direction or market fit.',
                    'tangible_outcome' => 'A clear, actionable roadmap aligned with business goals.',
                    'features' => ['Market Analysis', 'Value Proposition Design', 'Competitor Research'],
                    'cta_text' => 'Define Strategy',
                    'cta_url' => '#contact',
                    'cta_style' => 'primary',
                ],
                (object) [
                    'title' => 'Product Discovery',
                    'full_icon' => 'fa-solid fa-magnifying-glass',
                    'problem_solves' => 'Building features nobody wants.',
                    'tangible_outcome' => 'Validated ideas and reduced development risk.',
                    'features' => ['User Interviews', 'Prototyping', 'Usability Testing'],
                    'cta_text' => 'Start Discovery',
                    'cta_url' => '#contact',
                    'cta_style' => 'secondary',
                ],
                (object) [
                    'title' => 'Growth & Optimization',
                    'full_icon' => 'fa-solid fa-chart-line',
                    'problem_solves' => 'Stagnant user base or high churn.',
                    'tangible_outcome' => 'Increased retention and revenue growth.',
                    'features' => ['Funnel Analysis', 'A/B Testing', 'Retention Strategies'],
                    'cta_text' => 'Boost Growth',
                    'cta_url' => '#contact',
                    'cta_style' => 'secondary',
                ],
            ]);
        }

        if ($projects->isEmpty()) {
            $projects = collect([
                (object) [
                    'title' => 'FinTech Mobile App Redesign',
                    'image_url' =>
                        'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1000&q=80',
                    'image' => true,
                    'category' => 'Mobile App',
                    'metric_value' => '45%',
                    'metric_label' => 'Increase in Daily Active Users',
                    'description' =>
                        'Redesigned the core transaction flow to reduce friction and improve accessibility.',
                    'duration' => '3 Months',
                    'users' => '50k+',
                    'external_link' => '#',
                ],
                (object) [
                    'title' => 'SaaS Analytics Dashboard',
                    'image_url' =>
                        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1000&q=80',
                    'image' => true,
                    'category' => 'B2B SaaS',
                    'metric_value' => '2x',
                    'metric_label' => 'Faster Data Reporting',
                    'description' =>
                        'Built a real-time analytics engine to help customers visualize their ROI instanly.',
                    'duration' => '6 Months',
                    'users' => '200+ Enterprises',
                    'external_link' => '#',
                ],
                (object) [
                    'title' => 'E-commerce Checkout Optimization',
                    'image_url' =>
                        'https://images.unsplash.com/photo-1556742049-0cfed4f7a07d?auto=format&fit=crop&w=1000&q=80',
                    'image' => true,
                    'category' => 'E-commerce',
                    'metric_value' => '$1.2M',
                    'metric_label' => 'Additional Annual Revenue',
                    'description' =>
                        'Optimized the checkout funnel by implementing one-click payments and guest checkout.',
                    'duration' => '2 Months',
                    'users' => '1M+ Visits',
                    'external_link' => '#',
                ],
            ]);
        }

        if ($testimonials->isEmpty()) {
            $testimonials = collect([
                (object) [
                    'name' => 'Sarah Jenkins',
                    'designation' => 'CEO',
                    'company' => 'TechFlow Inc.',
                    'avatar_image' => null,
                    'rating' => 5,
                    'feedback' =>
                        'One of the most strategic product minds I have worked with. They completely transformed our product vision.',
                    'project' => (object) ['title' => 'Product Strategy Overhaul'],
                ],
                (object) [
                    'name' => 'Michael Chen',
                    'designation' => 'CTO',
                    'company' => 'DataSphere',
                    'avatar_image' => null,
                    'rating' => 5,
                    'feedback' =>
                        'Bridged the gap between engineering and business perfectly. Delivered on time and above expectations.',
                    'project' => (object) ['title' => 'Analytics Platform'],
                ],
                (object) [
                    'name' => 'Emily Rodriguez',
                    'designation' => 'VP of Product',
                    'company' => 'StartUp Scale',
                    'avatar_image' => null,
                    'rating' => 5,
                    'feedback' =>
                        'Incredible attention to detail and user empathy. Our user satisfaction scores skyrocketed.',
                    'project' => (object) ['title' => 'UX Redesign'],
                ],
            ]);
        }
    @endphp

    <section id="about" class="py-24 px-8 bg-white overflow-hidden">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-semibold text-teal-900 mb-6">{{ $about->heading }}</h2>
                    <div class="space-y-6 text-slate-600 leading-relaxed">
                        {!! nl2br($about->description) !!}
                    </div>

                    <div class="mt-12">
                        <h3 class="text-xl font-semibold text-teal-900 mb-4">My Product Philosophy</h3>
                        <div class="space-y-4">
                            @if ($about->philosophy1_title)
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-8 h-8 rounded-lg gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-1 text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-teal-900 mb-1">{{ $about->philosophy1_title }}
                                        </div>
                                        <div class="text-sm text-slate-600">{{ $about->philosophy1_description }}</div>
                                    </div>
                                </div>
                            @endif
                            @if ($about->philosophy2_title)
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-accent flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-2 text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-teal-900 mb-1">{{ $about->philosophy2_title }}
                                        </div>
                                        <div class="text-sm text-slate-600">{{ $about->philosophy2_description }}</div>
                                    </div>
                                </div>
                            @endif
                            @if ($about->philosophy3_title)
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-8 h-8 rounded-lg gradient-primary flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-3 text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-teal-900 mb-1">{{ $about->philosophy3_title }}
                                        </div>
                                        <div class="text-sm text-slate-600">{{ $about->philosophy3_description }}</div>
                                    </div>
                                </div>
                            @endif
                            @if ($about->philosophy4_title)
                                <div class="flex items-start space-x-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-accent flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-4 text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-teal-900 mb-1">{{ $about->philosophy4_title }}
                                        </div>
                                        <div class="text-sm text-slate-600">{{ $about->philosophy4_description }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-teal-50 rounded-2xl p-12">
                        <div class="mb-8 relative">
                            <div class="absolute inset-0 bg-primary opacity-20 blur-3xl rounded-full"></div>
                            <div
                                class="w-32 h-32 rounded-2xl gradient-primary mx-auto mb-6 flex items-center justify-center relative z-10 shadow-glow animate-float">
                                <i class="fa-solid fa-user text-white text-5xl"></i>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-teal-900 mb-4">How I Work</h3>
                            <div class="space-y-3 text-sm text-slate-600">
                                @if ($about->work_item1)
                                    <div class="flex items-start space-x-2">
                                        <i class="fa-solid fa-check text-primary mt-1"></i>
                                        <span>{{ $about->work_item1 }}</span>
                                    </div>
                                @endif
                                @if ($about->work_item2)
                                    <div class="flex items-start space-x-2">
                                        <i class="fa-solid fa-check text-primary mt-1"></i>
                                        <span>{{ $about->work_item2 }}</span>
                                    </div>
                                @endif
                                @if ($about->work_item3)
                                    <div class="flex items-start space-x-2">
                                        <i class="fa-solid fa-check text-primary mt-1"></i>
                                        <span>{{ $about->work_item3 }}</span>
                                    </div>
                                @endif
                                @if ($about->work_item4)
                                    <div class="flex items-start space-x-2">
                                        <i class="fa-solid fa-check text-primary mt-1"></i>
                                        <span>{{ $about->work_item4 }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="pt-6 border-t border-teal-200">
                            <h3 class="text-xl font-semibold text-teal-900 mb-4">Core Values</h3>
                            <div class="space-y-2">
                                @if ($about->core_value1)
                                    <div class="px-4 py-2 bg-white rounded-lg text-sm font-medium text-teal-900">
                                        {{ $about->core_value1 }}
                                    </div>
                                @endif
                                @if ($about->core_value2)
                                    <div class="px-4 py-2 bg-white rounded-lg text-sm font-medium text-teal-900">
                                        {{ $about->core_value2 }}
                                    </div>
                                @endif
                                @if ($about->core_value3)
                                    <div class="px-4 py-2 bg-white rounded-lg text-sm font-medium text-teal-900">
                                        {{ $about->core_value3 }}
                                    </div>
                                @endif
                                @if ($about->core_value4)
                                    <div class="px-4 py-2 bg-white rounded-lg text-sm font-medium text-teal-900">
                                        {{ $about->core_value4 }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.sections.toolkit')

    <!-- Services Section -->
    <section id="services" class="py-32 px-8 bg-white relative overflow-hidden">
        {{-- Decorative background elements --}}
        <div
            class="absolute top-0 left-0 w-64 h-64 bg-teal-50 rounded-full blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl opacity-30 translate-x-1/3 translate-y-1/3">
        </div>

        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="text-center mb-20">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-teal-50 text-teal-600 text-sm font-semibold mb-4 border border-teal-100 uppercase tracking-widest">Expertise</span>
                <h2 class="text-5xl font-bold text-teal-900 mb-6 tracking-tight">How I Can <span
                        class="text-primary italic">Transform</span> Your Product</h2>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">Outcome-driven services designed for
                    high-growth product teams and visionary founders.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div
                        class="group relative bg-white border border-slate-100 p-10 rounded-[2.5rem] transition-all duration-500 hover:shadow-2xl hover:border-primary/20 hover:-translate-y-2 overflow-hidden">
                        {{-- Hover gradient accent --}}
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-bl-[5rem]">
                        </div>

                        <div class="relative z-10">
                            <div
                                class="w-20 h-20 rounded-2xl bg-teal-50 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-sm">
                                <i
                                    class="{{ $service->full_icon }} text-primary text-3xl group-hover:text-white transition-colors duration-300"></i>
                            </div>

                            <h3 class="text-2xl font-bold text-teal-900 mb-4 group-hover:text-primary transition-colors">
                                {{ $service->title }}</h3>

                            @if ($service->problem_solves)
                                <div class="mb-6">
                                    <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">The Problem
                                    </p>
                                    <p class="text-slate-600 leading-relaxed">{{ $service->problem_solves }}</p>
                                </div>
                            @endif

                            @if ($service->tangible_outcome)
                                <div
                                    class="mb-8 p-5 bg-teal-50/50 rounded-2xl border border-teal-100 group-hover:bg-teal-50 transition-colors">
                                    <p class="text-xs font-bold text-primary uppercase tracking-widest mb-2">The Outcome</p>
                                    <p class="text-teal-900 font-semibold leading-relaxed">{{ $service->tangible_outcome }}
                                    </p>
                                </div>
                            @endif

                            @if ($service->features && count($service->features) > 0)
                                <ul class="space-y-3 mb-10">
                                    @foreach ($service->features as $feature)
                                        <li class="flex items-center space-x-3 text-slate-600">
                                            <div
                                                class="w-5 h-5 rounded-full bg-teal-50 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/10 transition-colors">
                                                <i class="fa-solid fa-check text-primary text-[10px]"></i>
                                            </div>
                                            <span class="text-sm font-medium">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($service->cta_text)
                                <a href="{{ $service->cta_url ?: '#contact' }}"
                                    class="inline-flex items-center justify-center w-full py-4 px-6 rounded-2xl {{ $service->cta_style === 'primary' ? 'gradient-primary text-white shadow-lg shadow-primary/20' : 'bg-white border-2 border-slate-100 text-teal-900 hover:border-primary hover:text-primary' }} font-bold transition-all duration-300 cursor-pointer">
                                    <span>{{ $service->cta_text }}</span>
                                    <i
                                        class="fa-solid fa-arrow-right ml-2 text-sm transform group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Portfolio Section -->
    <section id="portfolio" class="py-32 px-8 bg-slate-50 relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
                <div class="max-w-2xl">
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-white text-teal-600 text-sm font-semibold mb-4 border border-slate-200 uppercase tracking-widest shadow-sm">Case
                        Studies</span>
                    <h2 class="text-5xl font-bold text-teal-900 mb-4 tracking-tight">Impact Driven <span
                            class="text-primary italic">Success Stories</span></h2>
                    <p class="text-xl text-slate-600 leading-relaxed">I don't just ship features; I deliver measurable
                        business outcomes. Here's the data to prove it.</p>
                </div>
                <div>
                    <a href="#contact"
                        class="inline-flex items-center text-primary font-bold hover:text-teal-800 transition-colors cursor-pointer text-lg">
                        Discussion more projects <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach ($projects as $project)
                    <div
                        class="group relative bg-white rounded-[2.5rem] overflow-hidden border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full">
                        {{-- Image Container --}}
                        <div class="relative h-80 overflow-hidden">
                            @if ($project->image)
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            @endif

                            {{-- Image Overlay --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-teal-900/80 via-teal-900/20 to-transparent opacity-60">
                            </div>

                            {{-- Floating Category Badge --}}
                            @if ($project->category)
                                <div class="absolute top-6 left-6 z-20">
                                    <span
                                        class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-xs font-bold text-white border border-white/20 uppercase tracking-widest">{{ $project->category }}</span>
                                </div>
                            @endif

                            {{-- High Impact Metric (Main Hero) --}}
                            @if ($project->metric_value)
                                <div class="absolute bottom-6 left-6 right-6 z-20">
                                    <div class="flex flex-col">
                                        <div class="text-6xl font-black text-white tracking-tighter mb-1 drop-shadow-lg">
                                            {{ $project->metric_value }}</div>
                                        <div class="text-teal-100 text-lg font-medium opacity-90">
                                            {{ $project->metric_label ?? 'Metric Impact' }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Content Container --}}
                        <div class="p-10 flex-grow flex flex-col">
                            <h3
                                class="text-3xl font-bold text-teal-900 mb-4 group-hover:text-primary transition-colors leading-tight">
                                {{ $project->title }}</h3>

                            @if ($project->description)
                                <p class="text-slate-600 mb-8 leading-relaxed line-clamp-2 italic">
                                    “{{ $project->description }}”</p>
                            @endif

                            <div class="mt-auto pt-8 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center space-x-6">
                                    @if ($project->duration)
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Timeline</span>
                                            <div class="flex items-center space-x-2 text-teal-900 font-bold">
                                                <i class="fa-solid fa-calendar-day text-primary text-xs"></i>
                                                <span class="text-sm">{{ $project->duration }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($project->users)
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">User
                                                Base</span>
                                            <div class="flex items-center space-x-2 text-teal-900 font-bold">
                                                <i class="fa-solid fa-users text-primary text-xs"></i>
                                                <span class="text-sm">{{ $project->users }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if ($project->external_link)
                                    <a href="{{ $project->external_link }}"
                                        class="w-12 h-12 rounded-full border-2 border-slate-100 flex items-center justify-center text-teal-900 hover:bg-primary hover:border-primary hover:text-white transition-all duration-300 cursor-pointer shadow-sm">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Secondary grid for smaller projects or more items --}}
            <div class="mt-16 text-center">
                <p class="text-slate-500 font-medium mb-8 italic">Trust the process. See the results.</p>
                <div class="inline-flex py-4 px-8 bg-teal-50 rounded-2xl border border-teal-100 items-center space-x-8">
                    <div class="flex flex-col items-center">
                        <span class="text-2xl font-bold text-primary">50k+</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lives Impacted</span>
                    </div>
                    <div class="w-px h-8 bg-teal-200"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-2xl font-bold text-primary">$12M+</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Revenue Growth</span>
                    </div>
                    <div class="w-px h-8 bg-teal-200"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-2xl font-bold text-primary">15+</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Products
                            Shipped</span>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="testimonials" class="py-24 px-8 bg-teal-50">
        <div class="max-w-[1200px] mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-semibold text-teal-900 mb-4">What People Say</h2>
                <p class="text-lg text-slate-600">Trusted by teams worldwide</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($testimonials as $testimonial)
                    <div class="bg-white rounded-2xl p-8 shadow-level-1">
                        <div class="flex items-start space-x-4 mb-6">
                            @if ($testimonial->avatar_image)
                                <img src="{{ $testimonial->avatar_image_url }}" alt="{{ $testimonial->name }}"
                                    class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-teal-100 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-2xl text-primary"></i>
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-teal-900">{{ $testimonial->name }}</div>
                                @if ($testimonial->designation)
                                    <div class="text-sm text-slate-600">{{ $testimonial->designation }}</div>
                                @endif
                                @if ($testimonial->company)
                                    <div class="text-sm text-slate-500">{{ $testimonial->company }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="relative">
                            <div class="flex mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fa-solid fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <p class="text-slate-600 leading-relaxed">"{{ $testimonial->feedback }}"</p>
                            @if ($testimonial->project)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <a href="#portfolio" class="text-sm text-primary font-medium hover:underline">
                                        <i class="fa-solid fa-link mr-1"></i>
                                        Related Project: {{ $testimonial->project->title }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Contact Section (Static) -->
    <section id="contact" class="py-24 px-8 bg-gradient-to-br from-teal-900 to-primary">
        <div class="max-w-[1200px] mx-auto text-center">
            <h2 class="text-5xl font-bold text-white mb-6">Let's build something measurable</h2>
            <p class="text-xl text-teal-100 mb-12 max-w-2xl mx-auto">
                Whether you need strategic guidance, hands-on execution, or just want to talk product—I'm here to help.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto mb-16">
                <a href="mailto:pm@example.com"
                    class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-medium">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-envelope text-white text-2xl"></i>
                    </div>
                    <div class="text-white font-semibold mb-2">Email</div>
                    <div class="text-teal-100 text-sm">pm@example.com</div>
                </a>

                <a href="https://linkedin.com"
                    class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-medium">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-brands fa-linkedin text-white text-2xl"></i>
                    </div>
                    <div class="text-white font-semibold mb-2">LinkedIn</div>
                    <div class="text-teal-100 text-sm">Connect with me</div>
                </a>

                <a href="#"
                    class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-medium">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-calendar text-white text-2xl"></i>
                    </div>
                    <div class="text-white font-semibold mb-2">Schedule</div>
                    <div class="text-teal-100 text-sm">Book a call</div>
                </a>
            </div>
    </section>
@endsection
