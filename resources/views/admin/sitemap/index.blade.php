@extends('admin.layout')

@section('title', 'Sitemap Management')
@section('page-title', 'Sitemap Management')

@section('content')
    <div class="space-y-8">
        <!-- Header Stats -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total URLs</p>
                        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="network" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['active'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Static</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['static'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="file" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Dynamic</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $stats['dynamic'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="refresh-cw" class="w-6 h-6 text-purple-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">External</p>
                        <p class="text-3xl font-bold text-amber-600 mt-1">{{ $stats['external'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="external-link" class="w-6 h-6 text-amber-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto-Generated Content Stats -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Auto-Generated Content</h3>
                <p class="text-sm text-slate-500 mt-1">These URLs are automatically included in the sitemap from database
                    content</p>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                @foreach ($autoStats as $type => $count)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-2xl font-bold text-slate-900">{{ $count }}</p>
                        <p class="text-xs text-slate-500 mt-1 capitalize">{{ str_replace('_', ' ', $type) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Actions Bar -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.sitemap.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/25">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add URL
                </a>
                <form action="{{ route('admin.sitemap.generate-defaults') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-600 text-white font-bold text-sm rounded-xl hover:bg-slate-700 transition-colors">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        Generate Default Pages
                    </button>
                </form>
                <a href="{{ route('admin.sitemap.preview') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 font-bold text-sm rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    Preview Sitemap
                </a>
                <a href="{{ url('sitemap.xml') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 font-bold text-sm rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    View XML
                </a>
            </div>
        </div>

        <!-- Sitemap Items Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Manual URLs</h3>
                <p class="text-sm text-slate-500 mt-1">Manage custom URLs for your sitemap</p>
            </div>

            <!-- Bulk Actions Form -->
            <form action="{{ route('admin.sitemap.bulk-action') }}" method="POST" id="bulk-form">
                @csrf

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="w-12 px-6 py-4">
                                    <input type="checkbox" id="select-all" class="rounded border-slate-300">
                                </th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    URL</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Type</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Priority</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Change Freq</th>
                                <th class="text-center px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="text-right px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($sitemapItems as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="item-checkbox rounded border-slate-300">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $item->name ?? 'Unnamed' }}</p>
                                            <p class="text-xs text-slate-500 truncate max-w-md">{{ $item->url }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                            @if ($item->type == 'static') bg-blue-100 text-blue-700
                                            @elseif($item->type == 'dynamic') bg-purple-100 text-purple-700
                                            @else bg-amber-100 text-amber-700 @endif
                                        ">
                                            {{ ucfirst($item->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700">
                                            {{ $item->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-slate-600 capitalize">{{ $item->changefreq }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.sitemap.toggle', $item) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" class="cursor-pointer">
                                                @if ($item->is_active)
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Active
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ $item->full_url }}" target="_blank"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                                title="View">
                                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                            </a>
                                            <a href="{{ route('admin.sitemap.edit', $item) }}"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                                title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.sitemap.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this URL?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                    title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                                <i data-lucide="network" class="w-8 h-8 text-slate-400"></i>
                                            </div>
                                            <p class="text-slate-600 font-medium">No URLs found</p>
                                            <p class="text-slate-400 text-sm mt-1">Get started by adding URLs or generating
                                                defaults</p>
                                            <div class="flex gap-3 mt-4">
                                                <a href="{{ route('admin.sitemap.create') }}"
                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors">
                                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                                    Add URL
                                                </a>
                                                <form action="{{ route('admin.sitemap.generate-defaults') }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 text-white font-bold text-sm rounded-xl hover:bg-slate-700 transition-colors">
                                                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                                                        Generate Defaults
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($sitemapItems->count() > 0)
                    <!-- Bulk Actions Bar -->
                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex items-center gap-4">
                        <select name="action" class="rounded-lg border-slate-300 text-sm">
                            <option value="">Bulk Action</option>
                            <option value="activate">Activate Selected</option>
                            <option value="deactivate">Deactivate Selected</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-slate-600 text-white text-sm font-bold rounded-lg hover:bg-slate-700 transition-colors">
                            Apply
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Select all checkbox
        document.getElementById('select-all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endpush
