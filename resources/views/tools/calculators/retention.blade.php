<div x-data="{
    startCustomers: 1000,
    endCustomers: 950,
    newCustomers: 100,
    retentionRate: 0,

    calculate() {
        if (this.startCustomers > 0) {
            const retained = this.endCustomers - this.newCustomers;
            this.retentionRate = ((retained / this.startCustomers) * 100).toFixed(1);
        } else {
            this.retentionRate = 0;
        }
    },

    getHealth() {
        if (this.retentionRate >= 90) return { label: 'Excellent', color: 'emerald', icon: '🏆' };
        if (this.retentionRate >= 80) return { label: 'Good', color: 'blue', icon: '✓' };
        if (this.retentionRate >= 70) return { label: 'Average', color: 'amber', icon: '⚠' };
        return { label: 'Needs Work', color: 'red', icon: '!' };
    },

    loadExample() {
        this.startCustomers = 1000;
        this.endCustomers = 950;
        this.newCustomers = 100;
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`Retention Rate: ${this.retentionRate}%\nRetained: ${this.endCustomers - this.newCustomers} of ${this.startCustomers} customers`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Customers at Start of Period
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="Total customers at the beginning">ⓘ</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">#</span>
                    <input type="number" x-model="startCustomers" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 font-mono text-slate-900"
                        placeholder="1000" min="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Customers at End of Period
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="Total customers at the end">ⓘ</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">#</span>
                    <input type="number" x-model="endCustomers" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 font-mono text-slate-900"
                        placeholder="950" min="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    New Customers Acquired
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="New customers gained during period">ⓘ</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">#</span>
                    <input type="number" x-model="newCustomers" @input="calculate()"
                        class="w-full pl-10 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 font-mono text-slate-900"
                        placeholder="100" min="0">
                </div>
            </div>

            <!-- Visual Breakdown -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Started with</span>
                    <span class="font-bold text-slate-900" x-text="startCustomers + ' customers'"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-emerald-600">+ New acquired</span>
                    <span class="font-bold text-emerald-600" x-text="'+' + newCustomers"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-red-600">− Churned</span>
                    <span class="font-bold text-red-600"
                        x-text="'-' + Math.max(0, (parseInt(startCustomers) + parseInt(newCustomers)) - parseInt(endCustomers))"></span>
                </div>
                <div class="flex justify-between text-sm pt-2 border-t border-slate-200">
                    <span class="text-slate-700 font-medium">Ended with</span>
                    <span class="font-bold text-slate-900" x-text="endCustomers + ' customers'"></span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Main Result -->
            <div
                class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl p-8 text-white text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div class="relative">
                    <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Retention Rate</div>
                    <div class="text-6xl font-bold mb-2" x-text="retentionRate + '%'"></div>
                    <div class="opacity-70">of customers retained</div>
                </div>
            </div>

            <!-- Health Status -->
            <div class="rounded-xl p-5 border-2 transition-all"
                :class="{
                    'bg-emerald-50 border-emerald-200': retentionRate >= 90,
                    'bg-blue-50 border-blue-200': retentionRate >= 80 && retentionRate < 90,
                    'bg-amber-50 border-amber-200': retentionRate >= 70 && retentionRate < 80,
                    'bg-red-50 border-red-200': retentionRate < 70
                }">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl"
                        :class="{
                            'bg-emerald-100': retentionRate >= 90,
                            'bg-blue-100': retentionRate >= 80 && retentionRate < 90,
                            'bg-amber-100': retentionRate >= 70 && retentionRate < 80,
                            'bg-red-100': retentionRate < 70
                        }"
                        x-text="getHealth().icon">
                    </div>
                    <div>
                        <div class="font-bold text-lg"
                            :class="{
                                'text-emerald-800': retentionRate >= 90,
                                'text-blue-800': retentionRate >= 80 && retentionRate < 90,
                                'text-amber-800': retentionRate >= 70 && retentionRate < 80,
                                'text-red-800': retentionRate < 70
                            }"
                            x-text="getHealth().label"></div>
                        <div class="text-sm"
                            :class="{
                                'text-emerald-600': retentionRate >= 90,
                                'text-blue-600': retentionRate >= 80 && retentionRate < 90,
                                'text-amber-600': retentionRate >= 70 && retentionRate < 80,
                                'text-red-600': retentionRate < 70
                            }"
                            x-text="retentionRate >= 90 ? 'World-class retention!' : (retentionRate >= 80 ? 'Above average for most industries' : (retentionRate >= 70 ? 'Room for improvement' : 'Focus on reducing churn'))">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Industry Benchmarks -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-900 mb-4">Industry Benchmarks (Monthly)</h4>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600">SaaS B2B</span>
                            <span class="font-mono text-slate-900">95-97%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full">
                            <div class="h-full bg-emerald-400 rounded-full" style="width: 96%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600">SaaS B2C</span>
                            <span class="font-mono text-slate-900">90-95%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full">
                            <div class="h-full bg-blue-400 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600">E-commerce</span>
                            <span class="font-mono text-slate-900">20-40%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full">
                            <div class="h-full bg-amber-400 rounded-full" style="width: 30%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-cyan-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-cyan-800">
                    <strong>Formula:</strong> Retention = ((End Customers − New Customers) / Start Customers) × 100
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-cyan-600 rounded-lg hover:bg-cyan-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
