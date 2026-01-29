<x-layout.minimal>
    @section('title', 'Complete Your Profile')

    <div class="min-h-screen w-full flex bg-slate-50" x-data="onboardingForm()" x-cloak>

        <!-- Left Side: Modern PM Experience (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#0F172A] overflow-hidden items-center justify-center p-12">
            <!-- Animated Gradient Blobs -->
            <div
                class="absolute top-[-20%] left-[-20%] w-[80%] h-[80%] rounded-full bg-violet-600/30 blur-[120px] animate-pulse">
            </div>
            <div class="absolute bottom-[-20%] right-[-20%] w-[80%] h-[80%] rounded-full bg-blue-600/30 blur-[120px] animate-pulse"
                style="animation-delay: 2s"></div>
            <div
                class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150">
            </div>

            <!-- Content Container -->
            <div class="relative z-10 w-full max-w-lg">
                <!-- Floating Elements Animation Container -->
                <div class="relative h-96 w-full mb-12">
                    <!-- Central Orb -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-gradient-to-br from-violet-500 to-indigo-500 rounded-full blur-2xl animate-pulse opacity-50">
                    </div>
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-md rounded-full border border-white/20 shadow-2xl flex items-center justify-center">
                        <i data-lucide="layers" class="w-16 h-16 text-white opacity-80"></i>
                    </div>

                    <!-- Floating PM Cards -->
                    <!-- Card 1: Strategy -->
                    <div class="absolute top-0 right-10 bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-xl shadow-xl transform rotate-6 animate-float"
                        style="animation-duration: 6s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center">
                                <i data-lucide="target" class="w-5 h-5 text-orange-400"></i>
                            </div>
                            <div>
                                <div class="text-white text-sm font-bold">Strategy</div>
                                <div class="text-white/50 text-xs">Vision & Goals</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Roadmap -->
                    <div class="absolute bottom-10 left-0 bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-xl shadow-xl transform -rotate-3 animate-float"
                        style="animation-duration: 7s; animation-delay: 1s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                <i data-lucide="map" class="w-5 h-5 text-blue-400"></i>
                            </div>
                            <div>
                                <div class="text-white text-sm font-bold">Roadmap</div>
                                <div class="text-white/50 text-xs">Q1 - Q4 Planning</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Analytics -->
                    <div class="absolute top-10 left-10 bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-xl shadow-xl transform -rotate-6 animate-float"
                        style="animation-duration: 8s; animation-delay: 0.5s;">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center">
                                <i data-lucide="bar-chart-2" class="w-5 h-5 text-green-400"></i>
                            </div>
                            <div>
                                <div class="text-white text-sm font-bold">Growth</div>
                                <div class="text-white/50 text-xs">+125% User / Mo</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-6">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Orchestrate Your <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-400 to-blue-400">Product
                            Vision</span>
                    </h2>
                    <p class="text-slate-400 text-lg max-w-sm mx-auto leading-relaxed">
                        Join the elite community of product managers building the future. Your personalized workspace
                        awaits.
                    </p>

                    <!-- Community Avatars -->
                    <div class="flex items-center justify-center -space-x-3 pt-4">
                        <img src="https://i.pravatar.cc/100?img=1" alt=""
                            class="w-10 h-10 rounded-full border-2 border-[#0F172A]">
                        <img src="https://i.pravatar.cc/100?img=5" alt=""
                            class="w-10 h-10 rounded-full border-2 border-[#0F172A]">
                        <img src="https://i.pravatar.cc/100?img=8" alt=""
                            class="w-10 h-10 rounded-full border-2 border-[#0F172A]">
                        <img src="https://i.pravatar.cc/100?img=12" alt=""
                            class="w-10 h-10 rounded-full border-2 border-[#0F172A]">
                        <div
                            class="w-10 h-10 rounded-full border-2 border-[#0F172A] bg-slate-800 flex items-center justify-center text-xs text-white font-medium">
                            +2k</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: The Form -->
        <div
            class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12 relative overflow-hidden bg-slate-50 lg:bg-white">
            <div class="w-full max-w-lg">
                <!-- Mobile Header (Only visible on small screens) -->
                <div class="lg:hidden text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-violet-600 mb-4 shadow-lg shadow-violet-500/30">
                        <i data-lucide="layers" class="w-6 h-6 text-white"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">ProductOS</h1>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8 relative h-1.5 bg-slate-100 rounded-full overflow-hidden w-full">
                    <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-violet-600 to-indigo-600 transition-all duration-700 ease-out rounded-full"
                        :style="'width: ' + progress + '%'"></div>
                </div>

                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Complete your profile</h1>
                    <p class="text-slate-500">Help us tailor your ProductOS experience.</p>
                </div>

                <form action="{{ route('onboarding.store') }}" method="POST" class="space-y-8" novalidate>
                    @csrf

                    <!-- Field 1: Job Role -->
                    <div class="space-y-2 group relative" x-on:click.outside="isDropdownOpen = false">
                        <label for="job_role"
                            class="block text-sm font-semibold text-slate-700 flex items-center gap-2">
                            Current Job Role
                        </label>
                        <div class="relative">
                            <input type="text" id="job_role_search" x-model="roleSearch"
                                x-on:focus="isDropdownOpen = true"
                                x-on:input="isDropdownOpen = true; if(roleSearch === '') selectedRole = '';"
                                placeholder="Select your role"
                                class="w-full pl-4 pr-10 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition-all outline-none font-medium placeholder-slate-400 text-slate-800 shadow-sm"
                                autocomplete="off">
                            <input type="hidden" name="job_role" x-model="selectedRole">
                            <!-- Icons -->
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <template x-if="roleSearch">
                                    <button type="button"
                                        @click="roleSearch = ''; selectedRole = ''; isDropdownOpen = true"
                                        class="hover:text-slate-600 p-1">
                                        <i data-lucide="x" class="w-4 h-4"></i>
                                    </button>
                                </template>
                                <template x-if="!roleSearch">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </template>
                            </div>

                            <!-- Dropdown -->
                            <div x-show="isDropdownOpen" x-transition.opacity.duration.200ms
                                class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-xl border border-slate-100 max-h-64 overflow-y-auto custom-scrollbar ring-1 ring-black/5">

                                <template x-if="Object.keys(filteredRoles).length === 0">
                                    <div class="p-4 text-center text-slate-500 text-sm">No roles found.</div>
                                </template>

                                <template x-for="(roles, group) in filteredRoles" :key="group">
                                    <div>
                                        <div class="px-4 py-2 bg-slate-50 text-xs font-bold text-slate-400 uppercase tracking-wider sticky top-0"
                                            x-text="group"></div>
                                        <template x-for="role in roles" :key="role">
                                            <button type="button" @click="selectRole(role)"
                                                class="w-full text-left px-5 py-2.5 text-sm text-slate-700 hover:bg-violet-50 hover:text-violet-700 transition-colors flex items-center justify-between group/item">
                                                <span x-text="role"
                                                    :class="{ 'font-semibold text-violet-700': selectedRole === role }"></span>
                                                <i data-lucide="check" class="w-4 h-4 text-violet-600 opacity-0"
                                                    :class="{ 'opacity-100': selectedRole === role }"></i>
                                            </button>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                        @error('job_role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Field 2: Years of Experience -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-slate-700">Years of Experience</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <input type="hidden" name="years_of_experience" x-model="selectedExperience">
                            @foreach ($yearsOfExperience as $option)
                                <button type="button" @click="selectedExperience = '{{ $option }}'"
                                    :class="selectedExperience === '{{ $option }}'
                                        ?
                                        'bg-violet-600 text-white border-violet-600 shadow-lg shadow-violet-500/30' :
                                        'bg-white text-slate-600 border-slate-200 hover:border-violet-300 hover:bg-violet-50'"
                                    class="px-3 py-3 rounded-xl border transition-all duration-200 text-sm font-medium focus:outline-none focus:ring-4 focus:ring-violet-500/10 active:scale-95">
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                        @error('years_of_experience')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Field 3: Company Name -->
                    <div class="space-y-2">
                        <label for="company_name" class="block text-sm font-semibold text-slate-700">Company
                            Name</label>
                        <input type="text" name="company_name" x-model="companyName" placeholder="e.g. Acme Corp"
                            class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-500/10 focus:border-violet-600 transition-all outline-none font-medium placeholder-slate-400 text-slate-800 shadow-sm">
                        @error('company_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="pt-4">
                        <button type="submit" :disabled="!selectedRole || !selectedExperience || !companyName"
                            :class="(!selectedRole || !selectedExperience || !companyName) ? 'opacity-50 cursor-not-allowed' :
                            'hover:-translate-y-0.5 hover:shadow-xl hover:shadow-violet-500/25'"
                            class="w-full py-4 bg-violet-600 text-white text-base font-bold rounded-xl shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Get Started</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </button>
                    </div>
                </form>

                <div
                    class="mt-8 pt-8 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <div>ProductOS &copy; {{ date('Y') }}</div>
                    <div class="flex items-center gap-4">
                        <a href="#" class="hover:text-slate-600">Privacy</a>
                        <a href="#" class="hover:text-slate-600">Terms</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #e2e8f0;
            border-radius: 20px;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(var(--tw-rotate));
            }

            50% {
                transform: translateY(-10px) rotate(var(--tw-rotate));
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>

    @push('scripts')
        <script>
            function onboardingForm() {
                return {
                    step: 1,
                    roleSearch: '',
                    selectedRole: @js(old('job_role', '')),
                    selectedExperience: @js(old('years_of_experience', '')),
                    companyName: @js(old('company_name', '')),
                    isDropdownOpen: false,
                    jobRoles: @js($jobRoles),

                    get filteredRoles() {
                        if (this.roleSearch === '') return this.jobRoles;

                        let result = {};
                        for (const [group, roles] of Object.entries(this.jobRoles)) {
                            const filtered = roles.filter(role =>
                                role.toLowerCase().includes(this.roleSearch.toLowerCase())
                            );
                            if (filtered.length > 0) {
                                result[group] = filtered;
                            }
                        }
                        return result;
                    },

                    selectRole(role) {
                        this.selectedRole = role;
                        this.roleSearch = role;
                        this.isDropdownOpen = false;
                    },

                    get progress() {
                        let count = 0;
                        if (this.selectedRole) count++;
                        if (this.selectedExperience) count++;
                        if (this.companyName.length > 1) count++;
                        return (count / 3) * 100;
                    }
                }
            }
        </script>
    @endpush
</x-layout.minimal>
