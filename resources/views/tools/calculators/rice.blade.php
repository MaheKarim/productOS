<div x-data="{
    features: [
        { name: 'Feature A', reach: 5000, impact: 2, confidence: 80, effort: 3, score: 0 },
        { name: 'Feature B', reach: 2000, impact: 3, confidence: 100, effort: 1, score: 0 }
    ],

    impactOptions: [
        { value: 0.25, label: 'Minimal (0.25x)' },
        { value: 0.5, label: 'Low (0.5x)' },
        { value: 1, label: 'Medium (1x)' },
        { value: 2, label: 'High (2x)' },
        { value: 3, label: 'Massive (3x)' }
    ],

    calculate() {
        this.features.forEach(f => {
            if (f.effort > 0) {
                f.score = ((f.reach * f.impact * (f.confidence / 100)) / f.effort).toFixed(0);
            } else {
                f.score = 0;
            }
        });
        this.features.sort((a, b) => b.score - a.score);
    },

    addFeature() {
        this.features.push({ name: 'New Feature', reach: 1000, impact: 1, confidence: 80, effort: 2, score: 0 });
        this.calculate();
    },

    removeFeature(index) {
        if (this.features.length > 1) {
            this.features.splice(index, 1);
            this.calculate();
        }
    },

    getScoreColor(score, maxScore) {
        const ratio = score / maxScore;
        if (ratio >= 0.7) return 'emerald';
        if (ratio >= 0.4) return 'amber';
        return 'slate';
    },

    loadExample() {
        this.features = [
            { name: 'Mobile App Redesign', reach: 10000, impact: 2, confidence: 80, effort: 4, score: 0 },
            { name: 'One-Click Checkout', reach: 5000, impact: 3, confidence: 100, effort: 2, score: 0 },
            { name: 'Dark Mode', reach: 8000, impact: 0.5, confidence: 100, effort: 1, score: 0 },
            { name: 'AI Recommendations', reach: 3000, impact: 3, confidence: 50, effort: 6, score: 0 }
        ];
        this.calculate();
    },

    copyResults() {
        let text = 'RICE Prioritization Results:\\n\\n';
        this.features.forEach((f, i) => {
            text += `${i + 1}. ${f.name}: ${f.score} points\\n`;
        });
        navigator.clipboard.writeText(text);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-6">

    <!-- Features List -->
    <div class="space-y-4">
        <template x-for="(feature, index) in features" :key="index">
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <!-- Rank Badge -->
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg shrink-0"
                        :class="{
                            'bg-amber-100 text-amber-700': index === 0,
                            'bg-slate-100 text-slate-600': index !== 0
                        }"
                        x-text="index + 1"></div>

                    <div class="flex-1 space-y-4">
                        <!-- Feature Name -->
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="feature.name"
                                class="flex-1 px-3 py-2 rounded-lg border border-slate-200 font-medium focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                                placeholder="Feature name">
                            <button @click="removeFeature(index)" x-show="features.length > 1"
                                class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- RICE Inputs -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label
                                    class="block text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">Reach</label>
                                <input type="number" x-model="feature.reach" @input="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 font-mono text-sm focus:border-purple-500"
                                    placeholder="Users/quarter" min="0">
                                <span class="text-xs text-slate-400">users per quarter</span>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">Impact</label>
                                <select x-model="feature.impact" @change="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-purple-500">
                                    <template x-for="opt in impactOptions">
                                        <option :value="opt.value" x-text="opt.label"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">Confidence</label>
                                <select x-model="feature.confidence" @change="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-purple-500">
                                    <option value="100">100% - High</option>
                                    <option value="80">80% - Medium</option>
                                    <option value="50">50% - Low</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">Effort</label>
                                <input type="number" x-model="feature.effort" @input="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 font-mono text-sm focus:border-purple-500"
                                    placeholder="Person-months" min="0.5" step="0.5">
                                <span class="text-xs text-slate-400">person-months</span>
                            </div>
                        </div>
                    </div>

                    <!-- Score Display -->
                    <div
                        class="text-center px-4 py-3 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 text-white min-w-[80px]">
                        <div class="text-2xl font-bold" x-text="feature.score"></div>
                        <div class="text-xs opacity-80">Score</div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Add Feature Button -->
    <button @click="addFeature()"
        class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-purple-400 hover:text-purple-600 transition-colors cursor-pointer flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Feature to Compare
    </button>

    <!-- Summary -->
    <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
        <h4 class="font-bold text-purple-900 mb-3">Prioritized Rankings</h4>
        <div class="space-y-2">
            <template x-for="(feature, index) in features" :key="'rank-' + index">
                <div class="flex items-center gap-3">
                    <span
                        class="w-6 h-6 rounded-full bg-purple-200 text-purple-700 text-xs font-bold flex items-center justify-center"
                        x-text="index + 1"></span>
                    <span class="flex-1 font-medium text-purple-800" x-text="feature.name"></span>
                    <span class="font-mono font-bold text-purple-600" x-text="feature.score + ' pts'"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Formula & Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-purple-800">
                    <strong>RICE Formula:</strong> (Reach × Impact × Confidence) / Effort
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
