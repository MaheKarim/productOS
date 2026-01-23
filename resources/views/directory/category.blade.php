@extends('frontend.layout')

@section('title', $title . ' - Directory')

@section('content')
    {{-- Header --}}
    <div class="bg-slate-50 pt-32 pb-12 border-b border-slate-200">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <div class="flex items-center space-x-2 text-sm text-slate-500 mb-4">
                        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        <a href="{{ route('directory.index') }}" class="hover:text-blue-600">Directory</a>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        <span class="text-slate-900 font-medium">{{ $title }}</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">{{ $title }}</h1>
                    <p class="text-slate-500 max-w-2xl">Find the best {{ strtolower($title) }} curated for product managers.
                    </p>
                </div>

                <div class="mt-6 md:mt-0">
                    <a href="{{ route('directory.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-lg text-slate-600 text-sm font-bold hover:bg-slate-50 hover:text-blue-600 transition shadow-sm">
                        <i class="fa-solid fa-arrow-left mr-2"></i> All Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-[1400px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <livewire:directory.directory-filters :type="$type" />
            </div>

            {{-- Main List --}}
            <div class="lg:col-span-3">
                <livewire:directory.directory-list :type="$type" />
            </div>
        </div>
    </div>
@endsection
