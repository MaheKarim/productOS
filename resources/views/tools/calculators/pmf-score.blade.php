<div x-data="{
    veryDisappointed: 45,
    somewhatDisappointed: 35,
    notDisappointed: 20,
    totalResponses: 0,
    pmfScore: 0,

    calculate() {
        this.totalResponses = Number(this.veryDisappointed) + Number(this.somewhatDisappointed) + Number(this.notDisappointed);
        if (this.totalResponses > 0) {
            this.pmfScore = ((this.veryDisappointed / this.totalResponses) * 100).toFixed(1);
        } else {
            this.pmfScore = 0;
        }
    },

    getVeryPct() {
        return this.totalResponses > 0 ? ((this.veryDisappointed / this.totalResponses) * 100).toFixed(1) : 0;
    },
    getSomewhatPct() {
        return this.totalResponses > 0 ? ((this.somewhatDisappointed / this.totalResponses) * 100).toFixed(1) : 0;
    },
    getNotPct() {
        return this.totalResponses > 0 ? ((this.notDisappointed / this.totalResponses) * 100).toFixed(1) : 0;
    },

    getPmfStatus() {
        if (this.pmfScore >= 40) return { label: 'Strong PMF', color: 'emerald', desc: 'You have product-market fit!' };
        if (this.pmfScore >= 25) return { label: 'Getting Close', color: 'amber', desc: 'Keep iterating to reach 40%' };
        return { label: 'Keep Searching', color: 'red', desc: 'Focus on finding your core value prop' };
    },

    loadExample() {
        this.veryDisappointed = 45;
        this.somewhatDisappointed = 35;
        this.notDisappointed = 20;
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`PMF Score: ${this.pmfScore}%\nVery Disappointed: ${this.getVeryPct()}%\nSomewhat Disappointed: ${this.getSomewhatPct()}%\nNot Disappointed: ${this.getNotPct()}%\nStatus: ${this.getPmfStatus().label}`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <!-- Question Context -->
    <div class="bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl p-5 border border-violet-200">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <div>
                <div class="font-bold text-violet-900">The Sean Ellis Test Question</div>
                <div class="text-violet-700 mt-1">"How would you feel if you could no longer use [Product]?"</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Inputs -->
        <div class="space-y-5">
            <h4 class="font-bold text-slate-800">Enter Response Counts</h4>

            <!-- Very Disappointed -->
            <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-200">
                <label class="block text-sm font-bold text-emerald-700 mb-3">
                    "Very disappointed" 💚
                </label>
                <input type="number" x-model="veryDisappointed" @input="calculate()"
                    class="w-full px-4 py-3 rounded-xl border border-emerald-200 font-mono text-lg focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 bg-white"
                    min="0" placeholder="0">
                <div class="mt-2 text-sm text-emerald-600">
                    <span class="font-bold" x-text="getVeryPct() + '%'"></span> of responses
                </div>
            </div>

            <!-- Somewhat Disappointed -->
            <div class="bg-amber-50 rounded-xl p-5 border border-amber-200">
                <label class="block text-sm font-bold text-amber-700 mb-3">
                    "Somewhat disappointed" 🤔
                </label>
                <input type="number" x-model="somewhatDisappointed" @input="calculate()"
                    class="w-full px-4 py-3 rounded-xl border border-amber-200 font-mono text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 bg-white"
                    min="0" placeholder="0">
                <div class="mt-2 text-sm text-amber-600">
                    <span class="font-bold" x-text="getSomewhatPct() + '%'"></span> of responses
                </div>
            </div>

            <!-- Not Disappointed -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-3">
                    "Not disappointed" 😐
                </label>
                <input type="number" x-model="notDisappointed" @input="calculate()"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 font-mono text-lg focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 bg-white"
                    min="0" placeholder="0">
                <div class="mt-2 text-sm text-slate-600">
                    <span class="font-bold" x-text="getNotPct() + '%'"></span> of responses
                </div>
            </div>

            <div class="text-sm text-slate-500 text-center">
                Total responses: <span class="font-bold" x-text="totalResponses"></span>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <!-- Main Score -->
            <div class="rounded-2xl p-8 text-center text-white"
                :class="{
                    'bg-gradient-to-br from-emerald-500 to-green-600': pmfScore >= 40,
                    'bg-gradient-to-br from-amber-500 to-orange-600': pmfScore >= 25 && pmfScore < 40,
                    'bg-gradient-to-br from-red-500 to-rose-600': pmfScore < 25
                }">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Product-Market Fit Score</div>
                <div class="text-7xl font-bold mb-3" x-text="pmfScore + '%'"></div>
                <div class="text-lg font-medium opacity-90" x-text="getPmfStatus().label"></div>
            </div>

            <!-- Threshold Indicator -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <div class="relative">
                    <div class="h-4 bg-gradient-to-r from-red-400 via-amber-400 to-emerald-400 rounded-full"></div>
                    <div class="absolute inset-y-0 w-1 bg-slate-900 rounded-full transform -translate-x-1/2 transition-all"
                        :style="'left: ' + Math.min(pmfScore, 100) + '%'"></div>
                    <!-- 40% threshold marker -->
                    <div
                        class="absolute -top-7 left-[40%] transform -translate-x-1/2 text-xs font-bold text-emerald-600">
                        40% threshold</div>
                    <div class="absolute top-0 left-[40%] w-0.5 h-6 bg-emerald-600 transform -translate-x-1/2"></div>
                </div>
                <div class="flex justify-between text-xs text-slate-500 mt-2">
                    <span>0%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>

            <!-- Status Card -->
            <div class="rounded-xl p-5 border-2"
                :class="{
                    'bg-emerald-50 border-emerald-200': pmfScore >= 40,
                    'bg-amber-50 border-amber-200': pmfScore >= 25 && pmfScore < 40,
                    'bg-red-50 border-red-200': pmfScore < 25
                }">
                <div class="flex items-start gap-3">
                    <div class="text-3xl" x-text="pmfScore >= 40 ? '🎉' : (pmfScore >= 25 ? '📈' : '🔍')"></div>
                    <div>
                        <div class="font-bold"
                            :class="{
                                'text-emerald-800': pmfScore >= 40,
                                'text-amber-800': pmfScore >= 25 && pmfScore < 40,
                                'text-red-800': pmfScore < 25
                            }"
                            x-text="getPmfStatus().label"></div>
                        <div class="text-sm mt-1"
                            :class="{
                                'text-emerald-600': pmfScore >= 40,
                                'text-amber-600': pmfScore >= 25 && pmfScore < 40,
                                'text-red-600': pmfScore < 25
                            }"
                            x-text="getPmfStatus().desc"></div>
                    </div>
                </div>
            </div>

            <!-- Recommendation -->
            <div class="bg-violet-50 rounded-xl p-4 border border-violet-100">
                <div class="text-sm text-violet-800">
                    <template x-if="pmfScore >= 40">
                        <span><strong>Next Step:</strong> Focus on growth and scaling. You've validated the core
                            value.</span>
                    </template>
                    <template x-if="pmfScore >= 25 && pmfScore < 40">
                        <span><strong>Next Step:</strong> Interview "somewhat disappointed" users to find missing
                            features.</span>
                    </template>
                    <template x-if="pmfScore < 25">
                        <span><strong>Next Step:</strong> Deep-dive with "very disappointed" users to understand their
                            needs.</span>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-violet-50 rounded-xl p-4 border border-violet-100 flex-1">
            <div class="text-sm text-violet-800">
                <strong>The 40% Rule:</strong> If 40%+ would be "very disappointed" without your product, you have PMF.
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-violet-600 rounded-lg hover:bg-violet-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
