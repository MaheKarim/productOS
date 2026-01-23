<div x-data="{
    funnelStages: [
        { name: 'Visitors', count: 10000 },
        { name: 'Signups', count: 500 },
        { name: 'Activated', count: 200 },
        { name: 'Paid', count: 50 }
    ],

    calculate() {
        // Recalculate on any change
    },

    getConversionRate(fromIndex, toIndex) {
        if (fromIndex >= this.funnelStages.length || toIndex >= this.funnelStages.length) return 0;
        const from = Number(this.funnelStages[fromIndex].count);
        const to = Number(this.funnelStages[toIndex].count);
        if (from === 0) return 0;
        return ((to / from) * 100).toFixed(2);
    },

    getTotalConversion() {
        if (this.funnelStages.length < 2) return 0;
        const first = Number(this.funnelStages[0].count);
        const last = Number(this.funnelStages[this.funnelStages.length - 1].count);
        if (first === 0) return 0;
        return ((last / first) * 100).toFixed(2);
    },

    getDropoff(index) {
        if (index === 0) return 0;
        const prev = Number(this.funnelStages[index - 1].count);
        const curr = Number(this.funnelStages[index].count);
        return prev - curr;
    },

    getMaxCount() {
        return Math.max(...this.funnelStages.map(s => Number(s.count)), 1);
    },

    addStage() {
        this.funnelStages.push({ name: 'New Stage', count: 0 });
    },

    removeStage(index) {
        if (this.funnelStages.length > 2) {
            this.funnelStages.splice(index, 1);
        }
    },

    loadExample() {
        this.funnelStages = [
            { name: 'Visitors', count: 10000 },
            { name: 'Signups', count: 500 },
            { name: 'Activated', count: 200 },
            { name: 'Paid', count: 50 }
        ];
    },

    copyResults() {
        let text = 'Conversion Funnel Results\n\n';
        this.funnelStages.forEach((stage, i) => {
            text += `${stage.name}: ${stage.count}`;
            if (i > 0) text += ` (${this.getConversionRate(i-1, i)}% from prev)`;
            text += '\n';
        });
        text += `\nTotal Conversion: ${this.getTotalConversion()}%`;
        navigator.clipboard.writeText(text);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Funnel Stages Input -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <h4 class="font-bold text-slate-800">Funnel Stages</h4>
                <button @click="addStage()"
                    class="text-sm font-medium text-green-600 hover:text-green-700 cursor-pointer flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Stage
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(stage, index) in funnelStages" :key="index">
                    <div class="bg-white rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold"
                                :class="index === 0 ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600'"
                                x-text="index + 1"></span>
                            <input type="text" x-model="stage.name"
                                class="flex-1 px-3 py-2 rounded-lg border border-slate-200 font-medium focus:border-green-500"
                                placeholder="Stage name">
                            <input type="number" x-model="stage.count" @input="calculate()"
                                class="w-28 px-3 py-2 rounded-lg border border-slate-200 font-mono text-right focus:border-green-500"
                                min="0" placeholder="0">
                            <button @click="removeStage(index)" x-show="funnelStages.length > 2"
                                class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Conversion from previous -->
                        <template x-if="index > 0">
                            <div class="mt-3 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                                <span class="text-slate-500">Conversion:</span>
                                <span class="font-bold"
                                    :class="getConversionRate(index - 1, index) >= 10 ? 'text-emerald-600' : 'text-amber-600'"
                                    x-text="getConversionRate(index-1, index) + '%'"></span>
                                <span class="text-slate-400">|</span>
                                <span class="text-red-500">−<span x-text="getDropoff(index).toLocaleString()"></span>
                                    dropped</span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        <!-- Results & Visualization -->
        <div class="space-y-4">
            <!-- Total Conversion -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Total Conversion Rate</div>
                <div class="text-6xl font-bold mb-2" x-text="getTotalConversion() + '%'"></div>
                <div class="opacity-80"
                    x-text="funnelStages[0]?.name + ' → ' + funnelStages[funnelStages.length - 1]?.name"></div>
            </div>

            <!-- Visual Funnel -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-4">Funnel Visualization</h4>
                <div class="space-y-2">
                    <template x-for="(stage, index) in funnelStages" :key="'funnel-' + index">
                        <div class="relative">
                            <div class="h-12 rounded-lg flex items-center justify-between px-4 transition-all"
                                :class="index === 0 ? 'bg-green-500 text-white' : (index === funnelStages.length - 1 ?
                                    'bg-emerald-600 text-white' : 'bg-green-100 text-green-800')"
                                :style="'width: ' + (stage.count / getMaxCount() * 100) + '%'">
                                <span class="font-medium truncate" x-text="stage.name"></span>
                                <span class="font-bold font-mono" x-text="Number(stage.count).toLocaleString()"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Stage by Stage Rates -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-3">Stage-by-Stage Conversion</h4>
                <div class="space-y-2">
                    <template x-for="(stage, index) in funnelStages" :key="'rate-' + index">
                        <template x-if="index > 0">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600"
                                    x-text="funnelStages[index-1].name + ' → ' + stage.name"></span>
                                <span class="font-bold font-mono"
                                    :class="getConversionRate(index - 1, index) >= 20 ? 'text-emerald-600' : (getConversionRate(
                                        index - 1, index) >= 5 ? 'text-amber-600' : 'text-red-600')"
                                    x-text="getConversionRate(index-1, index) + '%'"></span>
                            </div>
                        </template>
                    </template>
                </div>
            </div>

            <!-- Benchmarks -->
            <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                <div class="text-sm text-green-800">
                    <strong>Benchmarks:</strong> Visitor→Signup: 2-5% | Signup→Paid: 10-25%
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-green-50 rounded-xl p-4 border border-green-100 flex-1">
            <div class="text-sm text-green-800">
                <strong>Formula:</strong> Conversion Rate = (Conversions / Total Visitors) × 100
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
