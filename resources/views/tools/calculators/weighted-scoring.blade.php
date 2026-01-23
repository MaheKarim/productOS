<div x-data="{
    criteria: [
        { name: 'Revenue Impact', weight: 30 },
        { name: 'User Value', weight: 25 },
        { name: 'Strategic Fit', weight: 20 },
        { name: 'Technical Feasibility', weight: 15 },
        { name: 'Time to Market', weight: 10 }
    ],
    options: [
        { name: 'Option A', scores: [8, 7, 9, 6, 8], total: 0 },
        { name: 'Option B', scores: [6, 9, 7, 8, 9], total: 0 }
    ],

    calculate() {
        const totalWeight = this.criteria.reduce((sum, c) => sum + Number(c.weight), 0);
        this.options.forEach(opt => {
            opt.total = 0;
            this.criteria.forEach((c, i) => {
                const normalizedWeight = c.weight / totalWeight;
                opt.total += (opt.scores[i] || 0) * normalizedWeight;
            });
            opt.total = opt.total.toFixed(2);
        });
        this.options.sort((a, b) => b.total - a.total);
    },

    addCriterion() {
        this.criteria.push({ name: 'New Criterion', weight: 10 });
        this.options.forEach(opt => opt.scores.push(5));
        this.calculate();
    },

    removeCriterion(index) {
        if (this.criteria.length > 2) {
            this.criteria.splice(index, 1);
            this.options.forEach(opt => opt.scores.splice(index, 1));
            this.calculate();
        }
    },

    addOption() {
        const scores = this.criteria.map(() => 5);
        this.options.push({ name: 'New Option', scores, total: 0 });
        this.calculate();
    },

    removeOption(index) {
        if (this.options.length > 1) {
            this.options.splice(index, 1);
            this.calculate();
        }
    },

    getTotalWeight() {
        return this.criteria.reduce((sum, c) => sum + Number(c.weight), 0);
    },

    loadExample() {
        this.criteria = [
            { name: 'Revenue Impact', weight: 30 },
            { name: 'User Value', weight: 25 },
            { name: 'Strategic Fit', weight: 20 },
            { name: 'Technical Feasibility', weight: 15 },
            { name: 'Time to Market', weight: 10 }
        ];
        this.options = [
            { name: 'Mobile App', scores: [8, 9, 7, 5, 4], total: 0 },
            { name: 'API Integration', scores: [6, 7, 9, 8, 9], total: 0 },
            { name: 'Dashboard Redesign', scores: [5, 8, 6, 9, 7], total: 0 }
        ];
        this.calculate();
    },

    copyResults() {
        let text = 'Weighted Scoring Results:\\n\\n';
        this.options.forEach((opt, i) => {
            text += `${i + 1}. ${opt.name}: ${opt.total}/10\\n`;
        });
        navigator.clipboard.writeText(text);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-6">

    <!-- Criteria Setup -->
    <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-bold text-slate-800">Scoring Criteria</h4>
            <div class="text-sm" :class="getTotalWeight() === 100 ? 'text-emerald-600' : 'text-amber-600'">
                Total weight: <span class="font-bold" x-text="getTotalWeight() + '%'"></span>
            </div>
        </div>

        <div class="space-y-3">
            <template x-for="(criterion, cIndex) in criteria" :key="cIndex">
                <div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-slate-200">
                    <input type="text" x-model="criterion.name"
                        class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-orange-500"
                        placeholder="Criterion name">
                    <div class="flex items-center gap-2 w-32">
                        <input type="number" x-model="criterion.weight" @input="calculate()"
                            class="w-16 px-2 py-2 rounded-lg border border-slate-200 text-sm font-mono text-center focus:border-orange-500"
                            min="0" max="100">
                        <span class="text-sm text-slate-400">%</span>
                    </div>
                    <button @click="removeCriterion(cIndex)" x-show="criteria.length > 2"
                        class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <button @click="addCriterion()"
            class="mt-3 text-sm font-medium text-orange-600 hover:text-orange-700 cursor-pointer flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Criterion
        </button>
    </div>

    <!-- Options Scoring -->
    <div class="space-y-4">
        <template x-for="(option, oIndex) in options" :key="oIndex">
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg shrink-0"
                        :class="{ 'bg-amber-100 text-amber-700': oIndex === 0, 'bg-slate-100 text-slate-600': oIndex !== 0 }"
                        x-text="oIndex + 1"></div>
                    <input type="text" x-model="option.name"
                        class="flex-1 px-3 py-2 rounded-lg border border-slate-200 font-medium focus:border-orange-500"
                        placeholder="Option name">
                    <div
                        class="text-center px-4 py-2 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 text-white min-w-[80px]">
                        <div class="text-xl font-bold" x-text="option.total"></div>
                        <div class="text-xs opacity-80">/10</div>
                    </div>
                    <button @click="removeOption(oIndex)" x-show="options.length > 1"
                        class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Scores Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                    <template x-for="(criterion, cIndex) in criteria" :key="'score-' + cIndex">
                        <div class="bg-slate-50 rounded-lg p-3">
                            <label class="block text-xs font-medium text-slate-600 mb-2 truncate"
                                x-text="criterion.name"></label>
                            <div class="flex items-center gap-2">
                                <input type="range" x-model="option.scores[cIndex]" @input="calculate()"
                                    min="1" max="10"
                                    class="flex-1 h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-orange-500">
                                <span class="text-sm font-mono font-bold text-orange-600 w-6 text-right"
                                    x-text="option.scores[cIndex]"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <!-- Add Option Button -->
    <button @click="addOption()"
        class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-orange-400 hover:text-orange-600 transition-colors cursor-pointer flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Option to Compare
    </button>

    <!-- Formula & Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-orange-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-orange-800">
                    <strong>Formula:</strong> Score = Σ(Criterion Score × Normalized Weight)
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
