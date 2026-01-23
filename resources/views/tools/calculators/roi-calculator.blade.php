<div x-data="{
    cost: 1000,
    revenue: 5000,
    roi: 0,
    calculate() {
        if (this.cost > 0) {
            this.roi = ((this.revenue - this.cost) / this.cost) * 100;
            this.roi = this.roi.toFixed(2);
        } else {
            this.roi = 0;
        }
    }
}" x-init="calculate()" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Inputs -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Investment ($)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400">$</span>
                    <input type="number" x-model="cost" @input="calculate()"
                        class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all font-mono text-slate-700"
                        placeholder="1000">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Total Revenue ($)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-slate-400">$</span>
                    <input type="number" x-model="revenue" @input="calculate()"
                        class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all font-mono text-slate-700"
                        placeholder="5000">
                </div>
            </div>
        </div>

        <!-- Result -->
        <div
            class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col justify-center items-center text-center">
            <div class="text-sm text-slate-500 font-medium mb-1">Your ROI is</div>
            <div class="text-5xl font-bold text-slate-900 mb-2">
                <span x-text="roi"></span>%
            </div>
            <div class="text-xs text-slate-400">return on investment</div>

            <div class="mt-6 px-4 py-2 rounded-lg text-sm font-bold"
                :class="{
                    'bg-red-100 text-red-700': roi < 0,
                    'bg-amber-100 text-amber-700': roi >= 0 && roi < 100,
                    'bg-emerald-100 text-emerald-700': roi >= 100
                }">
                <span x-show="roi < 0">Negative Return</span>
                <span x-show="roi >= 0 && roi < 100">Positive Return</span>
                <span x-show="roi >= 100">High Return</span>
            </div>
        </div>
    </div>
</div>
