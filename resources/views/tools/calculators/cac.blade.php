<div x-data="{
    spend: 5000,
    customers: 50,
    cac: 0,
    calculate() {
        if (this.customers > 0) {
            this.cac = (this.spend / this.customers).toFixed(2);
        } else {
            this.cac = 0;
        }
    }
}" x-init="calculate()" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Inputs -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Marketing Spend ($)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400">$</span>
                    <input type="number" x-model="spend" @input="calculate()"
                        class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all font-mono text-slate-700"
                        placeholder="5000">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">New Customers Acquired</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400">#</span>
                    <input type="number" x-model="customers" @input="calculate()"
                        class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all font-mono text-slate-700"
                        placeholder="50">
                </div>
            </div>
        </div>

        <!-- Result -->
        <div
            class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col justify-center items-center text-center">
            <div class="text-sm text-slate-500 font-medium mb-1">Your CAC is</div>
            <div class="text-5xl font-bold text-slate-900 mb-2">
                $<span x-text="cac"></span>
            </div>
            <div class="text-xs text-slate-400">per new paying customer</div>

            <!-- Dynamic Feedback -->
            <div class="mt-6 px-4 py-2 rounded-lg text-sm font-bold"
                :class="{
                    'bg-emerald-100 text-emerald-700': cac < 100,
                    'bg-amber-100 text-amber-700': cac >= 100 && cac < 300,
                    'bg-red-100 text-red-700': cac >= 300
                }">
                <span x-show="cac < 100">Healthy CAC</span>
                <span x-show="cac >= 100 && cac < 300">Moderate CAC</span>
                <span x-show="cac >= 300">High CAC</span>
            </div>
        </div>
    </div>

    <!-- Formula Explanation -->
    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="text-sm text-blue-800">
            <span class="font-bold">Formula:</span> CAC = Total Sales & Marketing Expenses / Number of New Customers
            Acquired
        </div>
    </div>
</div>
