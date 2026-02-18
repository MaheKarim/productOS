@extends('admin.layout')

@section('page-title', 'Add New Gift Offer')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.gifts.index') }}"
                    class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-semibold text-slate-900">Add New Gift Offer</h1>
            </div>
            <p class="text-slate-500 text-sm ml-8">Create a new promotional offer for a partner website.</p>
        </div>

        <form action="{{ route('admin.gifts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Column: Main Info --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Gift Details Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-medium text-slate-900">Gift Details</h3>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Website Name --}}
                            <div>
                                <label for="website_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Website Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="website_name" name="website_name"
                                    value="{{ old('website_name') }}" required placeholder="e.g. Amazon, Udemy, Coursera"
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                @error('website_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Short Description --}}
                            <div>
                                <label for="short_description" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Short Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="short_description" name="short_description" rows="3" required
                                    placeholder="Brief description of the offer/gift..."
                                    class="w-full px-3 py-2.5 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm resize-none">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Link --}}
                            <div>
                                <label for="link" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Offer Link <span class="text-red-500">*</span>
                                </label>
                                <input type="url" id="link" name="link" value="{{ old('link') }}" required
                                    placeholder="https://example.com/offer"
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                @error('link')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Offer Percentage --}}
                                <div>
                                    <label for="offer_percentage" class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Offer / Gift Value <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="offer_percentage" name="offer_percentage"
                                        value="{{ old('offer_percentage') }}" required
                                        placeholder="e.g. 20% off, 50% cashback, Free trial"
                                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                    @error('offer_percentage')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Sort Order --}}
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-1.5">
                                        Display Order
                                    </label>
                                    <input type="number" id="sort_order" name="sort_order"
                                        value="{{ old('sort_order', 0) }}" placeholder="0"
                                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                    <p class="mt-1 text-xs text-slate-400">Lower numbers appear first</p>
                                </div>
                            </div>

                            {{-- Logo Upload --}}
                            <div>
                                <label for="logo" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Website Logo
                                </label>
                                <div class="flex items-center gap-4">
                                    <div id="logo-preview"
                                        class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                        <i data-lucide="image" class="w-6 h-6 text-slate-300"></i>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" id="logo" name="logo" accept="image/*"
                                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 file:cursor-pointer cursor-pointer"
                                            onchange="previewLogo(event)">
                                        <p class="mt-1 text-xs text-slate-400">JPG, PNG, SVG, or WebP. Max 2MB.</p>
                                    </div>
                                </div>
                                @error('logo')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Settings --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm sticky top-6">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-medium text-slate-900">Publishing</h3>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Active Toggle --}}
                            <div
                                class="flex items-center justify-between py-3 px-4 bg-slate-50 rounded-lg border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="eye" class="w-4 h-4 text-emerald-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">Active</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                    <div
                                        class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500">
                                    </div>
                                </label>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                <button type="submit"
                                    class="w-full h-10 px-4 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors cursor-pointer flex items-center justify-center gap-2 text-sm">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    Create Gift Offer
                                </button>
                                <a href="{{ route('admin.gifts.index') }}"
                                    class="block w-full text-center py-2 text-slate-500 hover:text-slate-700 font-medium text-sm transition-colors cursor-pointer">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tips Card --}}
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-5">
                        <h4 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-3">Quick Tips</h4>
                        <ul class="space-y-2 text-xs text-slate-600">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Upload a clear brand logo for better visibility</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Use compelling descriptions to increase clicks</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Verify the offer link works before publishing</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logo-preview');
                    preview.innerHTML =
                        `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Logo Preview">`;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
