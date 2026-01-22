@extends('admin.layout')

@section('title', 'Record New Voice')

@section('page-title', 'Voice Capture')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.testimonials.index') }}"
                class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-4 group">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Voices
            </a>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">Capture Client Voice</h3>
            <p class="text-slate-500 mt-2">Document the impact of your work through client endorsements.</p>
        </div>

        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    {{-- Core Feedback Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="quote" class="w-4 h-4 mr-2"></i>
                            The Endorsement
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">The Narrative <span
                                        class="text-red-500">*</span></label>
                                <textarea name="feedback" rows="6"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft resize-none {{ $errors->has('feedback') ? 'border-red-500 ring-4 ring-red-500/10' : '' }}"
                                    placeholder="What did the client say about your collaboration?">{{ old('feedback') }}</textarea>
                                @error('feedback')
                                    <p class="mt-2 text-xs font-bold text-red-500 uppercase tracking-tight">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Project Context</label>
                                    <select name="project_id"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft">
                                        <option value="">General / No Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Performance Rating</label>
                                    <select name="rating"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}"
                                                {{ old('rating', 5) == $i ? 'selected' : '' }}>{{ $i }} Stars
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Identity Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="user-check" class="w-4 h-4 mr-2"></i>
                            Client Identity
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Full Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft {{ $errors->has('name') ? 'border-red-500 ring-4 ring-red-500/10' : '' }}"
                                    placeholder="e.g., Sarah Jenkins">
                                @error('name')
                                    <p class="mt-2 text-xs font-bold text-red-500 uppercase tracking-tight">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Designation</label>
                                <input type="text" name="designation" value="{{ old('designation') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                    placeholder="e.g., CEO at TechFlow">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Company / Organization</label>
                            <input type="text" name="company" value="{{ old('company') }}"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                placeholder="e.g., TechFlow Inc.">
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-8">
                    <div class="bg-indigo-900 rounded-[2.5rem] p-8 text-white shadow-lg shadow-indigo-900/20">
                        <h4 class="text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-6">Publication</h4>
                        <div class="space-y-6">
                            <div
                                class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                                <span class="text-sm font-bold">Show Publicly</span>
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
                                    class="block text-[10px] font-bold text-indigo-300 uppercase tracking-widest mb-2">Display
                                    Weight</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                    class="w-full px-5 py-3 bg-white/10 border border-white/10 rounded-xl focus:ring-2 focus:ring-white/20 focus:outline-none transition-soft text-sm font-bold"
                                    placeholder="0">
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-white text-indigo-900 rounded-2xl font-black text-sm uppercase tracking-widest hover:shadow-xl hover:shadow-white/10 hover:-translate-y-0.5 transition-soft">
                                <i data-lucide="save" class="w-4 h-4 inline-block mr-2"></i>
                                Save Voice
                            </button>
                        </div>
                    </div>

                    {{-- Avatar Card --}}
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm text-center">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Client Glyph</h4>
                        <div
                            class="mt-1 flex justify-center px-6 py-8 border-2 border-dashed border-slate-200 rounded-2xl hover:border-indigo-400 hover:bg-slate-50/50 transition-soft relative overflow-hidden group">
                            <input type="file" name="avatar_image" accept="image/*"
                                class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <div class="text-center group-hover:scale-105 transition-transform">
                                <i data-lucide="user" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-[10px] font-bold text-slate-500">Upload Avatar</p>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-4 leading-relaxed italic">"Square ratio works best for
                            client avatars."</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
