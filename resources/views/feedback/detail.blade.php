@extends('user.layout')

@section('title', 'Feedback Details')
@section('header', 'Feedback Details')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('feedback.dashboard') }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to My Feedback
            </a>
        </div>

        @livewire('feedback.feedback-detail', ['feedbackId' => $feedback->feedback_id])
    </div>
@endsection
