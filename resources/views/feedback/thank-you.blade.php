@extends('user.layout')

@section('title', 'Thank You for Your Feedback')
@section('header', 'Thank You')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Thank You!</h1>
            <p class="text-gray-600 mb-6">We've received your feedback and appreciate you taking the time to help us
                improve.</p>

            @if ($feedback)
                <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">Feedback ID</span>
                        <span class="font-mono font-semibold text-gray-900">{{ $feedback->feedback_id }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">Type</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                            style="background-color: {{ $feedback->type_color }}20; color: {{ $feedback->type_color }}">
                            <i class="{{ $feedback->type_icon }} mr-2"></i>
                            {{ $feedback->type_label }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Title</span>
                        <span class="font-semibold text-gray-900">{{ $feedback->title }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-blue-800 text-sm">
                    <i class="fas fa-info-circle mr-2"></i>
                    We'll review your feedback and get back to you with an update. You can track the status of your
                    feedback
                    in your dashboard.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('feedback.dashboard') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    View My Feedback
                </a>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-home mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
