@extends('admin.layout')

@section('title', 'Create Footer')

@section('page-title', 'Footer Forge')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-10">
            <a href="{{ route('admin.footer.index') }}"
                class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-4 group">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Footer List
            </a>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">Create New Footer</h3>
            <p class="text-slate-500 mt-2">Configure footer content, links, and social media for your portfolio.</p>
        </div>

        <form action="{{ route('admin.footer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Main Content Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    {{-- Logo & Description Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="layout" class="w-4 h-4 mr-2"></i>
                            Brand & Description
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Logo Text <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="logo_text" value="{{ old('logo_text') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft {{ $errors->has('logo_text') ? 'border-red-500 ring-4 ring-red-500/10' : '' }}"
                                    placeholder="e.g., Your Brand Name">
                                @error('logo_text')
                                    <p class="mt-2 text-xs font-bold text-red-500 uppercase tracking-tight">{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                                <textarea name="description" rows="3"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft resize-none"
                                    placeholder="Brief description of your brand or services...">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Logo Image</label>
                                <div
                                    class="mt-1 flex justify-center px-6 py-8 border-2 border-dashed border-slate-200 rounded-2xl hover:border-indigo-400 hover:bg-slate-50/50 transition-soft relative overflow-hidden group">
                                    <input type="file" name="logo_image" accept="image/*"
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <div class="text-center group-hover:scale-105 transition-transform">
                                        <i data-lucide="image" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                        <p class="text-[10px] font-bold text-slate-500">Drop logo image or Browse</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Information Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                            Contact Information
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                    placeholder="contact@example.com">
                            </div>
                        </div>
                    </div>

                    {{-- Social Links Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="share-2" class="w-4 h-4 mr-2"></i>
                            Social Media Links
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" value="{{ old('linkedin_url') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                    placeholder="https://linkedin.com/in/yourprofile">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Twitter URL</label>
                                <input type="url" name="twitter_url" value="{{ old('twitter_url') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                    placeholder="https://twitter.com/yourhandle">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">GitHub URL</label>
                                <input type="url" name="github_url" value="{{ old('github_url') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                    placeholder="https://github.com/yourusername">
                            </div>
                        </div>
                    </div>

                    {{-- Footer Links Columns Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="link" class="w-4 h-4 mr-2"></i>
                            Footer Links Columns
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            {{-- Column 1 --}}
                            <div class="space-y-4">
                                <h5 class="text-sm font-bold text-slate-900">Column 1</h5>
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="space-y-2">
                                        <input type="text" name="column1_links[{{ $i }}][text]"
                                            value="{{ old('column1_links.' . $i . '.text') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm"
                                            placeholder="Link text {{ $i + 1 }}">
                                        <input type="text" name="column1_links[{{ $i }}][url]"
                                            value="{{ old('column1_links.' . $i . '.url') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm"
                                            placeholder="URL">
                                    </div>
                                @endfor
                            </div>

                            {{-- Column 2 --}}
                            <div class="space-y-4">
                                <h5 class="text-sm font-bold text-slate-900">Column 2</h5>
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="space-y-2">
                                        <input type="text" name="column2_links[{{ $i }}][text]"
                                            value="{{ old('column2_links.' . $i . '.text') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm"
                                            placeholder="Link text {{ $i + 1 }}">
                                        <input type="text" name="column2_links[{{ $i }}][url]"
                                            value="{{ old('column2_links.' . $i . '.url') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm"
                                            placeholder="URL">
                                    </div>
                                @endfor
                            </div>

                            {{-- Column 3 --}}
                            <div class="space-y-4">
                                <h5 class="text-sm font-bold text-slate-900">Column 3</h5>
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="space-y-2">
                                        <input type="text" name="column3_links[{{ $i }}][text]"
                                            value="{{ old('column3_links.' . $i . '.text') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm"
                                            placeholder="Link text {{ $i + 1 }}">
                                        <input type="text" name="column3_links[{{ $i }}][url]"
                                            value="{{ old('column3_links.' . $i . '.url') }}"
                                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-soft text-sm"
                                            placeholder="URL">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Copyright & Legal Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            Copyright & Legal
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Copyright Text</label>
                                <input type="text" name="copyright_text"
                                    value="{{ old('copyright_text', '© ' . date('Y') . ' Your Brand. All rights reserved.') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Privacy Policy URL</label>
                                    <input type="text" name="privacy_policy_url"
                                        value="{{ old('privacy_policy_url') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                        placeholder="/privacy-policy">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Terms of Service URL</label>
                                    <input type="text" name="terms_url" value="{{ old('terms_url') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                        placeholder="/terms">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEO Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                            SEO Settings
                        </h4>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Meta Title</label>
                                <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft"
                                    placeholder="SEO title for footer section">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Meta Description</label>
                                <textarea name="meta_description" rows="3"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-soft resize-none"
                                    placeholder="SEO description for footer section">{{ old('meta_description') }}</textarea>
                            </div>
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
                                <span class="text-sm font-bold">Active Status</span>
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
                                Save Footer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
