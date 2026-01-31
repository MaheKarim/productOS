@extends('user.layout')

@section('title', 'AI Resume Builder')

@section('content')
    <script>
        function resumeBuilder() {
            return {
                isUploading: false,
                resumeUploaded: {{ $user->resume_data ? 'true' : 'false' }},
                resumeName: '{{ $user->resume_data['name'] ?? 'Your Profile' }}',
                parsedData: @json($user->resume_data),
                jobDescription: '',
                isGenerating: false,
                generated: false,

                get isValidToGenerate() {
                    return this.resumeUploaded && this.jobDescription.length >= 50 && !this.isGenerating;
                },

                async uploadResume(e) {
                    console.log('uploadResume called');
                    const file = e.target.files[0];
                    if (!file) return;

                    this.isUploading = true;
                    const formData = new FormData();
                    formData.append('resume', file);

                    try {
                        const response = await fetch('{{ route('resume-builder.upload') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Upload failed:', errorText);
                            alert('Upload failed: ' + errorText);
                            return;
                        }

                        const result = await response.json();

                        if (result.success) {
                            this.resumeUploaded = true;
                            this.parsedData = result.data;
                            this.resumeName = result.data.name || 'Uploaded Resume';
                            alert('Resume uploaded and parsed successfully!');
                        } else {
                            alert('Upload failed: ' + (result.message || 'Unknown error'));
                        }
                    } catch (err) {
                        console.error('Upload error:', err);
                        alert('Upload error: ' + err.message);
                    } finally {
                        this.isUploading = false;
                    }
                },

                async generateResume() {
                    console.log('generateResume called');
                    console.log('isValidToGenerate:', this.isValidToGenerate);
                    console.log('resumeUploaded:', this.resumeUploaded);
                    console.log('jobDescription length:', this.jobDescription.length);
                    console.log('isGenerating:', this.isGenerating);

                    if (!this.isValidToGenerate) {
                        console.log('Cannot generate - validation failed');
                        alert('Please upload a resume and enter a job description (min 50 characters)');
                        return;
                    }

                    this.isGenerating = true;
                    this.generated = false;

                    try {
                        const response = await fetch('{{ route('resume-builder.generate') }}', {
                            method: 'POST',
                            body: JSON.stringify({
                                job_description: this.jobDescription
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        console.log('Response status:', response.status);

                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Generation failed:', errorText);
                            alert('Generation failed: ' + errorText);
                            return;
                        }

                        const result = await response.json();
                        console.log('Generation result:', result);

                        if (result.success) {
                            this.generated = true;
                            setTimeout(() => {
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }, 100);
                        } else {
                            alert('Generation failed: ' + (result.message || 'Unknown error'));
                        }
                    } catch (err) {
                        console.error('Generate error:', err);
                        alert('An unexpected error occurred: ' + err.message);
                    } finally {
                        this.isGenerating = false;
                    }
                }
            }
        }
    </script>

    <div class="relative min-h-screen py-8" x-data="resumeBuilder()">

        <!-- Ambient Background Elements -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            <div
                class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-purple-200/40 rounded-full blur-[100px] opacity-60 mix-blend-multiply animate-blob">
            </div>
            <div
                class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-200/40 rounded-full blur-[100px] opacity-60 mix-blend-multiply animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-32 left-20 w-[600px] h-[600px] bg-indigo-200/40 rounded-full blur-[120px] opacity-50 mix-blend-multiply animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    AI-Powered Career Tools
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Tailor Your Resume <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">in
                        Seconds</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Upload your base resume, paste a job description, and let our AI engine rephrase your experience to beat
                    ATS and impress recruiters.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Column: Upload & Profile (Col-span-4) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Step 1 Card -->
                    <div
                        class="group relative bg-white/70 backdrop-blur-xl rounded-3xl p-1 border border-white/50 shadow-xl shadow-slate-200/50 overflow-hidden transition-all hover:shadow-2xl hover:shadow-indigo-100/50">
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-white/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>

                        <div class="relative bg-white/50 rounded-[1.4rem] p-6 h-full flex flex-col">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-500/30">
                                        1</div>
                                    <h2 class="text-lg font-bold text-slate-800">Base Resume</h2>
                                </div>
                                <!-- Verified Badge if uploaded -->
                                <div x-show="resumeUploaded" x-transition
                                    class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-lg flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Ready
                                </div>
                            </div>

                            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                                Upload your existing resume (PDF/DOCX). We'll parse your skills and experience to use as a
                                foundation.
                            </p>

                            <!-- Upload Zone -->
                            <div class="relative group/upload">
                                <label
                                    class="relative flex flex-col items-center justify-center w-full h-40 rounded-2xl border-2 border-dashed cursor-pointer transition-all duration-300 overflow-hidden"
                                    :class="isUploading ? 'border-indigo-500 bg-indigo-50/50' :
                                        'border-slate-300 hover:border-indigo-400 bg-slate-50/50 hover:bg-white'">

                                    <!-- Decorative BG Pattern -->
                                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                                        style="background-image: radial-gradient(#6366f1 1px, transparent 1px); background-size: 16px 16px;">
                                    </div>

                                    <!-- Idle State -->
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center z-10"
                                        x-show="!isUploading">
                                        <div
                                            class="w-12 h-12 mb-3 rounded-full bg-white shadow-md flex items-center justify-center group-hover/upload:scale-110 transition-transform duration-300">
                                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="mb-1 text-sm font-semibold text-slate-700">Click to upload</p>
                                        <p class="text-xs text-slate-400">PDF or DOCX (max 5MB)</p>
                                    </div>

                                    <!-- Loading State -->
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 z-10"
                                        x-show="isUploading" style="display: none;">
                                        <div class="relative w-12 h-12 mb-3">
                                            <div class="absolute inset-0 rounded-full border-4 border-indigo-100"></div>
                                            <div
                                                class="absolute inset-0 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin">
                                            </div>
                                        </div>
                                        <p class="text-sm text-indigo-600 font-bold animate-pulse">Analyzing...</p>
                                    </div>

                                    <input type="file" class="hidden" @change="uploadResume" accept=".pdf,.docx">
                                </label>
                            </div>

                            <!-- File Uploaded Card (PDF Style) -->
                            <div x-show="resumeUploaded" x-transition.zoom.duration.300ms style="display: none;"
                                class="mt-2">
                                <div
                                    class="relative overflow-hidden bg-white border border-slate-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow group/file">
                                    <!-- Red accent for PDF feel -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500"></div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <!-- PDF/Doc Icon -->
                                            <div
                                                class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center shrink-0 border border-red-100">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800 line-clamp-1"
                                                    x-text="resumeName">Resume.pdf</p>
                                                <p
                                                    class="text-[10px] text-slate-500 uppercase font-semibold tracking-wider">
                                                    Uploaded & Parsed</p>
                                            </div>
                                        </div>

                                        <!-- Replace Button -->
                                        <button @click="resumeUploaded = false"
                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Replace File">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Extracted Data Preview (Glass) -->
                    <div class="bg-white/40 backdrop-blur-md rounded-3xl border border-white/60 p-6 shadow-lg"
                        x-show="parsedData">
                        <h3 class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z">
                                </path>
                            </svg>
                            Extracted Profile
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-400 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold text-slate-400">Identity</label>
                                    <div class="text-sm font-bold text-slate-800" x-text="parsedData?.name || '-'"></div>
                                    <div class="text-xs text-slate-500" x-text="parsedData?.email || '-'"></div>
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400 mb-2 block">Top Skills
                                    Detected</label>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="skill in (parsedData?.skills || [])">
                                        <span
                                            class="px-2.5 py-1 bg-white/80 border border-slate-100 text-slate-600 rounded-lg text-[11px] font-medium shadow-sm"
                                            x-text="skill"></span>
                                    </template>
                                    <span x-show="!parsedData?.skills?.length" class="text-xs text-slate-400 italic">No
                                        skills automatically detected.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: JD & Action (Col-span-8) -->
                <div class="lg:col-span-8 space-y-8">

                    <!-- Step 2: JD Input -->
                    <div
                        class="relative bg-white rounded-[2rem] border border-slate-200 shadow-2xl shadow-slate-200/50 p-1">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-500/30">
                                        2</div>
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-800">Target Role</h2>
                                        <p class="text-xs text-slate-500">Paste the job description you are applying for
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="relative group">
                                <div
                                    class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-20 group-focus-within:opacity-100 transition duration-500 blur">
                                </div>
                                <div class="relative">
                                    <textarea x-model="jobDescription"
                                        class="w-full h-72 p-6 bg-slate-50 border-0 rounded-xl focus:ring-0 text-slate-700 text-sm leading-7 placeholder:text-slate-400 resize-none font-medium transition-colors focus:bg-white"
                                        placeholder="Paste the full job description here...
• Responsibilities
• Requirements
• Desired Skills"></textarea>

                                    <!-- Character Count -->
                                    <div class="absolute bottom-4 right-4 text-xs font-mono px-2 py-1 bg-white rounded-md border border-slate-200 text-slate-400 shadow-sm transition-colors"
                                        :class="jobDescription.length >= 50 ? 'text-green-600 border-green-200 bg-green-50' : ''">
                                        <span x-text="jobDescription.length">0</span> chars
                                    </div>
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="mt-8 flex items-center justify-end gap-4">
                                <div class="text-xs text-slate-400 italic" x-show="!isValidToGenerate && !isGenerating">
                                    <span x-show="!resumeUploaded">Upload resume first • </span>
                                    <span x-show="jobDescription.length < 50">Paste JD (min 50 chars)</span>
                                </div>

                                <!-- New Submit Button Design -->
                                <button type="button" @click.prevent="generateResume" :disabled="!isValidToGenerate"
                                    class="group relative inline-flex items-center justify-center px-10 py-5 text-base font-bold text-white transition-all duration-300 shadow-xl rounded-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 overflow-hidden transform hover:-translate-y-1"
                                    :class="!isValidToGenerate ?
                                        'bg-slate-300 cursor-not-allowed opacity-70 shadow-none hover:translate-y-0' :
                                        'bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 hover:shadow-2xl hover:shadow-indigo-500/40'">

                                    <!-- Background Animation -->
                                    <div
                                        class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-[200%] rotate-45 transition-transform duration-1000 group-hover:translate-x-[200%]">
                                    </div>

                                    <span class="relative flex items-center gap-3">
                                        <template x-if="!isGenerating">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-6 h-6 text-indigo-100" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                                    </path>
                                                </svg>
                                                <span class="tracking-wide text-lg">Generate Magic Resume</span>
                                            </div>
                                        </template>

                                        <template x-if="isGenerating">
                                            <div class="flex items-center gap-3">
                                                <svg class="animate-spin w-6 h-6 text-white"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                <span class="tracking-wide text-lg animate-pulse">Crafting your new
                                                    CV...</span>
                                            </div>
                                        </template>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Result Section -->
                    <div x-show="generated" style="display: none;" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="relative overflow-hidden rounded-[2rem] bg-slate-900 border border-slate-800 shadow-2xl">

                        <!-- Background Effects -->
                        <div
                            class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-indigo-500/30 blur-[100px] rounded-full pointer-events-none">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-purple-500/20 blur-[100px] rounded-full pointer-events-none">
                        </div>

                        <div class="relative p-10">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                                <div>
                                    <h2 class="text-3xl font-bold text-white mb-2">Resume Optimized! 🚀</h2>
                                    <p class="text-slate-400 text-lg">Your new ATS-ready resume is ready for download.</p>
                                </div>
                                <div
                                    class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full border border-white/10 backdrop-blur-sm">
                                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                                    <span class="text-xs font-bold text-green-300 uppercase tracking-widest">AI
                                        Processed</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('resume-builder.download', ['format' => 'pdf']) }}" target="_blank"
                                    class="group relative flex items-center justify-center gap-3 p-6 bg-white rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:scale-[1.02] shadow-xl">
                                    <div
                                        class="bg-red-50 p-3 rounded-xl border border-red-100 group-hover:bg-red-100 transition-colors">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-slate-900 font-bold text-lg">Download PDF</p>
                                        <p class="text-slate-500 text-xs">Best for Applications</p>
                                    </div>
                                    <div
                                        class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity text-slate-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </div>
                                </a>

                                <a href="{{ route('resume-builder.download', ['format' => 'docx']) }}" target="_blank"
                                    class="group relative flex items-center justify-center gap-3 p-6 bg-slate-800/80 rounded-2xl hover:bg-slate-800 transition-all border border-slate-700 hover:border-slate-600 hover:scale-[1.02] shadow-xl">
                                    <div
                                        class="bg-blue-900/50 p-3 rounded-xl border border-blue-800 group-hover:bg-blue-900 transition-colors">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-white font-bold text-lg">Download Word</p>
                                        <p class="text-slate-400 text-xs">Formatted for Editing</p>
                                    </div>
                                    <div
                                        class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity text-slate-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <style>
            @keyframes blob {
                0% {
                    transform: translate(0px, 0px) scale(1);
                }

                33% {
                    transform: translate(30px, -50px) scale(1.1);
                }

                66% {
                    transform: translate(-20px, 20px) scale(0.9);
                }

                100% {
                    transform: translate(0px, 0px) scale(1);
                }
            }

            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    @endsection
