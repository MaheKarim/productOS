@extends('user.layout')

@section('title', ($level === 'senior' ? 'Senior PM' : 'Experienced PM') . ' - Strategic Roadmap')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('user.strategic-roadmap.index') }}"
                class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <span
                    class="inline-flex items-center gap-1 px-2 py-0.5 {{ $level === 'senior' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }} text-xs font-medium rounded-full mb-1">
                    {{ $level === 'senior' ? 'Executive Path' : 'Experienced PM Path' }}
                </span>
                <h1 class="text-xl font-bold text-slate-900">
                    {{ $level === 'senior' ? 'Build Your Strategic Framework' : "Let's Create Your Quarterly Roadmap" }}
                </h1>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('user.strategic-roadmap.advanced') }}" method="POST" class="space-y-6"
            x-data="{ priorities: [] }">
            @csrf
            <input type="hidden" name="session_uuid" value="{{ $session->session_uuid }}">
            <input type="hidden" name="level" value="{{ $level }}">

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Product Type -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-4">What type of product are you working
                    on?</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ([
            'saas' => ['SaaS', '☁️'],
            'marketplace' => ['Marketplace', '🏪'],
            'ecommerce' => ['E-commerce', '🛒'],
            'mobile_app' => ['Mobile App', '📱'],
            'fintech' => ['Fintech', '💳'],
            'other' => ['Other', '💡'],
        ] as $value => [$label, $emoji])
                        <label class="relative cursor-pointer">
                            <input type="radio" name="product_type" value="{{ $value }}" class="peer sr-only"
                                {{ old('product_type') === $value ? 'checked' : '' }} required>
                            <div
                                class="p-4 rounded-lg border-2 border-slate-200 bg-white text-center transition-all peer-checked:border-{{ $level === 'senior' ? 'purple' : 'blue' }}-500 peer-checked:bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-50 hover:border-slate-300">
                                <div class="text-2xl mb-1">{{ $emoji }}</div>
                                <div class="text-sm text-slate-900 font-medium">{{ $label }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Specific Goal / Context -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-2">What is your main goal for this
                    roadmap?</label>
                <p class="text-sm text-slate-500 mb-3">Describe any specific focus, problems, or context you want the AI to
                    consider.</p>
                <textarea name="user_intent" rows="3"
                    class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-{{ $level === 'senior' ? 'purple' : 'blue' }}-500 focus:ring-0 resize-none transition-colors"
                    placeholder="e.g. We need to raise our Series A and show 300% growth..."></textarea>
            </div>

            <!-- Product Stage -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-4">What stage is your product at?</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach ([
            'ideation' => ['Ideation', '💡'],
            'mvp' => ['MVP', '🚀'],
            'growth' => ['Growth', '📈'],
            'scale' => ['Scale', '🏢'],
        ] as $value => [$label, $emoji])
                        <label class="relative cursor-pointer">
                            <input type="radio" name="product_stage" value="{{ $value }}" class="peer sr-only"
                                {{ old('product_stage') === $value ? 'checked' : '' }}>
                            <div
                                class="p-4 rounded-lg border-2 border-slate-200 bg-white text-center transition-all peer-checked:border-{{ $level === 'senior' ? 'purple' : 'blue' }}-500 peer-checked:bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-50 hover:border-slate-300">
                                <div class="text-2xl mb-1">{{ $emoji }}</div>
                                <div class="text-sm text-slate-900 font-medium">{{ $label }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Challenges -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-1">What are your biggest challenges right
                    now?</label>
                <p class="text-sm text-slate-500 mb-4">Select all that apply</p>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ([
            'user_acquisition' => ['User Acquisition', '👥'],
            'retention' => ['Retention', '🔄'],
            'monetization' => ['Monetization', '💰'],
            'team_alignment' => ['Team Alignment', '🤝'],
            'product_roadmap' => ['Product Roadmap', '🗺️'],
            'stakeholder_mgmt' => ['Stakeholder Mgmt', '👔'],
            'technical_debt' => ['Technical Debt', '⚙️'],
            'market_expansion' => ['Market Expansion', '🌍'],
        ] as $value => [$label, $emoji])
                        <label class="relative cursor-pointer">
                            <input type="checkbox" name="challenges[]" value="{{ $value }}" class="peer sr-only"
                                {{ is_array(old('challenges')) && in_array($value, old('challenges')) ? 'checked' : '' }}>
                            <div
                                class="p-3 rounded-lg border-2 border-slate-200 bg-white transition-all peer-checked:border-{{ $level === 'senior' ? 'purple' : 'blue' }}-500 peer-checked:bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-50 hover:border-slate-300 flex items-center gap-3">
                                <span class="text-xl">{{ $emoji }}</span>
                                <span class="text-sm text-slate-900 font-medium flex-1">{{ $label }}</span>
                                <svg class="w-5 h-5 text-{{ $level === 'senior' ? 'purple' : 'blue' }}-500 hidden peer-checked:block"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Strategic Priorities -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-1">What are your top 3 strategic
                    priorities?</label>
                <p class="text-sm text-slate-500 mb-4">Click to add, drag to reorder</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach ([
            'growth' => ['Growth', '📈'],
            'pmf' => ['Product-Market Fit', '🎯'],
            'expansion' => ['Market Expansion', '🌍'],
            'team' => ['Team Scaling', '👥'],
            'revenue' => ['Revenue Growth', '💰'],
            'efficiency' => ['Operational Efficiency', '⚡'],
        ] as $value => [$label, $emoji])
                        <button type="button"
                            @click="if(!priorities.includes('{{ $value }}') && priorities.length < 3) { priorities.push('{{ $value }}') }"
                            :class="priorities.includes('{{ $value }}') ?
                                'border-{{ $level === 'senior' ? 'purple' : 'blue' }}-500 bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-50 ring-2 ring-{{ $level === 'senior' ? 'purple' : 'blue' }}-200' :
                                'border-slate-200 hover:border-slate-300'"
                            class="p-4 rounded-lg border-2 bg-white text-center transition-all cursor-pointer">
                            <div class="text-2xl mb-1">{{ $emoji }}</div>
                            <div class="text-sm text-slate-900 font-medium">{{ $label }}</div>
                        </button>
                    @endforeach
                </div>

                <!-- Selected Priorities Pills -->
                <div class="mt-4 min-h-[40px]">
                    <template x-if="priorities.length > 0">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(p, i) in priorities" :key="p">
                                <div
                                    class="px-3 py-1.5 bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-100 rounded-full text-{{ $level === 'senior' ? 'purple' : 'blue' }}-700 text-sm font-medium flex items-center gap-2">
                                    <span
                                        class="w-5 h-5 rounded-full bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-200 flex items-center justify-center text-xs font-bold"
                                        x-text="i+1"></span>
                                    <span x-text="p.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span>
                                    <button type="button" @click="priorities = priorities.filter(x => x !== p)"
                                        class="hover:text-{{ $level === 'senior' ? 'purple' : 'blue' }}-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="priorities[]" :value="p">
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="priorities.length === 0">
                        <p class="text-sm text-slate-400 italic">Click on priorities above to add them (max 3)</p>
                    </template>
                </div>
            </div>

            @if ($level === 'senior')
                <!-- Team Size (Senior only) -->
                <div class="bg-white rounded-xl border border-slate-200 p-5">
                    <label class="block text-base font-medium text-slate-900 mb-4">What's your team size?</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ([
            'solo' => ['Solo', '👤'],
            'small' => ['2-5', '👥'],
            'medium' => ['6-15', '🏢'],
            'large' => ['15+', '🏛️'],
        ] as $value => [$label, $emoji])
                            <label class="relative cursor-pointer">
                                <input type="radio" name="team_size" value="{{ $value }}" class="peer sr-only"
                                    {{ old('team_size') === $value ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-lg border-2 border-slate-200 bg-white text-center transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-slate-300">
                                    <div class="text-2xl mb-1">{{ $emoji }}</div>
                                    <div class="text-sm text-slate-900 font-medium">{{ $label }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Submit -->
            <button type="submit"
                class="w-full px-6 py-3.5 bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-600 text-white font-semibold rounded-xl hover:bg-{{ $level === 'senior' ? 'purple' : 'blue' }}-700 transition-all shadow-lg shadow-{{ $level === 'senior' ? 'purple' : 'blue' }}-500/25 flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
                Generate {{ $level === 'senior' ? 'Strategic Framework' : 'Quarterly Roadmap' }}
            </button>

            <p class="text-center text-xs text-slate-500">
                Your {{ $level === 'senior' ? 'strategic framework' : 'roadmap' }} will be generated using AI and tailored
                to your specific situation.
            </p>
        </form>
    </div>
@endsection
