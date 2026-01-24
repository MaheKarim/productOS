<x-layout.app>
    <div class="min-h-screen relative overflow-hidden pt-32 pb-20 px-4">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-gradient-to-br from-blue-500/20 to-indigo-600/15 rounded-full blur-[120px] animate-pulse">
            </div>
            <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] bg-gradient-to-tl from-violet-500/20 to-purple-600/10 rounded-full blur-[120px] animate-pulse"
                style="animation-delay: 1s;"></div>
            <div
                class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-r from-cyan-400/10 via-blue-500/10 to-violet-500/10 rounded-full blur-[100px]">
            </div>
        </div>

        <!-- Floating Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-[10%] w-2 h-2 bg-blue-500/50 rounded-full animate-bounce"
                style="animation-duration: 2s;"></div>
            <div class="absolute top-40 right-[15%] w-1.5 h-1.5 bg-violet-500/50 rounded-full animate-bounce"
                style="animation-duration: 2.5s;"></div>
            <div class="absolute bottom-32 left-[20%] w-2 h-2 bg-indigo-500/50 rounded-full animate-bounce"
                style="animation-duration: 3s;"></div>
            <div class="absolute bottom-40 right-[25%] w-1.5 h-1.5 bg-purple-500/50 rounded-full animate-bounce"
                style="animation-duration: 1.8s;"></div>
            <div class="absolute top-1/2 left-[5%] w-1 h-1 bg-cyan-500/50 rounded-full animate-bounce"
                style="animation-duration: 2.2s;"></div>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">

                <!-- Left Side: Value Proposition -->
                <div class="order-2 lg:order-1 space-y-8">
                    <!-- Main Heading -->
                    <div class="space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            <span class="text-sm font-medium text-blue-600 font-['Archivo']">Join 500+ Product
                                Managers</span>
                        </div>
                        <h1
                            class="text-4xl md:text-5xl lg:text-6xl font-bold text-zinc-900 leading-tight font-['Space_Grotesk']">
                            Accelerate Your
                            <span
                                class="bg-gradient-to-r from-blue-600 via-violet-600 to-purple-600 bg-clip-text text-transparent">
                                PM Career
                            </span>
                        </h1>
                        <p class="text-lg text-zinc-600 max-w-lg font-['Archivo']">
                            Access powerful tools, templates, and resources designed to help you make data-driven
                            decisions and stand out in your product management journey.
                        </p>
                    </div>

                    <!-- Benefits Cards -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        <!-- Benefit 1 -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-violet-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300">
                            </div>
                            <div
                                class="relative backdrop-blur-xl bg-white/70 border border-white/60 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-zinc-900 mb-1 font-['Space_Grotesk']">Analytics Dashboards
                                </h3>
                                <p class="text-sm text-zinc-600 font-['Archivo']">Track KPIs, CAC, LTV, and more with
                                    interactive calculators.</p>
                            </div>
                        </div>

                        <!-- Benefit 2 -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-violet-500 to-purple-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300">
                            </div>
                            <div
                                class="relative backdrop-blur-xl bg-white/70 border border-white/60 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center mb-4 shadow-lg shadow-violet-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-zinc-900 mb-1 font-['Space_Grotesk']">PM Templates</h3>
                                <p class="text-sm text-zinc-600 font-['Archivo']">PRDs, roadmaps, and frameworks used by
                                    top PMs.</p>
                            </div>
                        </div>

                        <!-- Benefit 3 -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300">
                            </div>
                            <div
                                class="relative backdrop-blur-xl bg-white/70 border border-white/60 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center mb-4 shadow-lg shadow-cyan-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-zinc-900 mb-1 font-['Space_Grotesk']">Case Studies</h3>
                                <p class="text-sm text-zinc-600 font-['Archivo']">Learn from real product decisions and
                                    outcomes.</p>
                            </div>
                        </div>

                        <!-- Benefit 4 -->
                        <div class="group relative">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300">
                            </div>
                            <div
                                class="relative backdrop-blur-xl bg-white/70 border border-white/60 rounded-2xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 shadow-lg shadow-purple-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-zinc-900 mb-1 font-['Space_Grotesk']">AI-Powered Tools</h3>
                                <p class="text-sm text-zinc-600 font-['Archivo']">Smart insights and recommendations for
                                    your products.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Proof -->
                    <div class="backdrop-blur-xl bg-white/50 border border-white/60 rounded-2xl p-6 shadow-lg">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex -space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-sm font-bold ring-2 ring-white">
                                    A</div>
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center text-white text-sm font-bold ring-2 ring-white">
                                    S</div>
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-sm font-bold ring-2 ring-white">
                                    M</div>
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center text-white text-sm font-bold ring-2 ring-white">
                                    R</div>
                                <div
                                    class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center text-white text-xs font-medium ring-2 ring-white">
                                    +50</div>
                            </div>
                            <div>
                                <div class="flex items-center gap-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-sm text-zinc-600 font-['Archivo']">Loved by PMs worldwide</p>
                            </div>
                        </div>
                        <blockquote class="text-zinc-700 italic font-['Archivo']">
                            "ProductOS transformed how I approach product decisions. The CAC calculator alone saved
                            hours of manual work."
                        </blockquote>
                        <p class="text-sm text-zinc-500 mt-2 font-['Archivo']">— Sarah K., Senior PM at TechCorp</p>
                    </div>
                </div>

                <!-- Right Side: Registration Form -->
                <div class="order-1 lg:order-2">
                    <div class="relative group">
                        <!-- Glow Effect -->
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-violet-600 to-purple-600 rounded-3xl blur-lg opacity-30 group-hover:opacity-40 transition-opacity duration-500">
                        </div>

                        <!-- Card Container -->
                        <div
                            class="relative backdrop-blur-xl bg-white/80 border border-white/60 rounded-3xl p-8 md:p-10 shadow-2xl shadow-blue-500/10">

                            <!-- Header -->
                            <div class="text-center mb-8">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-violet-600 shadow-lg shadow-blue-500/30 mb-5">
                                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl md:text-3xl font-bold text-zinc-900 font-['Space_Grotesk']">
                                    Create Your Account
                                </h2>
                                <p class="text-zinc-600 mt-2 font-['Archivo']">Start your journey in under 60 seconds
                                </p>
                            </div>

                            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                                @csrf

                                <!-- Name Input -->
                                <div class="space-y-2">
                                    <label for="name"
                                        class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                        Full Name
                                    </label>
                                    <div class="relative group/input">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-blue-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                        <input id="name" type="text" name="name"
                                            value="{{ old('name') }}" required autofocus
                                            class="w-full pl-12 pr-4 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                            placeholder="John Doe">
                                    </div>
                                    @error('name')
                                        <p class="text-sm text-red-500 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email Input -->
                                <div class="space-y-2">
                                    <label for="email"
                                        class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                        Email Address
                                    </label>
                                    <div class="relative group/input">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-blue-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                            </svg>
                                        </div>
                                        <input id="email" type="email" name="email"
                                            value="{{ old('email') }}" required
                                            class="w-full pl-12 pr-4 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                            placeholder="john@example.com">
                                    </div>
                                    @error('email')
                                        <p class="text-sm text-red-500 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="space-y-2">
                                    <label for="password"
                                        class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                        Password
                                    </label>
                                    <div class="relative group/input">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-blue-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                            </svg>
                                        </div>
                                        <input id="password" type="password" name="password" required
                                            class="w-full pl-12 pr-4 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                            placeholder="••••••••">
                                    </div>
                                    @error('password')
                                        <p class="text-sm text-red-500 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Confirm Password Input -->
                                <div class="space-y-2">
                                    <label for="password_confirmation"
                                        class="block text-sm font-semibold text-zinc-700 font-['Archivo']">
                                        Confirm Password
                                    </label>
                                    <div class="relative group/input">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-zinc-400 group-focus-within/input:text-blue-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                            </svg>
                                        </div>
                                        <input id="password_confirmation" type="password"
                                            name="password_confirmation" required
                                            class="w-full pl-12 pr-4 py-3.5 bg-white/60 border border-zinc-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none text-zinc-900 placeholder-zinc-400 transition-all duration-200 font-['Archivo']"
                                            placeholder="••••••••">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-3">
                                    <button type="submit"
                                        class="relative w-full py-4 bg-gradient-to-r from-blue-600 via-violet-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transform transition-all duration-300 hover:shadow-xl hover:shadow-violet-500/30 hover:scale-[1.02] focus:ring-4 focus:ring-blue-500/30 active:scale-[0.98] cursor-pointer overflow-hidden group/btn">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700">
                                        </div>
                                        <span
                                            class="relative flex items-center justify-center gap-2 font-['Space_Grotesk']">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                            </svg>
                                            Create Free Account
                                        </span>
                                    </button>
                                </div>

                                <!-- Terms -->
                                <p class="text-xs text-center text-zinc-500 font-['Archivo']">
                                    By signing up, you agree to our
                                    <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and
                                    <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                                </p>
                            </form>

                            <!-- Divider -->
                            <div class="relative my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-zinc-200/80"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white/80 text-zinc-500 font-['Archivo']">or continue
                                        with</span>
                                </div>
                            </div>

                            <!-- Social Login -->
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-white/60 border border-zinc-200 rounded-xl hover:bg-zinc-50 hover:border-zinc-300 transition-all duration-200 cursor-pointer group">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="#4285F4"
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                        <path fill="#34A853"
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                        <path fill="#FBBC05"
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                        <path fill="#EA4335"
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-zinc-700 group-hover:text-zinc-900 font-['Archivo']">Google</span>
                                </button>
                                <button type="button"
                                    class="flex items-center justify-center gap-2 px-4 py-3 bg-white/60 border border-zinc-200 rounded-xl hover:bg-zinc-50 hover:border-zinc-300 transition-all duration-200 cursor-pointer group">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-zinc-700 group-hover:text-zinc-900 font-['Archivo']">GitHub</span>
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-6">
                                <p class="text-zinc-600 text-sm font-['Archivo']">
                                    Already have an account?
                                    <a href="{{ route('login') }}"
                                        class="font-semibold text-blue-600 hover:text-violet-600 transition-colors duration-200 ml-1">
                                        Sign in
                                        <svg class="inline-block w-4 h-4 ml-0.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </p>
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
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Free Forever</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
