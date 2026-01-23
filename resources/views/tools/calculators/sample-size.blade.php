<div x-data="{
    baselineRate: 3,
    mde: 20,
    power: 80,
    significance: 5,
    dailyVisitors: 1000,

    sampleSize: 0,
    totalSample: 0,
    testDuration: 0,

    calculate() {
        const p = this.baselineRate / 100;
        const delta = p * (this.mde / 100);
        const alpha = this.significance / 100;
        const beta = 1 - (this.power / 100);

        const zAlpha = this.getZScore(1 - alpha / 2);
        const zBeta = this.getZScore(1 - beta);

        const p1 = p;
        const p2 = p + delta;
        const pBar = (p1 + p2) / 2;

        const numerator = Math.pow(zAlpha * Math.sqrt(2 * pBar * (1 - pBar)) + zBeta * Math.sqrt(p1 * (1 - p1) + p2 * (1 - p2)), 2);
        const denominator = Math.pow(delta, 2);

        this.sampleSize = Math.ceil(numerator / denominator);
        this.totalSample = this.sampleSize * 2;

        if (this.dailyVisitors > 0) {
            this.testDuration = Math.ceil(this.totalSample / this.dailyVisitors);
        }
    },

    getZScore(p) {
        if (p <= 0 || p >= 1) return 0;
        const a = [0, -3.969683028665376e1, 2.209460984245205e2, -2.759285104469687e2, 1.383577518672690e2, -3.066479806614716e1, 2.506628277459239e0];
        const b = [0, -5.447609879822406e1, 1.615858368580409e2, -1.556989798598866e2, 6.680131188771972e1, -1.328068155288572e1];
        const c = [0, -7.784894002430293e-3, -3.223964580411365e-1, -2.400758277161838e0, -2.549732539343734e0, 4.374664141464968e0, 2.938163982698783e0];
        const d = [0, 7.784695709041462e-3, 3.224671290700398e-1, 2.445134137142996e0, 3.754408661907416e0];

        const pLow = 0.02425,
            pHigh = 1 - pLow;
        let q, r;

        if (p < pLow) {
            q = Math.sqrt(-2 * Math.log(p));
            return (((((c[1] * q + c[2]) * q + c[3]) * q + c[4]) * q + c[5]) * q + c[6]) / ((((d[1] * q + d[2]) * q + d[3]) * q + d[4]) * q + 1);
        } else if (p <= pHigh) {
            q = p - 0.5;
            r = q * q;
            return (((((a[1] * r + a[2]) * r + a[3]) * r + a[4]) * r + a[5]) * r + a[6]) * q / (((((b[1] * r + b[2]) * r + b[3]) * r + b[4]) * r + b[5]) * r + 1);
        } else {
            q = Math.sqrt(-2 * Math.log(1 - p));
            return -(((((c[1] * q + c[2]) * q + c[3]) * q + c[4]) * q + c[5]) * q + c[6]) / ((((d[1] * q + d[2]) * q + d[3]) * q + d[4]) * q + 1);
        }
    },

    loadExample() {
        this.baselineRate = 3;
        this.mde = 20;
        this.power = 80;
        this.significance = 5;
        this.dailyVisitors = 1000;
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`Sample Size Calculator Results\nPer Variant: ${this.sampleSize.toLocaleString()} visitors\nTotal: ${this.totalSample.toLocaleString()} visitors\nDuration: ${this.testDuration} days`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Inputs -->
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Baseline Conversion Rate (%)
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="Your current conversion rate">ⓘ</span>
                </label>
                <div class="relative">
                    <input type="number" x-model="baselineRate" @input="calculate()"
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 font-mono focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10"
                        placeholder="3" min="0.1" max="100" step="0.1">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">%</span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Minimum Detectable Effect (%)
                    <span class="ml-1 text-slate-400 font-normal cursor-help"
                        title="Smallest improvement worth detecting">ⓘ</span>
                </label>
                <div class="relative">
                    <input type="number" x-model="mde" @input="calculate()"
                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 font-mono focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10"
                        placeholder="20" min="1" max="100">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">%</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">e.g., 20% means detecting a change from 3% to 3.6%</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Statistical Power</label>
                <div class="flex gap-3">
                    <template x-for="p in [80, 90]" :key="p">
                        <button @click="power = p; calculate()"
                            class="flex-1 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
                            :class="power === p ? 'bg-pink-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            x-text="p + '%'"></button>
                    </template>
                </div>
                <p class="text-xs text-slate-500 mt-1">Probability of detecting a real effect</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Significance Level</label>
                <div class="flex gap-3">
                    <template x-for="s in [5, 1]" :key="s">
                        <button @click="significance = s; calculate()"
                            class="flex-1 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
                            :class="significance === s ? 'bg-pink-600 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            x-text="s + '% (α=' + (s/100) + ')'"></button>
                    </template>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">Daily Visitors (for duration
                    estimate)</label>
                <input type="number" x-model="dailyVisitors" @input="calculate()"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 font-mono focus:border-pink-500"
                    placeholder="1000" min="1">
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <!-- Main Result -->
            <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Sample Size Per Variant</div>
                <div class="text-5xl font-bold mb-2" x-text="sampleSize.toLocaleString()"></div>
                <div class="opacity-80">visitors needed</div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center">
                    <div class="text-sm text-slate-500 mb-1">Total Sample</div>
                    <div class="text-2xl font-bold text-slate-900" x-text="totalSample.toLocaleString()"></div>
                    <div class="text-xs text-slate-400">both variants combined</div>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center">
                    <div class="text-sm text-slate-500 mb-1">Test Duration</div>
                    <div class="text-2xl font-bold text-slate-900" x-text="testDuration + ' days'"></div>
                    <div class="text-xs text-slate-400" x-text="'~' + Math.ceil(testDuration / 7) + ' weeks'"></div>
                </div>
            </div>

            <!-- Visual Timeline -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-3">Expected Timeline</h4>
                <div class="relative h-4 bg-slate-200 rounded-full overflow-hidden">
                    <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-pink-400 to-pink-600 rounded-full transition-all"
                        :style="'width: ' + Math.min(100, (7 / testDuration) * 100) + '%'"></div>
                </div>
                <div class="flex justify-between text-xs text-slate-500 mt-2">
                    <span>Start</span>
                    <span x-text="'Week ' + Math.ceil(testDuration / 7)"></span>
                </div>
            </div>

            <!-- Target Effect -->
            <div class="bg-pink-50 rounded-xl p-4 border border-pink-100">
                <div class="text-sm text-pink-800">
                    <strong>What you'll detect:</strong> A change from
                    <span class="font-mono" x-text="baselineRate + '%'"></span> to
                    <span class="font-mono" x-text="(baselineRate * (1 + mde/100)).toFixed(2) + '%'"></span>
                    (or higher)
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-pink-50 rounded-xl p-4 border border-pink-100 flex-1">
            <div class="text-sm text-pink-800">
                <strong>Tip:</strong> Smaller MDE requires larger sample size. Choose the smallest effect that's
                business-meaningful.
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-pink-600 rounded-lg hover:bg-pink-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
