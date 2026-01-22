<x-layout.app>
    <x-slot:title>Contact - ProductOS</x-slot:title>

    <div class="py-24 bg-zinc-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-center text-primary mb-16">Let's Talk</h1>
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-zinc-200">
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-2">Name</label>
                        <input type="text"
                            class="w-full rounded-xl border-zinc-300 focus:border-accent focus:ring-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-2">Email</label>
                        <input type="email"
                            class="w-full rounded-xl border-zinc-300 focus:border-accent focus:ring-accent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-2">Message</label>
                        <textarea rows="4" class="w-full rounded-xl border-zinc-300 focus:border-accent focus:ring-accent"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-zinc-800 transition-all">Send
                        Message</button>
                </form>
            </div>
        </div>
    </div>
</x-layout.app>
