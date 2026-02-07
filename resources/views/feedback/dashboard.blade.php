@extends('user.layout')

@section('title', 'My Feedback')
@section('header', 'My Feedback')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">My Feedback</h1>
            <p class="text-gray-600">Track all your feedback submissions and their status.</p>
        </div>

        @livewire('feedback.feedback-dashboard')
    </div>
@endsection
