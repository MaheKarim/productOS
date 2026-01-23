<div x-data="{
    calculationMethod: 'mrr',

    // MRR-based
    mrr: 7350,

    // Contract-based
    contracts: [
        { name: 'Enterprise A', value: 24000 },
        { name: 'Enterprise B', value: 18000 },
        { name: 'Pro Plan Users', value: 36000 }
    ],

    // Growth tracking
    lastYearArr: 65000,

    // Results
    arr: 0,
    growthRate: 0,

    calculate() {
        if (this.calculationMethod === 'mrr') {
            this.arr = this.mrr * 12;
        } else {
            this.arr = this.contracts.reduce((sum, c) => sum + Number(c.value), 0);
        }

        if (this.lastYearArr > 0) {
            this.growthRate = (((this.arr - this.lastYearArr) / this.lastYearArr) * 100).toFixed(1);
        }
    },

    addContract() {
        this.contracts.push({ name: 'New Contract', value: 0 });
        this.calculate();
    },

    removeContract(index) {
        this.contracts.splice(index, 1);
        this.calculate();
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);
    },

    formatCompact(value) {
        if (value >= 1000000) return '$' + (value / 1000000).toFixed(1) + 'M';
        if (value >= 1000) return '$' + (value / 1000).toFixed(1) + 'K';
        return this.formatCurrency(value);
    },

    loadExample() {
        this.mrr = 7350;
        this.contracts = [
            { name: 'Enterprise A', value: 24000 },
            { name: 'Enterprise B', value: 18000 },
            { name: 'Pro Plan Users', value: 36000 }
        ];
        this.lastYearArr = 65000;
        this.calculate();
    },

    copyResults() {
        const text = `ARR Calculator Results\n` +
            `Annual Recurring Revenue: ${this.formatCurrency(this.arr)}\n` +
            `YoY Growth: ${this.growthRate}%`;
        navigator.clipboard.writeText(text);
        alert('Results copied to clipboard!');
    },

    reset() {
        this.mrr = 0;
        this.contracts = [{ name: '', value: 0 }];
        this.lastYearArr = 0;
        this.calculate();
    }
}" x-init="calculate()" class="space-y-8">

    <!-- Method Toggle -->
    <div class="flex flex-wrap gap-3">
        <button @click="calculationMethod = 'mrr'; calculate()"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all cursor-pointer"
            :class="calculationMethod === 'mrr'
                ?
                'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' :
                'bg-slate-100 text-slate-600 hover:bg-slate-200'">
            From MRR
        </button>
        <button @click="calculationMethod = 'contracts'; calculate()"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all cursor-pointer"
            :class="calculationMethod === 'contracts'
                ?
                'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' :
                'bg-slate-100 text-slate-600 hover:bg-slate-200'">
            From Contracts
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Inputs -->
        <div class="space-y-6">
            <!-- MRR-based Input -->
            <div x-show="calculationMethod === 'mrr'" x-transition>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Current Monthly Recurring Revenue
                    <span class="ml-1 text-slate-400 font-normal cursor-help" title="Your current MRR">ⓘ</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">$</span>
                    <input type="number" x-model="mrr" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono text-slate-900 font-medium text-lg"
                        placeholder="7350" min="0">
                </div>
                <p class="text-sm text-slate-500 mt-2">ARR = MRR × 12</p>
            </div>

            <!-- Contract-based Input -->
            <div x-show="calculationMethod === 'contracts'" x-transition class="space-y-4">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-bold text-slate-700">Annual Contracts</label>
                    <button @click="addContract()"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700 cursor-pointer flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add Contract
                    </button>
                </div>

                <div class="space-y-3 max-h-64 overflow-y-auto">
                    <template x-for="(contract, index) in contracts" :key="index">
                        <div class="flex gap-3 items-center bg-slate-50 p-3 rounded-xl">
                            <input type="text" x-model="contract.name"
                                class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
                                placeholder="Contract name">
                            <div class="relative w-32">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">$</span>
                                <input type="number" x-model="contract.value" @input="calculate()"
                                    class="w-full pl-7 pr-3 py-2 rounded-lg border border-slate-200 text-sm font-mono focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
                                    placeholder="0" min="0">
                            </div>
                            <button @click="removeContract(index)" x-show="contracts.length > 1"
                                class="p-2 text-slate-400 hover:text-red-500 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Last Year ARR for Growth -->
            <div class="pt-4 border-t border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Last Year's ARR (for growth calculation)
                    <span class="ml-1 text-slate-400 font-normal">Optional</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">$</span>
                    <input type="number" x-model="lastYearArr" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono text-slate-900"
                        placeholder="65000" min="0">
                </div>
            </div>
        </div>

        <!-- Result -->
        <div class="space-y-4">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 text-indigo-100">Annual Recurring Revenue
                </div>
                <div class="text-5xl font-bold mb-2" x-text="formatCompact(arr)"></div>
                <div class="text-indigo-200">per year</div>

                <!-- Growth Badge -->
                <div x-show="lastYearArr > 0"
                    class="mt-6 inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold"
                    :class="growthRate >= 0 ? 'bg-white/20 text-white' : 'bg-red-500/30 text-red-100'">
                    <svg x-show="growthRate >= 0" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <svg x-show="growthRate < 0" class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                    <span x-text="(growthRate >= 0 ? '+' : '') + growthRate + '% YoY Growth'"></span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-200">
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Monthly</div>
                    <div class="text-xl font-bold text-slate-900" x-text="formatCurrency(arr / 12)"></div>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-200">
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Quarterly</div>
                    <div class="text-xl font-bold text-slate-900" x-text="formatCurrency(arr / 4)"></div>
                </div>
            </div>

            <!-- Growth Status -->
            <div class="p-4 rounded-xl border" x-show="lastYearArr > 0"
                :class="{
                    'bg-emerald-50 border-emerald-200': growthRate >= 20,
                    'bg-blue-50 border-blue-200': growthRate >= 0 && growthRate < 20,
                    'bg-red-50 border-red-200': growthRate < 0
                }">
                <div class="flex items-start gap-3">
                    <div class="p-2 rounded-lg"
                        :class="{
                            'bg-emerald-100': growthRate >= 20,
                            'bg-blue-100': growthRate >= 0 && growthRate < 20,
                            'bg-red-100': growthRate < 0
                        }">
                        <svg class="w-5 h-5"
                            :class="{
                                'text-emerald-600': growthRate >= 20,
                                'text-blue-600': growthRate >= 0 && growthRate < 20,
                                'text-red-600': growthRate < 0
                            }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold"
                            :class="{
                                'text-emerald-800': growthRate >= 20,
                                'text-blue-800': growthRate >= 0 && growthRate < 20,
                                'text-red-800': growthRate < 0
                            }"
                            x-text="growthRate >= 20 ? 'Strong Growth!' : (growthRate >= 0 ? 'Positive Growth' : 'Declining Revenue')">
                        </div>
                        <div class="text-sm mt-1"
                            :class="{
                                'text-emerald-600': growthRate >= 20,
                                'text-blue-600': growthRate >= 0 && growthRate < 20,
                                'text-red-600': growthRate < 0
                            }"
                            x-text="growthRate >= 20 ? 'Exceeding typical SaaS benchmarks (15-20% YoY)' : (growthRate >= 0 ? 'Steady growth, aim for 20%+ for Series A readiness' : 'Focus on reducing churn and increasing expansion revenue')">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formula & Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-indigo-800">
                    <span class="font-bold">Formula:</span> ARR = MRR × 12<br>
                    <span class="text-indigo-600">Or sum of all annual contract values</span>
                </div>
            </div>
        </div>

        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer">
                Load Example
            </button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
                Copy Results
            </button>
        </div>
    </div>
</div>
