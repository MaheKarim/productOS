@extends('admin.layout')

@section('page-title', 'Edit Job')

@section('content')
    <div class="max-w-5xl mx-auto" x-data="jobForm()">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.jobs.index') }}"
                    class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-semibold text-slate-900">Edit Job</h1>
                <span class="px-2 py-0.5 text-xs font-mono text-slate-500 bg-slate-100 rounded border border-slate-200">ID:
                    {{ $job->id }}</span>
            </div>
            <p class="text-slate-500 text-sm ml-8">Update job listing details and publishing settings.</p>
        </div>

        <form action="{{ route('admin.jobs.update', $job) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Column: Main Info --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Job Details Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-medium text-slate-900">Job Details</h3>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Title --}}
                            <div>
                                <label for="job_title" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Job Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="job_title" name="job_title" x-model="form.job_title" required
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                @error('job_title')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Company --}}
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Company Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="company_name" name="company_name" x-model="form.company_name"
                                    required
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Location --}}
                                <div>
                                    <label for="location"
                                        class="block text-sm font-medium text-slate-700 mb-1.5">Location</label>
                                    <input type="text" id="location" name="location" x-model="form.location"
                                        placeholder="e.g. Remote, New York"
                                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                </div>
                                {{-- Type --}}
                                <div>
                                    <label for="job_type" class="block text-sm font-medium text-slate-700 mb-1.5">Job
                                        Type</label>
                                    <select id="job_type" name="job_type" x-model="form.job_type"
                                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                        <option value="Full-time">Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Freelance">Freelance</option>
                                        <option value="Internship">Internship</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Experience --}}
                                <div>
                                    <label for="experience_level"
                                        class="block text-sm font-medium text-slate-700 mb-1.5">Experience Level</label>
                                    <select id="experience_level" name="experience_level" x-model="form.experience_level"
                                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                        <option value="Entry">Entry Level</option>
                                        <option value="Mid-Level">Mid-Level</option>
                                        <option value="Senior">Senior</option>
                                        <option value="Lead">Lead</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Executive">Executive</option>
                                    </select>
                                </div>
                                {{-- Salary --}}
                                <div>
                                    <label for="salary_range" class="block text-sm font-medium text-slate-700 mb-1.5">Salary
                                        Range</label>
                                    <input type="text" id="salary_range" name="salary_range" x-model="form.salary_range"
                                        placeholder="e.g. $100k - $150k"
                                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                </div>
                            </div>

                            {{-- Expiry Date --}}
                            <div>
                                <label for="expires_at" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Expiry Date <span class="text-slate-400 text-xs font-normal">(optional)</span>
                                </label>
                                <input type="date" id="expires_at" name="expires_at" x-model="form.expires_at"
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                <p class="mt-1 text-xs text-slate-400">Job will be hidden from public listings after this
                                    date</p>
                            </div>

                            {{-- Source URL --}}
                            <div>
                                <label for="source_url"
                                    class="block text-sm font-medium text-slate-700 mb-1.5">Application/Source URL</label>
                                <input type="url" id="source_url" name="source_url" x-model="form.source_url"
                                    placeholder="https://..."
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Skills Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-medium text-slate-900">Skills & Requirements</h3>
                        </div>

                        <div class="p-6">
                            <label for="skills" class="block text-sm font-medium text-slate-700 mb-1.5">Skills (Comma
                                separated)</label>
                            <input type="text" id="skills" x-model="skillsInput" @blur="updateSkills"
                                @keydown.enter.prevent="updateSkills" placeholder="React, PHP, Communication..."
                                class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm mb-3">

                            <div class="flex flex-wrap gap-2">
                                <template x-for="skill in form.job_data.skills" :key="skill">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200 cursor-pointer hover:bg-slate-200 transition-colors">
                                        <span x-text="skill"></span>
                                        <button type="button" @click="removeSkill(skill)"
                                            class="text-slate-400 hover:text-red-500 transition-colors">
                                            <i data-lucide="x" class="w-3 h-3"></i>
                                        </button>
                                    </span>
                                </template>
                            </div>

                            {{-- Hidden inputs for skills array --}}
                            <template x-for="(skill, index) in form.job_data.skills" :key="index">
                                <input type="hidden" :name="'job_data[skills][' + index + ']'" :value="skill">
                            </template>
                        </div>
                    </div>

                    {{-- Job Details Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-blue-100 rounded flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-3.5 h-3.5 text-blue-600"></i>
                                </div>
                                <h3 class="text-sm font-medium text-slate-900">Job Details</h3>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Detailed description of the role, responsibilities,
                                requirements, and benefits.</p>
                        </div>

                        <div class="p-6">
                            <textarea id="job_details" name="job_details" x-model="form.job_details" rows="12"
                                placeholder="Enter the full job description here..."
                                class="w-full px-3 py-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm resize-y min-h-[200px]"></textarea>
                            @error('job_details')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Right Column: Settings --}}
                <div class="lg:col-span-1 space-y-6">
                    {{-- Publishing Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm sticky top-6">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-medium text-slate-900">Publishing</h3>
                        </div>

                        <div class="p-6 space-y-5">
                            {{-- Status --}}
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                                <select id="status" name="status" x-model="form.status"
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="expired">Expired</option>
                                </select>
                            </div>

                            {{-- Category --}}
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" name="category_id" x-model="form.category_id" required
                                    class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Featured Toggle --}}
                            <div
                                class="flex items-center justify-between py-3 px-4 bg-slate-50 rounded-lg border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="star" class="w-4 h-4 text-amber-600"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">Featured Job</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1" x-model="form.is_featured"
                                        class="sr-only peer">
                                    <div
                                        class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900">
                                    </div>
                                </label>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                <button type="submit"
                                    class="w-full h-10 px-4 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors cursor-pointer flex items-center justify-center gap-2 text-sm">
                                    <i data-lucide="save" class="w-4 h-4"></i>
                                    Update Job
                                </button>
                                <a href="{{ route('admin.jobs.index') }}"
                                    class="block w-full text-center py-2 text-slate-500 hover:text-slate-700 font-medium text-sm transition-colors cursor-pointer">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                        <h4 class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-4">Quick Stats</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">Views</span>
                                <span
                                    class="text-sm font-medium text-slate-900">{{ number_format($job->views_count ?? 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">Applications</span>
                                <span
                                    class="text-sm font-medium text-slate-900">{{ number_format($job->applications_count ?? 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">Posted</span>
                                <span
                                    class="text-sm font-medium text-slate-900">{{ $job->posted_date ? $job->posted_date->format('M d, Y') : 'Not published' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function jobForm() {
            return {
                skillsInput: '',
                form: {
                    job_title: '{{ addslashes($job->job_title) }}',
                    company_name: '{{ addslashes($job->company_name) }}',
                    location: '{{ addslashes($job->location ?? '') }}',
                    job_type: '{{ $job->job_type ?? 'Full-time' }}',
                    experience_level: '{{ $job->experience_level ?? 'Mid-Level' }}',
                    salary_range: '{{ addslashes($job->salary_range ?? '') }}',
                    expires_at: '{{ $job->expires_at ? $job->expires_at->format('Y-m-d') : '' }}',
                    job_details: `{{ addslashes($job->job_details ?? '') }}`,
                    source_url: '{{ addslashes($job->source_url ?? '') }}',
                    status: '{{ $job->status }}',
                    category_id: '{{ $job->category_id }}',
                    is_featured: {{ $job->is_featured ? 'true' : 'false' }},
                    job_data: {
                        skills: @json($job->job_data['skills'] ?? [])
                    }
                },
                updateSkills() {
                    if (this.skillsInput) {
                        const newSkills = this.skillsInput.split(',').map(s => s.trim()).filter(s => s);
                        this.form.job_data.skills = [...new Set([...this.form.job_data.skills, ...newSkills])];
                        this.skillsInput = '';
                    }
                },
                removeSkill(skill) {
                    this.form.job_data.skills = this.form.job_data.skills.filter(s => s !== skill);
                }
            }
        }
    </script>
@endsection
