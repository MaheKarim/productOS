@extends('frontend.layout')

@section('title', $job->job_title . ' at ' . $job->company_name . ' - ProductOS Jobs')

@section('content')
    <div class="bg-slate-50 min-h-screen pb-20">
        {{-- Header --}}
        <div class="bg-white pt-32 pb-12 border-b border-slate-200">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Breadcrumb --}}
                <nav class="mb-6">
                    <a href="{{ route('jobs.index') }}"
                        class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 transition-colors cursor-pointer">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        Back to all jobs
                    </a>
                </nav>

                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                    {{-- Job Info --}}
                    <div class="flex items-start gap-5">
                        {{-- Company Logo --}}
                        <div
                            class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700 font-bold text-2xl flex-shrink-0">
                            {{ strtoupper(substr($job->company_name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight mb-2">
                                {{ $job->job_title }}
                            </h1>
                            <div class="flex items-center gap-2 text-slate-600 mb-4">
                                <span class="font-semibold">{{ $job->company_name }}</span>
                                <i data-lucide="badge-check" class="w-5 h-5 text-blue-500"></i>
                            </div>

                            {{-- Tags --}}
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 font-medium border border-slate-200">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-slate-500"></i>
                                    {{ $job->location ?? 'Remote' }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 font-medium border border-slate-200">
                                    <i data-lucide="briefcase" class="w-4 h-4 text-slate-500"></i>
                                    {{ $job->job_type }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 font-medium border border-slate-200">
                                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-slate-500"></i>
                                    {{ $job->experience_level ?? 'Not specified' }}
                                </span>
                                @if ($job->salary_range)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100">
                                        <i data-lucide="banknote" class="w-4 h-4"></i>
                                        {{ $job->salary_range }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Apply Button --}}
                    <div class="flex flex-col items-start md:items-end gap-3">
                        @if ($job->source_url)
                            <a href="{{ $job->source_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-all cursor-pointer shadow-lg shadow-slate-900/10">
                                Apply for this Job
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                        @endif
                        <span class="text-sm text-slate-400">
                            Posted {{ $job->posted_date ? $job->posted_date->diffForHumans() : 'Recently' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Job Description --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">About the Role</h2>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                            @if ($job->job_details)
                                {!! nl2br(e($job->job_details)) !!}
                            @elseif (!empty($job->job_data['full_description']))
                                {{ $job->job_data['full_description'] }}
                            @elseif (!empty($job->job_data['summary']))
                                {{ $job->job_data['summary'] }}
                            @else
                                <p class="text-slate-400 italic">No description available.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Skills --}}
                    @if (!empty($job->job_data['skills']))
                        <div class="bg-white rounded-xl border border-slate-200 p-6">
                            <h2 class="text-lg font-bold text-slate-900 mb-4">Skills & Technologies</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($job->job_data['skills'] as $skill)
                                    <span
                                        class="px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg text-sm border border-blue-100">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Benefits --}}
                    @if (!empty($job->job_data['benefits']))
                        <div class="bg-white rounded-xl border border-slate-200 p-6">
                            <h2 class="text-lg font-bold text-slate-900 mb-4">Benefits & Perks</h2>
                            <ul class="space-y-3">
                                @foreach ($job->job_data['benefits'] as $benefit)
                                    <li class="flex items-start gap-3">
                                        <i data-lucide="check-circle-2"
                                            class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5"></i>
                                        <span class="text-slate-600">{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Company Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">About the Company</h3>
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-lg border border-slate-200">
                                {{ strtoupper(substr($job->company_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900">{{ $job->company_name }}</div>
                                <div class="text-xs text-slate-500">{{ $job->location ?? 'Global' }}</div>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            We are an innovative company looking for talented individuals to join our team and make an
                            impact.
                        </p>
                    </div>

                    {{-- Share --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Share this Job</h3>
                        <div class="flex gap-3">
                            {{-- Copy Link --}}
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')"
                                class="w-10 h-10 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors flex items-center justify-center cursor-pointer"
                                title="Copy Link">
                                <i data-lucide="link" class="w-5 h-5"></i>
                            </button>

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-lg bg-[#1877F2] hover:bg-[#166FE5] text-white transition-colors flex items-center justify-center cursor-pointer"
                                title="Share on Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-lg bg-[#0A66C2] hover:bg-[#004182] text-white transition-colors flex items-center justify-center cursor-pointer"
                                title="Share on LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>

                            {{-- WhatsApp --}}
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($job->job_title . ' at ' . $job->company_name . ' - ' . request()->url()) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="w-10 h-10 rounded-lg bg-[#25D366] hover:bg-[#20BD5A] text-white transition-colors flex items-center justify-center cursor-pointer"
                                title="Share on WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Related Jobs --}}
                    @if ($relatedJobs->count() > 0)
                        <div class="bg-white rounded-xl border border-slate-200 p-6">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Similar
                                Opportunities
                            </h3>
                            <div class="space-y-3">
                                @foreach ($relatedJobs as $related)
                                    <a href="{{ route('jobs.show', $related->slug) }}"
                                        class="block p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50 transition-all cursor-pointer group">
                                        <div
                                            class="font-bold text-slate-900 group-hover:text-blue-600 mb-1 transition-colors text-sm">
                                            {{ $related->job_title }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $related->company_name }}</div>
                                        <div class="text-xs text-slate-400 mt-2 flex items-center gap-2">
                                            <span>{{ $related->location ?? 'Remote' }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $related->job_type }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
