<div x-data="{
    scores: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    totalResponses: 0,
    promoters: 0,
    passives: 0,
    detractors: 0,
    nps: 0,

    calculate() {
        this.totalResponses = this.scores.reduce((sum, count) => sum + Number(count), 0);

        this.detractors = this.scores.slice(0, 7).reduce((sum, count) => sum + Number(count), 0);
        this.passives = this.scores.slice(7, 9).reduce((sum, count) => sum + Number(count), 0);
        this.promoters = this.scores.slice(9, 11).reduce((sum, count) => sum + Number(count), 0);

        if (this.totalResponses > 0) {
            const promoterPct = (this.promoters / this.totalResponses) * 100;
            const detractorPct = (this.detractors / this.totalResponses) * 100;
            this.nps = Math.round(promoterPct - detractorPct);
        } else {
            this.nps = 0;
        }
    },

    getPromoterPct() {
        return this.totalResponses > 0 ? ((this.promoters / this.totalResponses) * 100).toFixed(1) : 0;
    },
    getPassivePct() {
        return this.totalResponses > 0 ? ((this.passives / this.totalResponses) * 100).toFixed(1) : 0;
    },
    getDetractorPct() {
        return this.totalResponses > 0 ? ((this.detractors / this.totalResponses) * 100).toFixed(1) : 0;
    },

    getNpsLabel() {
        if (this.nps >= 70) return { label: 'World Class', color: 'emerald' };
        if (this.nps >= 50) return { label: 'Excellent', color: 'green' };
        if (this.nps >= 30) return { label: 'Good', color: 'blue' };
        if (this.nps >= 0) return { label: 'Needs Work', color: 'amber' };
        return { label: 'Critical', color: 'red' };
    },

    loadExample() {
        this.scores = [2, 1, 3, 2, 5, 8, 12, 25, 35, 45, 62];
        this.calculate();
    },

    reset() {
        this.scores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`NPS Score: ${this.nps}\nPromoters: ${this.getPromoterPct()}%\nPassives: ${this.getPassivePct()}%\nDetractors: ${this.getDetractorPct()}%\nTotal Responses: ${this.totalResponses}`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <!-- Score Input Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-800">Enter Response Counts</h3>
            <div class="text-sm text-slate-500">Total: <span class="font-bold" x-text="totalResponses"></span></div>
        </div>

        <div class="grid grid-cols-11 gap-2">
            <template x-for="(count, index) in scores" :key="index">
                <div class="text-center">
                    <div class="text-xs font-bold mb-2 py-1 rounded-lg"
                        :class="{
                            'bg-red-100 text-red-700': index <= 6,
                            'bg-amber-100 text-amber-700': index >= 7 && index <= 8,
                            'bg-emerald-100 text-emerald-700': index >= 9
                        }"
                        x-text="index"></div>
                    <input type="number" x-model="scores[index]" @input="calculate()"
                        class="w-full px-2 py-2 text-center rounded-lg border border-slate-200 font-mono text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                        min="0" placeholder="0">
                </div>
            </template>
        </div>

        <!-- Legend -->
        <div class="flex justify-between mt-3 text-xs">
            <span class="text-red-600 font-medium">← Detractors (0-6)</span>
            <span class="text-amber-600 font-medium">Passives (7-8)</span>
            <span class="text-emerald-600 font-medium">Promoters (9-10) →</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Breakdown -->
        <div class="space-y-4">
            <!-- Category Bars -->
            <div class="bg-white rounded-xl p-5 border border-slate-200 space-y-4">
                <!-- Promoters -->
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-bold text-emerald-700">Promoters (9-10)</span>
                        <span class="font-mono" x-text="promoters + ' (' + getPromoterPct() + '%)'"></span>
                    </div>
                    <div class="h-4 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all"
                            :style="'width: ' + getPromoterPct() + '%'"></div>
                    </div>
                </div>

                <!-- Passives -->
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-bold text-amber-700">Passives (7-8)</span>
                        <span class="font-mono" x-text="passives + ' (' + getPassivePct() + '%)'"></span>
                    </div>
                    <div class="h-4 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full transition-all"
                            :style="'width: ' + getPassivePct() + '%'"></div>
                    </div>
                </div>

                <!-- Detractors -->
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-bold text-red-700">Detractors (0-6)</span>
                        <span class="font-mono" x-text="detractors + ' (' + getDetractorPct() + '%)'"></span>
                    </div>
                    <div class="h-4 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 rounded-full transition-all"
                            :style="'width: ' + getDetractorPct() + '%'"></div>
                    </div>
                </div>
            </div>

            <!-- Industry Benchmarks -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-3">Industry Benchmarks</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">SaaS Average</span>
                        <span class="font-bold text-slate-900">30-40</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">E-commerce</span>
                        <span class="font-bold text-slate-900">40-50</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Tech Leaders</span>
                        <span class="font-bold text-slate-900">60+</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- NPS Result -->
        <div class="space-y-4">
            <!-- Main Score -->
            <div class="rounded-2xl p-8 text-center text-white"
                :class="{
                    'bg-gradient-to-br from-emerald-500 to-green-600': getNpsLabel().color === 'emerald' ||
                        getNpsLabel().color === 'green',
                    'bg-gradient-to-br from-blue-500 to-indigo-600': getNpsLabel().color === 'blue',
                    'bg-gradient-to-br from-amber-500 to-orange-600': getNpsLabel().color === 'amber',
                    'bg-gradient-to-br from-red-500 to-rose-600': getNpsLabel().color === 'red'
                }">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Net Promoter Score</div>
                <div class="text-7xl font-bold mb-3" x-text="nps"></div>
                <div class="text-lg font-medium opacity-90" x-text="getNpsLabel().label"></div>
            </div>

            <!-- Scale Indicator -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <div class="relative h-4 bg-gradient-to-r from-red-400 via-amber-400 to-emerald-400 rounded-full">
                    <div class="absolute inset-y-0 w-1 bg-slate-900 rounded-full transform -translate-x-1/2 transition-all"
                        :style="'left: ' + ((nps + 100) / 200 * 100) + '%'"></div>
                </div>
                <div class="flex justify-between text-xs text-slate-500 mt-2">
                    <span>-100</span>
                    <span>0</span>
                    <span>+100</span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-emerald-50 rounded-xl p-4 text-center border border-emerald-200">
                    <div class="text-2xl font-bold text-emerald-700" x-text="getPromoterPct() + '%'"></div>
                    <div class="text-xs text-emerald-600">Would recommend</div>
                </div>
                <div class="bg-red-50 rounded-xl p-4 text-center border border-red-200">
                    <div class="text-2xl font-bold text-red-700" x-text="getDetractorPct() + '%'"></div>
                    <div class="text-xs text-red-600">Unlikely to recommend</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 flex-1">
            <div class="text-sm text-blue-800">
                <strong>Formula:</strong> NPS = % Promoters − % Detractors (Range: -100 to +100)
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="reset()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Reset</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
