@extends('admin.layout')

@section('title', 'Draft New Service')

@section('page-title', 'Service Forge')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.services.index') }}"
                class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-4 group">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Inventory
            </a>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">Forge New Service</h3>
            <p class="text-slate-500 mt-2">Define a core offering that drives value for your portfolio visitors.</p>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Main Content Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    {{-- Basic Info Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            Core Definition
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Service Identity <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft {{ $errors->has('title') ? 'border-red-500 ring-4 ring-red-500/10' : '' }}"
                                    placeholder="e.g., Strategic Product Design">
                                @error('title')
                                    <p class="mt-2 text-xs font-bold text-red-500 uppercase tracking-tight">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">The Narrative <span
                                        class="text-red-500">*</span></label>
                                <textarea name="description" rows="5"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft resize-none {{ $errors->has('description') ? 'border-red-500 ring-4 ring-red-500/10' : '' }}"
                                    placeholder="Describe the value proposition in detail...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-xs font-bold text-red-500 uppercase tracking-tight">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Outcome Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="target" class="w-4 h-4 mr-2"></i>
                            Impact & Outcomes
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Pain Points Solved</label>
                                <textarea name="problem_solves" rows="3"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft resize-none"
                                    placeholder="What friction do you remove?">{{ old('problem_solves') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tangible Deliverable</label>
                                <textarea name="tangible_outcome" rows="3"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft resize-none"
                                    placeholder="What does the client walk away with?">{{ old('tangible_outcome') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Features Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="check-circle-2" class="w-4 h-4 mr-2"></i>
                            Key Capabilities (Bento Style)
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="relative group">
                                    <span
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-200 group-focus-within:text-indigo-200 transition-colors uppercase">Cap
                                        0{{ $i + 1 }}</span>
                                    <input type="text" name="features[{{ $i }}]"
                                        value="{{ old('features.' . $i) }}"
                                        class="w-full pl-5 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                        placeholder="Capability detail...">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Sidebar Configuration --}}
                <div class="space-y-8">
                    {{-- Status Card --}}
                    <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white shadow-lg shadow-indigo-900/20">
                        <h4 class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-6">Publication
                            Settings</h4>

                        <div class="space-y-6">
                            <div
                                class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                                <span class="text-sm font-bold">Public Listing</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-indigo-950 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-500">
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-2">Priority
                                    Order</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                    class="w-full px-5 py-3 bg-white/10 border border-white/10 rounded-xl focus:ring-2 focus:ring-white/20 focus:outline-none transition-soft text-sm font-bold"
                                    placeholder="0">
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-white text-indigo-900 rounded-2xl font-black text-sm uppercase tracking-widest hover:shadow-xl hover:shadow-white/10 hover:-translate-y-0.5 transition-soft">
                                <i data-lucide="save" class="w-4 h-4 inline-block mr-2 scale-110"></i>
                                Save Draft
                            </button>
                        </div>
                    </div>

                    {{-- Icon Card --}}
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Visual Identity</h4>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Category Set</label>
                                <select name="icon_type"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm">
                                    <option value="fa-solid"
                                        {{ old('icon_type', 'fa-solid') === 'fa-solid' ? 'selected' : '' }}>FontAwesome
                                        Solid</option>
                                    <option value="fa-regular" {{ old('icon_type') === 'fa-regular' ? 'selected' : '' }}>
                                        FontAwesome Regular</option>
                                    <option value="fa-brands" {{ old('icon_type') === 'fa-brands' ? 'selected' : '' }}>
                                        Digital Brands</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Icon Glyph ID</label>
                                <div class="relative">
                                    <i
                                        class="fa-solid {{ old('icon', 'fa-cube') }} absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input type="text" name="icon" value="{{ old('icon', 'fa-cube') }}"
                                        class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm font-mono"
                                        placeholder="fa-cube">
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Custom Cover Image</label>
                                <div
                                    class="mt-1 flex justify-center px-6 py-8 border-2 border-dashed border-slate-200 rounded-2xl hover:border-indigo-400 hover:bg-slate-50/50 transition-soft relative overflow-hidden group">
                                    <input type="file" name="image" accept="image/*"
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <div class="text-center group-hover:scale-105 transition-transform">
                                        <i data-lucide="cloud-upload" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-[10px] font-bold text-slate-500">Drop Glyph or Browse</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
