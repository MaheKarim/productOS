<div x-data="{
    churnType: 'customer',
    startCustomers: 1000,
    lostCustomers: 50,
    startMrr: 50000,
    lostMrr: 2500,
    customerChurn: 0,
    revenueChurn: 0,
    annualChurn: 0,

    calculate() {
        if (this.churnType === 'customer' && this.startCustomers > 0) {
            this.customerChurn = ((this.lostCustomers / this.startCustomers) * 100).toFixed(2);
            this.annualChurn = (100 - Math.pow(1 - this.customerChurn / 100, 12) * 100).toFixed(1);
        }
        if (this.churnType === 'revenue' && this.startMrr > 0) {
            this.revenueChurn = ((this.lostMrr / this.startMrr) * 100).toFixed(2);
            this.annualChurn = (100 - Math.pow(1 - this.revenueChurn / 100, 12) * 100).toFixed(1);
        }
    },

    getCurrentChurn() {
        return this.churnType === 'customer' ? this.customerChurn : this.revenueChurn;
    },

    getHealth() {
        const churn = parseFloat(this.getCurrentChurn());
        if (churn <= 2) return { label: 'Excellent', color: 'emerald' };
        if (churn <= 5) return { label: 'Good', color: 'blue' };
        if (churn <= 10) return { label: 'Average', color: 'amber' };
        return { label: 'High', color: 'red' };
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0 }).format(value);
    },

    loadExample() {
        this.startCustomers = 1000;
        this.lostCustomers = 50;
        this.startMrr = 50000;
        this.lostMrr = 2500;
        this.calculate();
    },

    copyResults() {
        const churn = this.churnType === 'customer' ? this.customerChurn : this.revenueChurn;
        navigator.clipboard.writeText(`${this.churnType === 'customer' ? 'Customer' : 'Revenue'} Churn Rate: ${churn}%\nAnnual Churn: ${this.annualChurn}%`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="flex flex-wrap gap-3">
        <button @click="churnType = 'customer'; calculate()"
            class="px-5 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
            :class="churnType === 'customer' ? 'bg-red-600 text-white shadow-lg' :
                'bg-slate-100 text-slate-600 hover:bg-slate-200'">
            Customer Churn
        </button>
        <button @click="churnType = 'revenue'; calculate()"
            class="px-5 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
            :class="churnType === 'revenue' ? 'bg-red-600 text-white shadow-lg' :
                'bg-slate-100 text-slate-600 hover:bg-slate-200'">
            Revenue Churn
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-5">
            <!-- Customer Churn Inputs -->
            <div x-show="churnType === 'customer'" x-transition class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Total Customers at Start</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">#</span>
                        <input type="number" x-model="startCustomers" @input="calculate()"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 font-mono"
                            placeholder="1000" min="1">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Customers Lost (Churned)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">#</span>
                        <input type="number" x-model="lostCustomers" @input="calculate()"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 font-mono"
                            placeholder="50" min="0">
                    </div>
                </div>
            </div>

            <!-- Revenue Churn Inputs -->
            <div x-show="churnType === 'revenue'" x-transition class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Starting MRR</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                        <input type="number" x-model="startMrr" @input="calculate()"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 font-mono"
                            placeholder="50000" min="1">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Lost MRR (from churned customers)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                        <input type="number" x-model="lostMrr" @input="calculate()"
                            class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 font-mono"
                            placeholder="2500" min="0">
                    </div>
                </div>
            </div>

            <!-- Churn Impact Visual -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-4">Churn Impact Over Time</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-600">Monthly Churn</span>
                        <span class="font-bold text-red-600 font-mono" x-text="getCurrentChurn() + '%'"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-600">Quarterly Churn</span>
                        <span class="font-bold text-slate-900 font-mono"
                            x-text="(100 - Math.pow(1 - getCurrentChurn()/100, 3) * 100).toFixed(1) + '%'"></span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                        <span class="text-sm text-slate-600 font-medium">Annual Churn</span>
                        <span class="font-bold text-slate-900 font-mono text-lg" x-text="annualChurn + '%'"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Main Result -->
            <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80"
                    x-text="churnType === 'customer' ? 'Customer Churn Rate' : 'Revenue Churn Rate'"></div>
                <div class="text-6xl font-bold mb-2" x-text="getCurrentChurn() + '%'"></div>
                <div class="opacity-70">per month</div>
            </div>

            <!-- Health Status -->
            <div class="rounded-xl p-5 border-2"
                :class="{
                    'bg-emerald-50 border-emerald-200': getHealth().color === 'emerald',
                    'bg-blue-50 border-blue-200': getHealth().color === 'blue',
                    'bg-amber-50 border-amber-200': getHealth().color === 'amber',
                    'bg-red-50 border-red-200': getHealth().color === 'red'
                }">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-lg"
                            :class="{
                                'text-emerald-800': getHealth().color === 'emerald',
                                'text-blue-800': getHealth().color === 'blue',
                                'text-amber-800': getHealth().color === 'amber',
                                'text-red-800': getHealth().color === 'red'
                            }"
                            x-text="getHealth().label + ' Churn'"></div>
                        <div class="text-sm mt-1"
                            :class="{
                                'text-emerald-600': getHealth().color === 'emerald',
                                'text-blue-600': getHealth().color === 'blue',
                                'text-amber-600': getHealth().color === 'amber',
                                'text-red-600': getHealth().color === 'red'
                            }"
                            x-text="getCurrentChurn() <= 2 ? 'Best-in-class retention' : (getCurrentChurn() <= 5 ? 'Industry standard for SaaS' : (getCurrentChurn() <= 10 ? 'Room for improvement' : 'Urgent: Fix retention issues'))">
                        </div>
                    </div>
                    <div class="text-3xl"
                        x-text="getCurrentChurn() <= 2 ? '✓' : (getCurrentChurn() <= 5 ? '○' : (getCurrentChurn() <= 10 ? '⚠' : '!'))">
                    </div>
                </div>
            </div>

            <!-- Customer Lifetime -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-slate-500">Implied Customer Lifespan</div>
                        <div class="text-2xl font-bold text-slate-900"
                            x-text="getCurrentChurn() > 0 ? Math.round(1 / (getCurrentChurn() / 100)) + ' months' : '∞'">
                        </div>
                    </div>
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-red-50 rounded-xl p-4 border border-red-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-red-800">
                    <strong>Formula:</strong> Churn Rate = (Lost Customers or MRR / Starting Total) × 100
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
