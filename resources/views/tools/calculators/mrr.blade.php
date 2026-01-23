<div x-data="{
    // Basic MRR
    customers: 150,
    arpu: 49,

    // MRR Components
    showAdvanced: false,
    newMrr: 2450,
    expansionMrr: 980,
    churnMrr: 490,
    contractionMrr: 245,

    // Results
    basicMrr: 0,
    netNewMrr: 0,
    growthRate: 0,

    calculate() {
        // Basic MRR
        this.basicMrr = this.customers * this.arpu;

        // Net New MRR (with components)
        this.netNewMrr = this.newMrr + this.expansionMrr - this.churnMrr - this.contractionMrr;

        // Growth Rate
        if (this.basicMrr > 0) {
            this.growthRate = ((this.netNewMrr / this.basicMrr) * 100).toFixed(1);
        }
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);
    },

    loadExample() {
        this.customers = 150;
        this.arpu = 49;
        this.newMrr = 2450;
        this.expansionMrr = 980;
        this.churnMrr = 490;
        this.contractionMrr = 245;
        this.calculate();
    },

    copyResults() {
        const text = `MRR Calculator Results\n` +
            `Basic MRR: ${this.formatCurrency(this.basicMrr)}\n` +
            `Net New MRR: ${this.formatCurrency(this.netNewMrr)}\n` +
            `Growth Rate: ${this.growthRate}%`;
        navigator.clipboard.writeText(text);
        alert('Results copied to clipboard!');
    },

    reset() {
        this.customers = 0;
        this.arpu = 0;
        this.newMrr = 0;
        this.expansionMrr = 0;
        this.churnMrr = 0;
        this.contractionMrr = 0;
        this.calculate();
    }
}" x-init="calculate()" class="space-y-8">

    <!-- Basic MRR Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Inputs -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                Basic MRR Calculation
            </h3>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Number of Active Customers
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="Total paying customers this month">ⓘ</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">#</span>
                    <input type="number" x-model="customers" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono text-slate-900 font-medium"
                        placeholder="150" min="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Average Revenue Per User (ARPU)
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="Average monthly subscription value per customer">ⓘ</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">$</span>
                    <input type="number" x-model="arpu" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono text-slate-900 font-medium"
                        placeholder="49" min="0" step="0.01">
                </div>
            </div>
        </div>

        <!-- Basic Result -->
        <div
            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-100 flex flex-col justify-center items-center text-center">
            <div class="text-sm text-blue-600 font-bold uppercase tracking-wider mb-2">Monthly Recurring Revenue</div>
            <div class="text-5xl font-bold text-slate-900 mb-3" x-text="formatCurrency(basicMrr)"></div>
            <div class="text-sm text-slate-500">per month</div>

            <!-- Health Indicator -->
            <div class="mt-6 px-4 py-2 rounded-full text-sm font-bold inline-flex items-center gap-2"
                :class="{
                    'bg-emerald-100 text-emerald-700': basicMrr >= 10000,
                    'bg-amber-100 text-amber-700': basicMrr >= 1000 && basicMrr < 10000,
                    'bg-slate-100 text-slate-600': basicMrr < 1000
                }">
                <span x-show="basicMrr >= 10000">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </span>
                <span
                    x-text="basicMrr >= 10000 ? 'Strong Revenue' : (basicMrr >= 1000 ? 'Growing' : 'Early Stage')"></span>
            </div>
        </div>
    </div>

    <!-- Advanced MRR Components Toggle -->
    <div class="border-t border-slate-200 pt-6">
        <button @click="showAdvanced = !showAdvanced"
            class="flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors cursor-pointer">
            <svg class="w-5 h-5 transition-transform" :class="showAdvanced && 'rotate-180'" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
            <span x-text="showAdvanced ? 'Hide MRR Components' : 'Show MRR Components (Advanced)'"></span>
        </button>
    </div>

    <!-- Advanced MRR Components -->
    <div x-show="showAdvanced" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-6">

        <h3 class="text-lg font-bold text-slate-800">MRR Movement Components</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- New MRR -->
            <div class="bg-white rounded-xl p-4 border border-slate-200">
                <label class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-2">
                    + New MRR
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                    <input type="number" x-model="newMrr" @input="calculate()"
                        class="w-full pl-8 pr-3 py-2.5 rounded-lg border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 font-mono text-sm"
                        placeholder="0" min="0">
                </div>
                <p class="text-xs text-slate-400 mt-2">From new customers</p>
            </div>

            <!-- Expansion MRR -->
            <div class="bg-white rounded-xl p-4 border border-slate-200">
                <label class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">
                    + Expansion MRR
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                    <input type="number" x-model="expansionMrr" @input="calculate()"
                        class="w-full pl-8 pr-3 py-2.5 rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 font-mono text-sm"
                        placeholder="0" min="0">
                </div>
                <p class="text-xs text-slate-400 mt-2">Upgrades & add-ons</p>
            </div>

            <!-- Churn MRR -->
            <div class="bg-white rounded-xl p-4 border border-slate-200">
                <label class="block text-xs font-bold text-red-600 uppercase tracking-wider mb-2">
                    − Churn MRR
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                    <input type="number" x-model="churnMrr" @input="calculate()"
                        class="w-full pl-8 pr-3 py-2.5 rounded-lg border border-slate-200 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 font-mono text-sm"
                        placeholder="0" min="0">
                </div>
                <p class="text-xs text-slate-400 mt-2">Lost customers</p>
            </div>

            <!-- Contraction MRR -->
            <div class="bg-white rounded-xl p-4 border border-slate-200">
                <label class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-2">
                    − Contraction MRR
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                    <input type="number" x-model="contractionMrr" @input="calculate()"
                        class="w-full pl-8 pr-3 py-2.5 rounded-lg border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 font-mono text-sm"
                        placeholder="0" min="0">
                </div>
                <p class="text-xs text-slate-400 mt-2">Downgrades</p>
            </div>
        </div>

        <!-- Net New MRR Result -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="text-sm text-slate-500 font-medium">Net New MRR</div>
                <div class="text-3xl font-bold" :class="netNewMrr >= 0 ? 'text-emerald-600' : 'text-red-600'"
                    x-text="(netNewMrr >= 0 ? '+' : '') + formatCurrency(netNewMrr)"></div>
            </div>
            <div class="text-right">
                <div class="text-sm text-slate-500 font-medium">MRR Growth Rate</div>
                <div class="text-2xl font-bold" :class="growthRate >= 0 ? 'text-emerald-600' : 'text-red-600'"
                    x-text="(growthRate >= 0 ? '+' : '') + growthRate + '%'"></div>
            </div>
        </div>
    </div>

    <!-- Formula & Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <!-- Formula -->
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <span class="font-bold">Formula:</span> MRR = Customers × ARPU<br>
                    <span class="text-blue-600">Net New MRR = New + Expansion − Churn − Contraction</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer">
                Load Example
            </button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors cursor-pointer flex items-center gap-2">
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
