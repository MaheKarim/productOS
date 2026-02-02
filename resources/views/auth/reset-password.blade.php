<x-layout.app>
    <div class="min-h-screen relative overflow-hidden pt-32 pb-20 px-4">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-gradient-to-br from-violet-500/20 to-purple-600/15 rounded-full blur-[120px] animate-pulse">
            </div>
            <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] bg-gradient-to-tl from-blue-500/20 to-indigo-600/10 rounded-full blur-[120px] animate-pulse"
                style="animation-delay: 1s;"></div>
            <div
                class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-r from-cyan-400/10 via-blue-500/10 to-violet-500/10 rounded-full blur-[100px]">
            </div>
        </div>

        <!-- Floating Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-[10%] w-2 h-2 bg-violet-500/50 rounded-full animate-bounce"
                style="animation-duration: 2s;"></div>
            <div class="absolute top-40 right-[15%] w-1.5 h-1.5 bg-blue-500/50 rounded-full animate-bounce"
                style="animation-duration: 2.5s;"></div>
            <div class="absolute bottom-32 left-[20%] w-2 h-2 bg-indigo-500/50 rounded-full animate-bounce"
                style="animation-duration: 3s;"></div>
        </div>

        <div class="max-w-md mx-auto relative z-10">
            <div class="relative group">
                <!-- Glow Effect -->
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-violet-600 via-blue-600 to-purple-600 rounded-3xl blur-lg opacity-30 group-hover:opacity-40 transition-opacity duration-500">
                </div>

                <!-- Card Container -->
                <div
                    class="relative backdrop-blur-xl bg-white/80 border border-white/60 rounded-3xl p-8 md:p-10 shadow-2xl shadow-violet-500/10">

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-blue-600 shadow-lg shadow-violet-500/30 mb-5">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 font-['Space_Grotesk']">
                            Reset Password
                        </h2>
                        <p class="text-zinc-600 mt-2 font-['Archivo']">Create a new secure password for your account.
                        </p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            @foreach ($errors->all() as $error)
                                <p class="text-red-600 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $error }}
                                </p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST" class="space-y-5"
                        x-data="{
                            loading: false,
                            showPassword: false,
                            showConfirmPassword: false,
                            password: '',
                            get strength() {
                                let score = 0;
                                if (this.password.length >= 8) score++;
                                if (this.password.length >= 12) score++;
                                if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) score++;
                                if (/\d/.test(this.password)) score++;
                                if (/[^a-zA-Z0-9]/.test(this.password)) score++;
                                return score;
                            },
                            get strengthText() {
                                const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                                return texts[Math.min(this.strength, 4)];
                            },
                            get strengthColor() {
                                const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
                                return colors[Math.min(this.strength, 4)];
                            }
                        }" @submit="loading = true">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email Input -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                Email Address
                            </label>
                            <div class="relative group/input">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-violet-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
                                    required
                                    class="w-full pl-12 pr-4 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                    placeholder="john@example.com">
                            </div>
                        </div>

                        <!-- New Password Input -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                New Password
                            </label>
                            <div class="relative group/input">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-violet-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                                    required x-model="password"
                                    class="w-full pl-12 pr-12 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                    placeholder="••••••••">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-zinc-400 hover:text-violet-500 transition-colors cursor-pointer">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div x-show="password.length > 0" x-transition class="space-y-2">
                                <div class="flex gap-1">
                                    <template x-for="i in 5" :key="i">
                                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                            :class="i <= strength ? strengthColor : 'bg-zinc-200'"></div>
                                    </template>
                                </div>
                                <p class="text-xs font-medium transition-colors"
                                    :class="{
                                        'text-red-500': strength <= 1,
                                        'text-orange-500': strength === 2,
                                        'text-yellow-600': strength === 3,
                                        'text-blue-500': strength === 4,
                                        'text-green-500': strength === 5
                                    }">
                                    Password strength: <span x-text="strengthText"></span>
                                </p>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="space-y-2">
                            <label for="password_confirmation"
                                class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                Confirm New Password
                            </label>
                            <div class="relative group/input">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-violet-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </div>
                                <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'"
                                    name="password_confirmation" required
                                    class="w-full pl-12 pr-12 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                    placeholder="••••••••">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-zinc-400 hover:text-violet-500 transition-colors cursor-pointer">
                                    <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                                        style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="p-4 bg-zinc-50 rounded-xl border border-zinc-100">
                            <p class="text-xs font-semibold text-zinc-700 mb-2">Password Requirements:</p>
                            <ul class="text-xs text-zinc-500 space-y-1">
                                <li class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Minimum 8 characters
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Mix of uppercase & lowercase (recommended)
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Numbers & special characters (recommended)
                                </li>
                            </ul>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-3">
                            <button type="submit" :disabled="loading"
                                class="relative w-full py-4 bg-gradient-to-r from-violet-600 via-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-violet-500/30 transform transition-all duration-300 hover:shadow-xl hover:shadow-violet-500/40 hover:scale-[1.02] focus:ring-4 focus:ring-violet-500/30 active:scale-[0.98] cursor-pointer overflow-hidden group/btn disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:scale-100">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700">
                                </div>
                                <span class="relative flex items-center justify-center gap-2 font-['Space_Grotesk']">
                                    <template x-if="!loading">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Reset Password
                                        </span>
                                    </template>
                                    <template x-if="loading">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Resetting...
                                        </span>
                                    </template>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Back to Login -->
                    <div class="text-center mt-6">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-violet-600 transition-colors font-['Archivo'] cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Back to Sign In
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="flex items-center justify-center gap-6 mt-6 text-zinc-500 text-xs font-['Archivo']">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>SSL Secured</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Privacy Protected</span>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
