<div x-data="{
    calculationMethod: 'simple',
    arpu: 49,
    customerLifespan: 24,
    avgRevenue: 49,
    grossMargin: 70,
    churnRate: 5,
    cac: 150,
    ltv: 0,
    ltvCacRatio: 0,
    paybackMonths: 0,

    calculate() {
        if (this.calculationMethod === 'simple') {
            this.ltv = this.arpu * this.customerLifespan;
        } else {
            if (this.churnRate > 0) {
                const monthlyChurn = this.churnRate / 100;
                this.ltv = this.avgRevenue * (this.grossMargin / 100) * (1 / monthlyChurn);
            } else {
                this.ltv = 0;
            }
        }
        if (this.cac > 0) {
            this.ltvCacRatio = (this.ltv / this.cac).toFixed(1);
            this.paybackMonths = Math.ceil(this.cac / (this.arpu || this.avgRevenue));
        }
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0 }).format(value);
    },

    loadExample() {
        this.arpu = 49;
        this.customerLifespan = 24;
        this.avgRevenue = 49;
        this.grossMargin = 70;
        this.churnRate = 5;
        this.cac = 150;
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`LTV: ${this.formatCurrency(this.ltv)}\nLTV:CAC: ${this.ltvCacRatio}x\nPayback: ${this.paybackMonths} months`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="flex flex-wrap gap-3">
        <button @click="calculationMethod = 'simple'; calculate()"
            class="px-5 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
            :class="calculationMethod === 'simple' ? 'bg-emerald-600 text-white shadow-lg' :
                'bg-slate-100 text-slate-600 hover:bg-slate-200'">
            Simple (ARPU × Lifespan)
        </button>
        <button @click="calculationMethod = 'advanced'; calculate()"
            class="px-5 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
            :class="calculationMethod === 'advanced' ? 'bg-emerald-600 text-white shadow-lg' :
                'bg-slate-100 text-slate-600 hover:bg-slate-200'">
            Advanced (with Margin & Churn)
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-5">
            <div x-show="calculationMethod === 'simple'" x-transition class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">ARPU ($/month)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                        <input type="number" x-model="arpu" @input="calculate()"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 font-mono"
                            placeholder="49" min="0">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Customer Lifespan (months)</label>
                    <input type="number" x-model="customerLifespan" @input="calculate()"
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 font-mono"
                        placeholder="24" min="1">
                </div>
            </div>

            <div x-show="calculationMethod === 'advanced'" x-transition class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Monthly Revenue ($)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                        <input type="number" x-model="avgRevenue" @input="calculate()"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 font-mono"
                            placeholder="49" min="0">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Gross Margin (%)</label>
                    <input type="number" x-model="grossMargin" @input="calculate()"
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 font-mono"
                        placeholder="70" min="0" max="100">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Monthly Churn Rate (%)</label>
                    <input type="number" x-model="churnRate" @input="calculate()"
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 font-mono"
                        placeholder="5" min="0.1" step="0.1">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">CAC ($) <span
                        class="text-slate-400 font-normal">For ratio</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                    <input type="number" x-model="cac" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 font-mono"
                        placeholder="150" min="0">
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Customer Lifetime Value</div>
                <div class="text-5xl font-bold mb-2" x-text="formatCurrency(ltv)"></div>
                <div class="opacity-70">per customer</div>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-900">LTV:CAC Ratio</h4>
                    <span class="px-3 py-1 rounded-full text-sm font-bold"
                        :class="{ 'bg-emerald-100 text-emerald-700': ltvCacRatio >=
                            3, 'bg-amber-100 text-amber-700': ltvCacRatio >= 1 && ltvCacRatio <
                                3, 'bg-red-100 text-red-700': ltvCacRatio < 1 }"
                        x-text="ltvCacRatio >= 3 ? 'Healthy' : (ltvCacRatio >= 1 ? 'Borderline' : 'Unhealthy')"></span>
                </div>
                <div class="text-4xl font-bold text-slate-900 mb-3" x-text="ltvCacRatio + 'x'"></div>
                <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all"
                        :class="{ 'bg-emerald-500': ltvCacRatio >= 3, 'bg-amber-500': ltvCacRatio >= 1 && ltvCacRatio <
                            3, 'bg-red-500': ltvCacRatio < 1 }"
                        :style="'width: ' + Math.min(ltvCacRatio / 5 * 100, 100) + '%'"></div>
                </div>
                <div class="flex justify-between text-xs text-slate-400 mt-2"><span>0x</span><span>3x
                        ideal</span><span>5x+</span></div>
            </div>

            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500">Payback Period</div>
                    <div class="text-2xl font-bold text-slate-900" x-text="paybackMonths + ' months'"></div>
                </div>
                <div class="p-3 rounded-xl" :class="paybackMonths <= 12 ? 'bg-emerald-100' : 'bg-amber-100'">
                    <svg class="w-6 h-6" :class="paybackMonths <= 12 ? 'text-emerald-600' : 'text-amber-600'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-emerald-800">
                    <strong>Formula:</strong> LTV = ARPU × Lifespan (simple) or ARPU × Margin × (1/Churn) (advanced)
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
