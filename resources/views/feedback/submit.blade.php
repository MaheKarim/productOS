@extends('user.layout')

@section('title', 'Submit Feedback')
@section('header', 'Submit Feedback')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Submit Feedback</h1>
            <p class="text-gray-600">Help us improve by sharing your thoughts, reporting bugs, or suggesting new
                features.
            </p>
        </div>

        @livewire('feedback.feedback-submission-form')
    </div>
@endsection
