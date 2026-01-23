<div x-data="{
    controlVisitors: 5000,
    controlConversions: 150,
    variantVisitors: 5000,
    variantConversions: 185,
    confidenceLevel: 95,

    controlRate: 0,
    variantRate: 0,
    improvement: 0,
    zScore: 0,
    pValue: 0,
    isSignificant: false,
    confidenceInterval: { lower: 0, upper: 0 },

    calculate() {
        this.controlRate = (this.controlConversions / this.controlVisitors) * 100;
        this.variantRate = (this.variantConversions / this.variantVisitors) * 100;

        if (this.controlRate > 0) {
            this.improvement = ((this.variantRate - this.controlRate) / this.controlRate) * 100;
        }

        // Two-proportion z-test
        const p1 = this.controlConversions / this.controlVisitors;
        const p2 = this.variantConversions / this.variantVisitors;
        const n1 = this.controlVisitors;
        const n2 = this.variantVisitors;

        const pooledP = (this.controlConversions + this.variantConversions) / (n1 + n2);
        const se = Math.sqrt(pooledP * (1 - pooledP) * (1 / n1 + 1 / n2));

        if (se > 0) {
            this.zScore = (p2 - p1) / se;
            this.pValue = 2 * (1 - this.normalCDF(Math.abs(this.zScore)));
        }

        const alpha = (100 - this.confidenceLevel) / 100;
        this.isSignificant = this.pValue < alpha;

        // Confidence interval for the difference
        const zCritical = this.getZCritical(this.confidenceLevel);
        const seDiff = Math.sqrt((p1 * (1 - p1) / n1) + (p2 * (1 - p2) / n2));
        const diff = (p2 - p1) * 100;
        const margin = zCritical * seDiff * 100;
        this.confidenceInterval.lower = (diff - margin).toFixed(2);
        this.confidenceInterval.upper = (diff + margin).toFixed(2);
    },

    normalCDF(x) {
        const a1 = 0.254829592,
            a2 = -0.284496736,
            a3 = 1.421413741;
        const a4 = -1.453152027,
            a5 = 1.061405429,
            p = 0.3275911;
        const sign = x < 0 ? -1 : 1;
        x = Math.abs(x) / Math.sqrt(2);
        const t = 1.0 / (1.0 + p * x);
        const y = 1.0 - (((((a5 * t + a4) * t) + a3) * t + a2) * t + a1) * t * Math.exp(-x * x);
        return 0.5 * (1.0 + sign * y);
    },

    getZCritical(conf) {
        if (conf === 99) return 2.576;
        if (conf === 95) return 1.96;
        return 1.645;
    },

    loadExample() {
        this.controlVisitors = 5000;
        this.controlConversions = 150;
        this.variantVisitors = 5000;
        this.variantConversions = 185;
        this.confidenceLevel = 95;
        this.calculate();
    },

    copyResults() {
        const text = `A/B Test Results\nControl: ${this.controlRate.toFixed(2)}%\nVariant: ${this.variantRate.toFixed(2)}%\nImprovement: ${this.improvement >= 0 ? '+' : ''}${this.improvement.toFixed(2)}%\nSignificant: ${this.isSignificant ? 'Yes' : 'No'} (p=${this.pValue.toFixed(4)})`;
        navigator.clipboard.writeText(text);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Inputs -->
        <div class="space-y-6">
            <!-- Control Group -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                    Control (A)
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">Visitors</label>
                        <input type="number" x-model="controlVisitors" @input="calculate()"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 font-mono focus:border-blue-500"
                            min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">Conversions</label>
                        <input type="number" x-model="controlConversions" @input="calculate()"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 font-mono focus:border-blue-500"
                            min="0">
                    </div>
                </div>
                <div class="mt-3 text-sm text-slate-500">
                    Conversion Rate: <span class="font-bold text-slate-700"
                        x-text="controlRate.toFixed(2) + '%'"></span>
                </div>
            </div>

            <!-- Variant Group -->
            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
                <h4 class="font-bold text-blue-800 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    Variant (B)
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-blue-600 mb-2">Visitors</label>
                        <input type="number" x-model="variantVisitors" @input="calculate()"
                            class="w-full px-4 py-3 rounded-xl border border-blue-200 font-mono focus:border-blue-500 bg-white"
                            min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-600 mb-2">Conversions</label>
                        <input type="number" x-model="variantConversions" @input="calculate()"
                            class="w-full px-4 py-3 rounded-xl border border-blue-200 font-mono focus:border-blue-500 bg-white"
                            min="0">
                    </div>
                </div>
                <div class="mt-3 text-sm text-blue-600">
                    Conversion Rate: <span class="font-bold text-blue-800" x-text="variantRate.toFixed(2) + '%'"></span>
                </div>
            </div>

            <!-- Confidence Level -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Confidence Level</label>
                <div class="flex gap-3">
                    <template x-for="level in [90, 95, 99]" :key="level">
                        <button @click="confidenceLevel = level; calculate()"
                            class="flex-1 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
                            :class="confidenceLevel === level ? 'bg-blue-600 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            x-text="level + '%'"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <!-- Main Result -->
            <div class="rounded-2xl p-6 text-center"
                :class="isSignificant ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white' :
                    'bg-gradient-to-br from-amber-500 to-orange-500 text-white'">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Statistical Significance</div>
                <div class="text-4xl font-bold mb-2" x-text="isSignificant ? 'YES ✓' : 'NOT YET'"></div>
                <div class="opacity-80"
                    x-text="isSignificant ? 'You can confidently deploy the variant' : 'Need more data or larger effect'">
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl p-4 border border-slate-200 text-center">
                    <div class="text-sm text-slate-500 mb-1">Improvement</div>
                    <div class="text-2xl font-bold" :class="improvement >= 0 ? 'text-emerald-600' : 'text-red-600'"
                        x-text="(improvement >= 0 ? '+' : '') + improvement.toFixed(2) + '%'"></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-slate-200 text-center">
                    <div class="text-sm text-slate-500 mb-1">P-Value</div>
                    <div class="text-2xl font-bold text-slate-900" x-text="pValue.toFixed(4)"></div>
                </div>
            </div>

            <!-- Confidence Interval -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                <div class="text-sm text-slate-600 mb-2" x-text="confidenceLevel + '% Confidence Interval'"></div>
                <div class="flex items-center gap-3">
                    <span class="font-mono font-bold text-slate-900" x-text="confidenceInterval.lower + '%'"></span>
                    <div class="flex-1 h-2 bg-slate-200 rounded-full relative">
                        <div class="absolute inset-y-0 bg-blue-500 rounded-full"
                            :style="'left: ' + Math.max(0, (parseFloat(confidenceInterval.lower) + 20) / 40 * 100) +
                                '%; right: ' + Math.max(0, 100 - (parseFloat(confidenceInterval.upper) + 20) / 40 *
                                100) + '%'">
                        </div>
                    </div>
                    <span class="font-mono font-bold text-slate-900" x-text="confidenceInterval.upper + '%'"></span>
                </div>
                <div class="text-xs text-slate-500 mt-2"
                    x-text="'The true difference is between ' + confidenceInterval.lower + '% and ' + confidenceInterval.upper + '%'">
                </div>
            </div>

            <!-- Recommendation -->
            <div class="rounded-xl p-4 border-2"
                :class="isSignificant ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200'">
                <div class="font-bold" :class="isSignificant ? 'text-emerald-800' : 'text-amber-800'">Recommendation
                </div>
                <div class="text-sm mt-1" :class="isSignificant ? 'text-emerald-600' : 'text-amber-600'"
                    x-text="isSignificant ? 'Deploy the winning variant with confidence.' : 'Continue the test to gather more data before making a decision.'">
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 flex-1">
            <div class="text-sm text-blue-800">
                <strong>Method:</strong> Two-proportion z-test for statistical significance
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
