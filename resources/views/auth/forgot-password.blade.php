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
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 font-['Space_Grotesk']">
                            Forgot Password?
                        </h2>
                        <p class="text-zinc-600 mt-2 font-['Archivo']">No worries, we'll send you reset instructions.
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-green-600 text-sm flex items-center gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ session('status') }}
                            </p>
                        </div>
                    @endif

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

                    <form action="{{ route('password.email') }}" method="POST" class="space-y-5"
                        x-data="{ loading: false }" @submit="loading = true">
                        @csrf

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
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus
                                    class="w-full pl-12 pr-4 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                    placeholder="john@example.com">
                            </div>
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
                                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                            </svg>
                                            Send Reset Link
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
                                            Sending...
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
