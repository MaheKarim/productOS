<div x-data="{
    features: [
        { name: 'Feature A', impact: 8, confidence: 7, ease: 6, score: 0 },
        { name: 'Feature B', impact: 9, confidence: 5, ease: 8, score: 0 }
    ],

    calculate() {
        this.features.forEach(f => {
            f.score = ((f.impact + f.confidence + f.ease) / 3).toFixed(1);
        });
        this.features.sort((a, b) => b.score - a.score);
    },

    addFeature() {
        this.features.push({ name: 'New Feature', impact: 5, confidence: 5, ease: 5, score: 0 });
        this.calculate();
    },

    removeFeature(index) {
        if (this.features.length > 1) {
            this.features.splice(index, 1);
            this.calculate();
        }
    },

    getScoreLabel(score) {
        if (score >= 8) return { label: 'High Priority', color: 'emerald' };
        if (score >= 6) return { label: 'Medium Priority', color: 'amber' };
        return { label: 'Low Priority', color: 'slate' };
    },

    loadExample() {
        this.features = [
            { name: 'Quick Checkout Flow', impact: 9, confidence: 8, ease: 7, score: 0 },
            { name: 'AI Chatbot', impact: 7, confidence: 4, ease: 3, score: 0 },
            { name: 'Dark Mode', impact: 5, confidence: 10, ease: 9, score: 0 },
            { name: 'Social Login', impact: 6, confidence: 9, ease: 8, score: 0 }
        ];
        this.calculate();
    },

    copyResults() {
        let text = 'ICE Prioritization Results:\\n\\n';
        this.features.forEach((f, i) => {
            text += `${i + 1}. ${f.name}: ${f.score}/10\\n`;
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
                        :class="{ 'bg-amber-100 text-amber-700': index === 0, 'bg-slate-100 text-slate-600': index !== 0 }"
                        x-text="index + 1"></div>

                    <div class="flex-1 space-y-4">
                        <!-- Feature Name -->
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="feature.name"
                                class="flex-1 px-3 py-2 rounded-lg border border-slate-200 font-medium focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20"
                                placeholder="Feature name">
                            <button @click="removeFeature(index)" x-show="features.length > 1"
                                class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- ICE Sliders -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label
                                        class="text-xs font-bold text-blue-600 uppercase tracking-wider">Impact</label>
                                    <span class="text-sm font-mono font-bold text-blue-600"
                                        x-text="feature.impact + '/10'"></span>
                                </div>
                                <input type="range" x-model="feature.impact" @input="calculate()" min="1"
                                    max="10"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                                <p class="text-xs text-slate-400 mt-1">How much value will this create?</p>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label
                                        class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Confidence</label>
                                    <span class="text-sm font-mono font-bold text-emerald-600"
                                        x-text="feature.confidence + '/10'"></span>
                                </div>
                                <input type="range" x-model="feature.confidence" @input="calculate()" min="1"
                                    max="10"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600">
                                <p class="text-xs text-slate-400 mt-1">How sure are we this will work?</p>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label
                                        class="text-xs font-bold text-amber-600 uppercase tracking-wider">Ease</label>
                                    <span class="text-sm font-mono font-bold text-amber-600"
                                        x-text="feature.ease + '/10'"></span>
                                </div>
                                <input type="range" x-model="feature.ease" @input="calculate()" min="1"
                                    max="10"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-600">
                                <p class="text-xs text-slate-400 mt-1">How easy is it to implement?</p>
                            </div>
                        </div>
                    </div>

                    <!-- Score Display -->
                    <div class="text-center px-4 py-3 rounded-xl min-w-[90px]"
                        :class="{
                            'bg-gradient-to-br from-emerald-500 to-teal-600 text-white': feature.score >= 8,
                            'bg-gradient-to-br from-amber-500 to-orange-600 text-white': feature.score >= 6 && feature
                                .score < 8,
                            'bg-slate-200 text-slate-700': feature.score < 6
                        }">
                        <div class="text-2xl font-bold" x-text="feature.score"></div>
                        <div class="text-xs opacity-80">/10</div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Add Feature Button -->
    <button @click="addFeature()"
        class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-teal-400 hover:text-teal-600 transition-colors cursor-pointer flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Feature to Compare
    </button>

    <!-- Summary -->
    <div class="bg-teal-50 rounded-xl p-5 border border-teal-100">
        <h4 class="font-bold text-teal-900 mb-3">Prioritized Rankings</h4>
        <div class="space-y-2">
            <template x-for="(feature, index) in features" :key="'rank-' + index">
                <div class="flex items-center gap-3">
                    <span
                        class="w-6 h-6 rounded-full bg-teal-200 text-teal-700 text-xs font-bold flex items-center justify-center"
                        x-text="index + 1"></span>
                    <span class="flex-1 font-medium text-teal-800" x-text="feature.name"></span>
                    <span class="px-2 py-1 rounded-full text-xs font-bold"
                        :class="{
                            'bg-emerald-100 text-emerald-700': feature.score >= 8,
                            'bg-amber-100 text-amber-700': feature.score >= 6 && feature.score < 8,
                            'bg-slate-100 text-slate-600': feature.score < 6
                        }"
                        x-text="getScoreLabel(feature.score).label"></span>
                    <span class="font-mono font-bold text-teal-600" x-text="feature.score + '/10'"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Formula & Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100 flex-1">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-teal-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-teal-800">
                    <strong>ICE Formula:</strong> (Impact + Confidence + Ease) / 3
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-teal-600 rounded-lg hover:bg-teal-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
