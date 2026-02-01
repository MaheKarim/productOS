@extends('user.layout')

@section('title', 'Interview Preparation')
@section('header', 'Interview Preparation')

@section('content')
    <div class="max-w-6xl mx-auto relative relative z-10">
        {{-- Background Decorations --}}
        <div
            class="absolute top-0 -left-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl -z-10 mix-blend-multiply animate-blob">
        </div>
        <div
            class="absolute top-0 -right-20 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl -z-10 mix-blend-multiply animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-20 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl -z-10 mix-blend-multiply animate-blob animation-delay-4000">
        </div>

        {{-- Hero Section --}}
        <div class="mb-12 relative group">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl opacity-90 blur-xl transition-all duration-500 group-hover:opacity-100 group-hover:blur-2xl -z-10">
            </div>
            <div
                class="relative bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 md:p-12 text-white shadow-2xl overflow-hidden isolation-auto border border-white/20">
                {{-- Decorative circles --}}
                <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-64 h-64 bg-indigo-500/30 rounded-full blur-2xl"></div>

                <div class="flex flex-col md:flex-row md:items-center gap-8 relative z-10">
                    <div class="flex-1 space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/20 text-xs font-semibold text-blue-50">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            AI Powered Interview Prep
                        </div>
                        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                            Master Your Next <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-indigo-100">Tech
                                Interview</span>
                        </h1>
                        <p class="text-blue-100 text-lg md:text-xl font-medium max-w-2xl leading-relaxed opacity-90">
                            Practice with curated questions, get real-time AI feedback, and track your progress to land your
                            dream job.
                        </p>
                    </div>
                    <div class="flex-shrink-0 relative">
                        <div
                            class="w-32 h-32 md:w-40 md:h-40 bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 flex items-center justify-center shadow-inner relative hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent rounded-3xl"></div>
                            <svg class="w-16 h-16 md:w-20 md:h-20 text-white drop-shadow-lg" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        {{-- Floating elements --}}
                        <div
                            class="absolute -top-4 -right-4 bg-white text-indigo-600 text-xs font-bold px-3 py-1.5 rounded-xl shadow-lg border border-indigo-100 animate-bounce">
                            98% Success
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            @foreach ([['label' => 'Total Questions', 'value' => $totalQuestions, 'color' => 'blue', 'icon' => 'database'], ['label' => 'Categories', 'value' => $categories->count(), 'color' => 'indigo', 'icon' => 'folder'], ['label' => 'Difficulty Levels', 'value' => 3, 'color' => 'amber', 'icon' => 'bar-chart-2'], ['label' => 'Target Audiences', 'value' => 3, 'color' => 'emerald', 'icon' => 'users']] as $stat)
                <div
                    class="group bg-white/60 backdrop-blur-xl p-5 rounded-2xl border border-white/40 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-start justify-between mb-2">
                        <div
                            class="p-2.5 rounded-xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-slate-100 text-slate-500">+12%</span>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $stat['value'] }}</div>
                        <div class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filter Options --}}
        <form action="{{ route('user.interview-prep.start') }}" method="POST" x-data="{ filterType: 'category', selectedCategories: [], selectedAudiences: [], questionCount: 20 }" class="space-y-8">
            @csrf

            <input type="hidden" name="filter_type" :value="filterType">
            <input type="hidden" name="question_count" :value="questionCount">

            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-1 h-6 bg-indigo-600 rounded-full"></span>
                    Configure Session
                </h2>
                <div
                    class="flex items-center gap-2 text-sm text-slate-500 bg-white/50 px-3 py-1 rounded-full border border-slate-200">
                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                    <span>Customize your practice</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Category Filter Card --}}
                <div @click="filterType = 'category'"
                    class="relative group rounded-3xl p-1 cursor-pointer transition-all duration-300"
                    :class="filterType === 'category' ?
                        'bg-gradient-to-br from-blue-500 to-indigo-500 shadow-xl shadow-blue-500/20 scale-[1.02]' :
                        'bg-transparent hover:scale-[1.01]'">
                    <div class="bg-white/80 backdrop-blur-xl h-full rounded-[20px] p-6 border transition-all duration-300 relative overflow-hidden"
                        :class="filterType === 'category' ? 'border-transparent' :
                            'border-white/60 shadow-lg hover:border-blue-200'">

                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 shadow-sm"
                                    :class="filterType === 'category' ? 'bg-blue-600 text-white shadow-blue-500/40' :
                                        'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white'">
                                    <i data-lucide="layers" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-bold text-slate-900 group-hover:text-blue-700 transition-colors">
                                        By Category</h3>
                                    <p class="text-xs font-medium text-slate-500">Focus on specific topics</p>
                                </div>
                                <div class="ml-auto" x-show="filterType === 'category'">
                                    <div
                                        class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <p class="text-sm text-slate-600 leading-relaxed">Select categories to focus your practice
                                    on specific areas like Product Design, Strategy, or Analytics.</p>

                                <div x-show="filterType === 'category'" x-collapse>
                                    <div class="h-px bg-slate-200 my-4"></div>
                                    <div class="space-y-2 max-h-56 overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach ($categories as $category)
                                            <label
                                                class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50/80 cursor-pointer transition-all border border-transparent hover:border-blue-100 group/item">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                        class="peer relative appearance-none w-5 h-5 border-2 border-slate-300 rounded checked:bg-blue-600 checked:border-blue-600 transition-all cursor-pointer">
                                                    <i data-lucide="check"
                                                        class="absolute w-3.5 h-3.5 text-white left-[3px] opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                                                </div>
                                                <span
                                                    class="text-sm font-medium text-slate-700 group-hover/item:text-slate-900">{{ $category->name }}</span>
                                                <span
                                                    class="ml-auto text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full group-hover/item:bg-blue-100 group-hover/item:text-blue-600 transition-colors">{{ $category->questions_count }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Audience Filter Card --}}
                <div @click="filterType = 'audience'"
                    class="relative group rounded-3xl p-1 cursor-pointer transition-all duration-300"
                    :class="filterType === 'audience' ?
                        'bg-gradient-to-br from-indigo-500 to-purple-500 shadow-xl shadow-indigo-500/20 scale-[1.02]' :
                        'bg-transparent hover:scale-[1.01]'">
                    <div class="bg-white/80 backdrop-blur-xl h-full rounded-[20px] p-6 border transition-all duration-300 relative overflow-hidden"
                        :class="filterType === 'audience' ? 'border-transparent' :
                            'border-white/60 shadow-lg hover:border-indigo-200'">

                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 shadow-sm"
                                    :class="filterType === 'audience' ? 'bg-indigo-600 text-white shadow-indigo-500/40' :
                                        'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white'">
                                    <i data-lucide="briefcase" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-bold text-slate-900 group-hover:text-indigo-700 transition-colors">
                                        By Experience</h3>
                                    <p class="text-xs font-medium text-slate-500">Tailored to your level</p>
                                </div>
                                <div class="ml-auto" x-show="filterType === 'audience'">
                                    <div
                                        class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <p class="text-sm text-slate-600 leading-relaxed">Choose questions designed for your
                                    specific career stage, from Associate to Senior.</p>

                                <div x-show="filterType === 'audience'" x-collapse>
                                    <div class="h-px bg-slate-200 my-4"></div>
                                    <div class="space-y-3">
                                        @foreach ([['value' => 'new', 'label' => 'New to PM', 'desc' => '< 2 years exp', 'count' => $audienceCounts['new'], 'color' => 'green'], ['value' => 'experienced', 'label' => 'Experienced', 'desc' => '2-5 years exp', 'count' => $audienceCounts['experienced'], 'color' => 'blue'], ['value' => 'senior', 'label' => 'Senior / Founder', 'desc' => '5+ years exp', 'count' => $audienceCounts['senior'], 'color' => 'purple']] as $audience)
                                            <label
                                                class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50/80 cursor-pointer transition-all border border-transparent hover:border-indigo-100 group/item">
                                                <div class="relative flex items-center">
                                                    <input type="checkbox" name="audiences[]"
                                                        value="{{ $audience['value'] }}"
                                                        class="peer relative appearance-none w-5 h-5 border-2 border-slate-300 rounded checked:bg-indigo-600 checked:border-indigo-600 transition-all cursor-pointer">
                                                    <i data-lucide="check"
                                                        class="absolute w-3.5 h-3.5 text-white left-[3px] opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <span
                                                        class="block text-sm font-bold text-slate-800">{{ $audience['label'] }}</span>
                                                    <span
                                                        class="text-[10px] text-slate-500">{{ $audience['desc'] }}</span>
                                                </div>
                                                <span
                                                    class="text-[10px] font-bold bg-{{ $audience['color'] }}-100 text-{{ $audience['color'] }}-700 px-2 py-0.5 rounded-full">{{ $audience['count'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Random Filter Card --}}
                <div @click="filterType = 'random'"
                    class="relative group rounded-3xl p-1 cursor-pointer transition-all duration-300"
                    :class="filterType === 'random' ?
                        'bg-gradient-to-br from-amber-400 to-orange-500 shadow-xl shadow-orange-500/20 scale-[1.02]' :
                        'bg-transparent hover:scale-[1.01]'">
                    <div class="bg-white/80 backdrop-blur-xl h-full rounded-[20px] p-6 border transition-all duration-300 relative overflow-hidden"
                        :class="filterType === 'random' ? 'border-transparent' :
                            'border-white/60 shadow-lg hover:border-orange-200'">

                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-300 shadow-sm"
                                    :class="filterType === 'random' ? 'bg-orange-500 text-white shadow-orange-500/40' :
                                        'bg-orange-50 text-orange-600 group-hover:bg-orange-500 group-hover:text-white'">
                                    <i data-lucide="shuffle" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-bold text-slate-900 group-hover:text-orange-700 transition-colors">
                                        Random Mix</h3>
                                    <p class="text-xs font-medium text-slate-500">Surprise me</p>
                                </div>
                                <div class="ml-auto" x-show="filterType === 'random'">
                                    <div
                                        class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <p class="text-sm text-slate-600 leading-relaxed">Simulate a real interview environment
                                    with a random selection of questions from all categories.</p>

                                <div x-show="filterType === 'random'" x-collapse>
                                    <div class="h-px bg-slate-200 my-4"></div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Question
                                            Count</label>
                                        <div class="relative">
                                            <select x-model="questionCount"
                                                class="w-full pl-4 pr-10 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white shadow-sm cursor-pointer appearance-none">
                                                <option value="10">10 Questions</option>
                                                <option value="20" selected>20 Questions</option>
                                                <option value="30">30 Questions</option>
                                                <option value="50">50 Questions</option>
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-500">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Start Button --}}
            <div class="flex justify-center pt-8">
                <button type="submit"
                    class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white transition-all duration-200 bg-slate-900 font-lg rounded-2xl hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 hover:scale-105 active:scale-95 shadow-xl shadow-slate-900/20 overflow-hidden">
                    <div
                        class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <span class="relative flex items-center gap-3 text-lg">
                        Start Practice Session
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();
            });
        </script>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            @keyframes blob {
                0% {
                    transform: translate(0px, 0px) scale(1);
                }

                33% {
                    transform: translate(30px, -50px) scale(1.1);
                }

                66% {
                    transform: translate(-20px, 20px) scale(0.9);
                }

                100% {
                    transform: translate(0px, 0px) scale(1);
                }
            }

            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    @endpush
@endsection
