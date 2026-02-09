@extends('user.layout')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="{{ route('user.job-analyze.show', $analysis) }}" class="text-gray-600 hover:text-gray-800 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Analysis
                    </a>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Questions
                    </button>
                    <a href="{{ route('user.job-analyze.prepare-interview', $analysis) }}?regenerate=1" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Regenerate Questions
                    </a>
                </div>
            </div>

            <!-- Job Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Interview Preparation</h1>
                        <p class="text-lg text-gray-600 mb-1">{{ $analysis->job->title }} at {{ $analysis->job->company }}</p>
                        <p class="text-sm text-gray-500">Generated {{ $questions['generated_at'] ?? 'just now' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ count($questions['questions'] ?? []) }} Questions
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preparation Tips -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Interview Preparation Tips</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Review your resume and be ready to discuss any experience or skills mentioned</li>
                        <li>• Research the company and understand their mission, values, and recent news</li>
                        <li>• Practice answering questions using the STAR method (Situation, Task, Action, Result)</li>
                        <li>• Prepare specific examples that demonstrate your skills and achievements</li>
                        <li>• Have thoughtful questions ready to ask the interviewer</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Interview Questions -->
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900">Generated Interview Questions</h2>
            
            @forelse($questions['questions'] ?? [] as $index => $question)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                            </div>
                            @if(isset($question['category']))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $question['category'] == 'technical' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $question['category'] == 'behavioral' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $question['category'] == 'experience' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $question['category'] == 'weakness' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($question['category']) }}
                                </span>
                            @endif
                        </div>

                        <!-- Question Details -->
                        <div class="mb-4">
                            <p class="text-gray-700">{{ $question['question'] }}</p>
                            @if(isset($question['context']))
                                <p class="text-sm text-gray-600 mt-2 italic">{{ $question['context'] }}</p>
                            @endif
                        </div>

                        <!-- Ideal Answer -->
                        @if(isset($question['ideal_answer']))
                        <div class="border-t border-gray-200 pt-4">
                            <button onclick="toggleAnswer({{ $index }})" class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Show Ideal Answer
                            </button>
                            <div id="answer-{{ $index }}" class="hidden mt-3 p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-700">{{ $question['ideal_answer'] }}</p>
                                @if(isset($question['key_points']))
                                    <div class="mt-3">
                                        <p class="text-xs font-medium text-gray-600 mb-2">Key Points to Include:</p>
                                        <ul class="text-xs text-gray-600 space-y-1">
                                            @foreach($question['key_points'] as $point)
                                                <li>• {{ $point }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Follow-up Questions -->
                        @if(isset($question['follow_up_questions']) && count($question['follow_up_questions']) > 0)
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Potential Follow-up Questions:</p>
                            <ul class="text-sm text-gray-600 space-y-1">
                                @foreach($question['follow_up_questions'] as $followUp)
                                    <li>• {{ $followUp }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Questions Generated</h3>
                    <p class="text-gray-600 mb-6">We couldn't generate interview questions for this analysis. Please try again or contact support.</p>
                    <a href="{{ route('user.job-analyze.prepare-interview', $analysis) }}?regenerate=1" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Try Again
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Additional Resources -->
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Resources</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900">STAR Method Guide</h4>
                        <p class="text-sm text-gray-600 mt-1">Learn how to structure your answers using Situation, Task, Action, Result</p>
                    </div>
                </div>
                <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                    <svg class="w-5 h-5 text-gray-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-gray-900">Company Research</h4>
                        <p class="text-sm text-gray-600 mt-1">Research the company culture, values, and recent developments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAnswer(index) {
    const answerDiv = document.getElementById(`answer-${index}`);
    const button = event.target.closest('button');
    
    if (answerDiv.classList.contains('hidden')) {
        answerDiv.classList.remove('hidden');
        button.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
            </svg>
            Hide Ideal Answer
        `;
    } else {
        answerDiv.classList.add('hidden');
        button.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Show Ideal Answer
        `;
    }
}
</script>
@endsection