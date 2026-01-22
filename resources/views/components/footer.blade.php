<footer class="bg-white border-t border-zinc-200 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">

            <!-- Brand Column -->
            <div class="md:col-span-4">
                <a href="{{ route('home') }}"
                    class="text-2xl font-display font-bold text-primary mb-6 block tracking-tight">ProductOS</a>
                <p class="text-zinc-500 mb-8 max-w-sm leading-relaxed">
                    Engineering growth engines through rigorous data analysis and strategic execution.
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-zinc-400 hover:text-primary transition-colors">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>
                    <a href="#" class="text-zinc-400 hover:text-primary transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Links Column -->
            <div class="md:col-span-2 md:col-start-6">
                <h3 class="font-bold text-lg text-primary mb-6">Explore</h3>
                <ul class="space-y-4 text-sm text-zinc-600">
                    <li><a href="{{ route('home') }}" class="hover:text-accent transition-colors">Home</a></li>
                    <li><a href="{{ route('tools.index') }}" class="hover:text-accent transition-colors">Toolkit</a>
                    </li>
                    <li><a href="{{ route('portfolio.index') }}" class="hover:text-accent transition-colors">Case
                            Studies</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-accent transition-colors">Services</a></li>
                </ul>
            </div>

            <!-- Toolkit Column -->
            <div class="md:col-span-3">
                <h3 class="font-bold text-lg text-primary mb-6">Top Tools</h3>
                <ul class="space-y-4 text-sm text-zinc-600">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <a href="{{ route('tools.index') }}#cac" class="hover:text-accent transition-colors">CAC
                            Calculator</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                        <a href="{{ route('tools.index') }}#ltv" class="hover:text-accent transition-colors">LTV
                            Projection</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                        <a href="{{ route('tools.index') }}#rice" class="hover:text-accent transition-colors">RICE
                            Scoring</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="md:col-span-3">
                <h3 class="font-bold text-lg text-primary mb-6">Let's Build</h3>
                <p class="text-sm text-zinc-500 mb-6">
                    Available for fractional CPO roles and high-impact consulting.
                </p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-zinc-900 text-white font-bold rounded-xl hover:bg-zinc-800 transition-all shadow-lg hover:shadow-xl w-full">
                    Book Advisory
                </a>
            </div>

        </div>

        <div
            class="border-t border-zinc-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-zinc-400">
            <p>&copy; {{ date('Y') }} ProductOS. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-zinc-600">Privacy Policy</a>
                <a href="#" class="hover:text-zinc-600">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
