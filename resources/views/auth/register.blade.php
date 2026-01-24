<x-layout.app>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20 pb-20">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-[100px]"></div>

        <div class="w-full max-w-md relative z-10 px-4">
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8 shadow-2xl">
                <div class="text-center mb-8">
                    <h2
                        class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">
                        Join the Future
                    </h2>
                    <p class="text-slate-400 mt-2">Create your account to access the dashboard</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            autofocus
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none text-white placeholder-slate-500 transition-all"
                            placeholder="John Doe">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email
                            Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none text-white placeholder-slate-500 transition-all"
                            placeholder="john@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none text-white placeholder-slate-500 transition-all"
                            placeholder="********">
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Confirm
                            Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none text-white placeholder-slate-500 transition-all"
                            placeholder="********">
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/20 transform transition-all hover:scale-[1.02] focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-[#0B1120]">
                            Create Account
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-slate-400 text-sm">
                            Already have an account?
                            <a href="{{ route('login') }}"
                                class="text-blue-400 hover:text-blue-300 transition-colors">Sign in</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
