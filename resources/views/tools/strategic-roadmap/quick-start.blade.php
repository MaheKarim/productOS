@extends('user.layout')

@section('title', 'Quick Start - Strategic Roadmap')

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
                    class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full mb-1">
                    Quick Start Path
                </span>
                <h1 class="text-xl font-bold text-slate-900">Let's Build Your 90-Day Plan</h1>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('user.strategic-roadmap.quick-start') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="session_uuid" value="{{ $session->session_uuid }}">

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
            'other' => ['Other', '💡'],
        ] as $value => [$label, $emoji])
                        <label class="relative cursor-pointer">
                            <input type="radio" name="product_type" value="{{ $value }}" class="peer sr-only"
                                {{ old('product_type') === $value ? 'checked' : '' }}>
                            <div
                                class="p-4 rounded-lg border-2 border-slate-200 bg-white text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-slate-300">
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
                    class="w-full px-4 py-3 rounded-lg border-2 border-slate-200 focus:border-blue-500 focus:ring-0 resize-none transition-colors"
                    placeholder="e.g. We need to improve retention for our mobile app users..."></textarea>
            </div>

            <!-- Time Working -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-4">How long have you been working on it?</label>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    @foreach ([
            'less_3m' => '< 3 months',
            '3_6m' => '3-6 months',
            '6_12m' => '6-12 months',
            '1_2y' => '1-2 years',
            '2plus_y' => '2+ years',
        ] as $value => $label)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="time_working" value="{{ $value }}" class="peer sr-only"
                                {{ old('time_working') === $value ? 'checked' : '' }}>
                            <div
                                class="p-3 rounded-lg border-2 border-slate-200 bg-white text-center transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-slate-300">
                                <div class="text-sm text-slate-900 font-medium">{{ $label }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Challenges -->
            <div class="bg-white rounded-xl border border-slate-200 p-5">
                <label class="block text-base font-medium text-slate-900 mb-1">What's your biggest challenge right
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
        ] as $value => [$label, $emoji])
                        <label class="relative cursor-pointer">
                            <input type="checkbox" name="challenges[]" value="{{ $value }}" class="peer sr-only"
                                {{ is_array(old('challenges')) && in_array($value, old('challenges')) ? 'checked' : '' }}>
                            <div
                                class="p-3 rounded-lg border-2 border-slate-200 bg-white transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-slate-300 flex items-center gap-3">
                                <span class="text-xl">{{ $emoji }}</span>
                                <span class="text-sm text-slate-900 font-medium flex-1">{{ $label }}</span>
                                <svg class="w-5 h-5 text-blue-500 hidden peer-checked:block" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full px-6 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
                Generate My Roadmap
            </button>

            <p class="text-center text-xs text-slate-500">
                Your roadmap will be generated using AI and tailored to your specific situation.
            </p>
        </form>
    </div>
@endsection
