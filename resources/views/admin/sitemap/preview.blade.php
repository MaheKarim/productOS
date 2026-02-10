@extends('admin.layout')

@section('title', 'Sitemap Preview')
@section('page-title', 'Sitemap Preview')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Sitemap Preview</h3>
                <p class="text-sm text-slate-500 mt-1">Preview all URLs that will be included in your sitemap.xml</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.sitemap.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-slate-700 font-bold text-sm rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Management
                </a>
                <a href="{{ url('sitemap.xml') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/25">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    View XML
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
            <div class="grid grid-cols-4 gap-6">
                <div class="text-center">
                    <p class="text-3xl font-bold text-slate-900">{{ count($urls) }}</p>
                    <p class="text-xs text-slate-500 uppercase tracking-wider mt-1">Total URLs</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ collect($urls)->where('type', 'static')->count() }}</p>
                    <p class="text-xs text-slate-500 uppercase tracking-wider mt-1">Static</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-purple-600">{{ collect($urls)->where('type', 'dynamic')->count() }}
                    </p>
                    <p class="text-xs text-slate-500 uppercase tracking-wider mt-1">Dynamic</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-amber-600">{{ collect($urls)->where('type', 'external')->count() }}
                    </p>
                    <p class="text-xs text-slate-500 uppercase tracking-wider mt-1">External</p>
                </div>
            </div>
        </div>

        <!-- URLs Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">All URLs</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">#</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">URL
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Type
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Priority</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Change
                                Freq</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Last
                                Modified</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($urls as $index => $url)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ $url['loc'] }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        {{ Str::limit($url['loc'], 60) }}
                                    </a>
                                    @if (isset($url['name']))
                                        <p class="text-xs text-slate-500">{{ $url['name'] }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if (isset($url['type']))
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                            @if ($url['type'] == 'static') bg-blue-100 text-blue-700
                                            @elseif($url['type'] == 'dynamic') bg-purple-100 text-purple-700
                                            @else bg-amber-100 text-amber-700 @endif
                                        ">
                                            {{ ucfirst($url['type']) }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700">
                                            Auto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $url['priority'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600 capitalize">{{ $url['changefreq'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">{{ $url['lastmod'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
