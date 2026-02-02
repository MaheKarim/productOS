@extends('frontend.layout')

@section('title', 'Interview Prep - ProductOS')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 selection:bg-blue-200">
        {{-- Hero Section --}}
        <div class="relative pt-32 pb-20 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    {{-- Left: Content --}}
                    <div>
                        {{-- Badge --}}
                        <div
                            class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-blue-100 border-2 border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-6">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>PM Interview Practice</span>
                        </div>

                        {{-- Headline --}}
                        <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6 tracking-tight leading-tight">
                            Ace Your Next<br />
                            <span class="text-blue-600">PM Interview</span>
                        </h1>

                        {{-- Subheading --}}
                        <p class="text-xl text-slate-600 mb-8 leading-relaxed">
                            Practice with real PM interview questions. Get AI-powered feedback. Build confidence for your
                            dream role.
                        </p>

                        {{-- Stats Row --}}
                        <div class="grid grid-cols-3 gap-6 mb-10 pb-10 border-b-2 border-slate-200">
                            <div>
                                <div class="text-3xl font-black text-blue-600 mb-1">500+</div>
                                <div class="text-sm text-slate-600 font-medium">Questions</div>
                            </div>
                            <div>
                                <div class="text-3xl font-black text-purple-600 mb-1">12</div>
                                <div class="text-sm text-slate-600 font-medium">Categories</div>
                            </div>
                            <div>
                                <div class="text-3xl font-black text-orange-600 mb-1">AI</div>
                                <div class="text-sm text-slate-600 font-medium">Feedback</div>
                            </div>
                        </div>

                        {{-- CTA Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                <a href="{{ route('user.interview-prep.index') }}"
                                    class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white text-lg font-bold rounded-2xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 cursor-pointer">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Start Practice
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white text-lg font-bold rounded-2xl hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 cursor-pointer">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Get Started Free
                                </a>
                            @endauth
                            <a href="#how-it-works"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-slate-200 text-slate-900 text-lg font-bold rounded-2xl hover:border-blue-600 hover:text-blue-600 transition-all duration-200 cursor-pointer">
                                Learn More
                            </a>
                        </div>
                    </div>

                    {{-- Right: Visual/Demo --}}
                    <div class="relative">
                        {{-- Decorative blob --}}
                        <div
                            class="absolute -top-10 -right-10 w-72 h-72 bg-blue-200 rounded-full blur-3xl opacity-30 animate-pulse">
                        </div>

                        {{-- Mock Interview Card --}}
                        <div class="relative bg-white border-2 border-slate-200 rounded-3xl p-8 shadow-xl">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                                    Question 1/20
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <div class="text-xs font-bold text-purple-600 uppercase tracking-wider mb-2">Product
                                        Strategy</div>
                                    <h3 class="text-xl font-bold text-slate-900 leading-tight">
                                        How would you prioritize features for a new mobile app targeting Gen Z users?
                                    </h3>
                                </div>

                                <div class="space-y-3">
                                    <div
                                        class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl">
                                        <div class="text-sm font-medium text-slate-700">Your answer will be analyzed for:
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <span
                                                class="px-2 py-1 bg-white border border-blue-200 text-blue-700 text-xs font-bold rounded-lg">Structure</span>
                                            <span
                                                class="px-2 py-1 bg-white border border-purple-200 text-purple-700 text-xs font-bold rounded-lg">Frameworks</span>
                                            <span
                                                class="px-2 py-1 bg-white border border-orange-200 text-orange-700 text-xs font-bold rounded-lg">Clarity</span>
                                        </div>
                                    </div>

                                    <button
                                        class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors cursor-pointer">
                                        Submit Answer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- How It Works Section --}}
        <div id="how-it-works" class="bg-gradient-to-br from-slate-50 to-slate-100/50 py-20">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-4">How It Works</h2>
                    <p class="text-xl text-slate-600">Three simple steps to interview mastery</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    {{-- Step 1 --}}
                    <div
                        class="bg-white border-2 border-slate-200 rounded-2xl p-8 hover:border-blue-600 hover:shadow-lg transition-all duration-200">
                        <div
                            class="w-16 h-16 bg-blue-100 border-2 border-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-2">Step 1</div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3">Choose Your Focus</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Select from 12+ categories including Product Strategy, Metrics, Execution, and more. Filter by
                            experience level.
                        </p>
                    </div>

                    {{-- Step 2 --}}
                    <div
                        class="bg-white border-2 border-slate-200 rounded-2xl p-8 hover:border-purple-600 hover:shadow-lg transition-all duration-200">
                        <div
                            class="w-16 h-16 bg-purple-100 border-2 border-purple-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-purple-600 uppercase tracking-wider mb-2">Step 2</div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3">Answer Questions</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Practice with real interview questions. Type your answers or record voice responses. Take your
                            time.
                        </p>
                    </div>

                    {{-- Step 3 --}}
                    <div
                        class="bg-white border-2 border-slate-200 rounded-2xl p-8 hover:border-orange-600 hover:shadow-lg transition-all duration-200">
                        <div
                            class="w-16 h-16 bg-orange-100 border-2 border-orange-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-orange-600 uppercase tracking-wider mb-2">Step 3</div>
                        <h3 class="text-2xl font-black text-slate-900 mb-3">Get AI Feedback</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Receive instant AI-generated feedback on your answers. Learn what to improve and track your
                            progress.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories Section --}}
        <div class="py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-4">Practice Categories</h2>
                    <p class="text-xl text-slate-600">Master every aspect of PM interviews</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-blue-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">📊</div>
                        <div class="text-sm font-bold text-slate-900">Product Strategy</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-purple-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">📈</div>
                        <div class="text-sm font-bold text-slate-900">Metrics & Analytics</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-orange-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🎨</div>
                        <div class="text-sm font-bold text-slate-900">Product Design</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-green-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">⚙️</div>
                        <div class="text-sm font-bold text-slate-900">Execution</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-red-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🤝</div>
                        <div class="text-sm font-bold text-slate-900">Stakeholder Mgmt</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-indigo-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🔍</div>
                        <div class="text-sm font-bold text-slate-900">User Research</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-yellow-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">🚀</div>
                        <div class="text-sm font-bold text-slate-900">Go-to-Market</div>
                    </div>
                    <div
                        class="bg-white border-2 border-slate-200 rounded-xl p-6 hover:border-pink-600 hover:shadow-md transition-all cursor-pointer group">
                        <div class="text-3xl mb-3 group-hover:scale-110 transition-transform">💡</div>
                        <div class="text-sm font-bold text-slate-900">Innovation</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 py-20 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                    Ready to Land Your Dream PM Role?
                </h2>
                <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                    Join thousands of product managers who've used our interview prep to ace their interviews and land
                    offers at top companies.
                </p>
                @auth
                    <a href="{{ route('user.interview-prep.index') }}"
                        class="inline-flex items-center px-10 py-5 bg-white text-blue-600 text-lg font-bold rounded-2xl hover:bg-blue-50 transition-all duration-200 shadow-xl hover:-translate-y-1 cursor-pointer group">
                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Go to Interview Prep Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-10 py-5 bg-white text-blue-600 text-lg font-bold rounded-2xl hover:bg-blue-50 transition-all duration-200 shadow-xl hover:-translate-y-1 cursor-pointer group">
                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Start Practicing for Free
                    </a>
                @endauth
                <p class="mt-6 text-blue-200 text-sm">No credit card required • 100% free to use</p>
            </div>
        </div>
    </div>
@endsection
