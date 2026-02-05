@extends('admin.layout')

@section('page-title', 'Post New Job')

@section('content')
    <div class="max-w-5xl mx-auto" x-data="jobForm()">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.jobs.index') }}"
                    class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-semibold text-slate-900">Post New Job</h1>
            </div>
            <p class="text-slate-500 text-sm ml-8">Fill in the job details or use AI to auto-extract from a job description.
            </p>
        </div>

        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf

            {{-- AI Parser Section --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-violet-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="sparkles" class="w-4 h-4 text-violet-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-900">AI Auto-Fill</h3>
                            <p class="text-xs text-slate-500">Paste a job description to extract details automatically</p>
                        </div>
                    </div>
                    <button type="button" @click="parseJobDescription" :disabled="parsing"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-wait cursor-pointer">
                        <span x-show="!parsing">Extract Details</span>
                        <span x-show="parsing">Processing...</span>
                        <i data-lucide="arrow-right" class="w-4 h-4" x-show="!parsing"></i>
                    </button>
                </div>
                <div class="p-6">
                    <textarea x-model="rawDescription"
                        class="w-full h-28 px-3 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm resize-none"
                        placeholder="Paste full job description here (e.g. 'We are looking for a Senior Product Manager...')"></textarea>
                </div>
            </div>

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
                                    placeholder="e.g. Senior Product Manager"
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
                                    required placeholder="e.g. Google, StartupXYZ"
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
                                placeholder="Enter the full job description here...

Example:
## About the Role
We are looking for a talented Product Manager to join our team...

## Responsibilities
- Lead product strategy and roadmap
- Collaborate with engineering and design teams

## Requirements
- 5+ years of product management experience
- Strong analytical skills

## Benefits
- Competitive salary
- Remote work options"
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
                                </select>
                            </div>

                            {{-- Category --}}
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" name="category_id" required
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
                                    <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                                    <div
                                        class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900">
                                    </div>
                                </label>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                <button type="submit"
                                    class="w-full h-10 px-4 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors cursor-pointer flex items-center justify-center gap-2 text-sm">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                    Create Job Listing
                                </button>
                                <a href="{{ route('admin.jobs.index') }}"
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
                                <span>Use specific job titles for better visibility</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Include salary range to attract more applicants</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                <span>Add relevant skills for better matching</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function jobForm() {
            return {
                rawDescription: '',
                parsing: false,
                skillsInput: '',
                form: {
                    job_title: '',
                    company_name: '',
                    location: '',
                    job_type: 'Full-time',
                    experience_level: 'Mid-Level',
                    salary_range: '',
                    expires_at: '',
                    job_details: '',
                    source_url: '',
                    status: 'active',
                    job_data: {
                        skills: []
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
                },
                parseJobDescription() {
                    if (!this.rawDescription || this.rawDescription.length < 10) return;

                    this.parsing = true;

                    fetch('{{ route('admin.jobs.parse') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                description: this.rawDescription
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(result => {
                            this.parsing = false;
                            console.log('Parse result:', result);
                            if (result.success && result.data) {
                                const data = result.data;
                                this.form.job_title = data.job_title || this.form.job_title || '';
                                this.form.company_name = data.company_name || this.form.company_name || '';
                                this.form.location = data.location || this.form.location || '';
                                this.form.job_type = data.job_type || this.form.job_type || 'Full-time';
                                this.form.experience_level = data.experience_level || this.form.experience_level ||
                                    'Mid-Level';
                                this.form.salary_range = data.salary_range || this.form.salary_range || '';
                                this.form.job_details = data.job_details || this.form.job_details || '';

                                if (data.job_data && Array.isArray(data.job_data.skills)) {
                                    this.form.job_data.skills = data.job_data.skills;
                                    this.skillsInput = data.job_data.skills.join(', ');
                                }
                            } else {
                                console.error('Parse failed:', result.message || 'Unknown error');
                                alert('Failed to parse job description: ' + (result.message || 'Please try again.'));
                            }
                        })
                        .catch(error => {
                            this.parsing = false;
                            console.error('Error parsing:', error);
                            alert('Failed to parse job description.');
                        });
                }
            }
        }
    </script>
@endsection
