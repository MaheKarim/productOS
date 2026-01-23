<div x-data="{
    dau: 15000,
    mau: 50000,
    wau: 30000,

    stickiness: 0,
    weeklyStickiness: 0,
    dauWauRatio: 0,

    calculate() {
        if (this.mau > 0) {
            this.stickiness = ((this.dau / this.mau) * 100).toFixed(1);
        }
        if (this.wau > 0) {
            this.dauWauRatio = ((this.dau / this.wau) * 100).toFixed(1);
        }
        if (this.mau > 0) {
            this.weeklyStickiness = ((this.wau / this.mau) * 100).toFixed(1);
        }
    },

    getStickinesLevel() {
        if (this.stickiness >= 50) return { label: 'Excellent', color: 'emerald', desc: 'Social media-level engagement' };
        if (this.stickiness >= 25) return { label: 'Good', color: 'blue', desc: 'Strong daily usage habit' };
        if (this.stickiness >= 13) return { label: 'Average', color: 'amber', desc: 'Users return 3-4x per week' };
        return { label: 'Low', color: 'red', desc: 'Focus on building daily habits' };
    },

    loadExample() {
        this.dau = 15000;
        this.mau = 50000;
        this.wau = 30000;
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`DAU/MAU Analysis\nDAU: ${this.dau.toLocaleString()}\nWAU: ${this.wau.toLocaleString()}\nMAU: ${this.mau.toLocaleString()}\nStickiness: ${this.stickiness}%\nStatus: ${this.getStickinesLevel().label}`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Inputs -->
        <div class="space-y-5">
            <!-- DAU -->
            <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl p-5 border border-rose-200">
                <label class="block text-sm font-bold text-rose-700 mb-3">
                    Daily Active Users (DAU)
                    <span class="ml-1 text-rose-400 font-normal cursor-help" title="Unique users active today">ⓘ</span>
                </label>
                <input type="number" x-model="dau" @input="calculate()"
                    class="w-full px-4 py-3.5 rounded-xl border border-rose-200 font-mono text-lg focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 bg-white"
                    min="0" placeholder="15000">
            </div>

            <!-- WAU -->
            <div class="bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl p-5 border border-purple-200">
                <label class="block text-sm font-bold text-purple-700 mb-3">
                    Weekly Active Users (WAU)
                    <span class="ml-1 text-purple-400 font-normal cursor-help"
                        title="Unique users active this week">ⓘ</span>
                </label>
                <input type="number" x-model="wau" @input="calculate()"
                    class="w-full px-4 py-3.5 rounded-xl border border-purple-200 font-mono text-lg focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 bg-white"
                    min="0" placeholder="30000">
            </div>

            <!-- MAU -->
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-5 border border-indigo-200">
                <label class="block text-sm font-bold text-indigo-700 mb-3">
                    Monthly Active Users (MAU)
                    <span class="ml-1 text-indigo-400 font-normal cursor-help"
                        title="Unique users active this month">ⓘ</span>
                </label>
                <input type="number" x-model="mau" @input="calculate()"
                    class="w-full px-4 py-3.5 rounded-xl border border-indigo-200 font-mono text-lg focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 bg-white"
                    min="0" placeholder="50000">
            </div>

            <!-- Quick Tips -->
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-2 text-sm">What is Stickiness?</h4>
                <p class="text-sm text-slate-600">Stickiness measures how often monthly users return daily. Higher
                    stickiness = stronger user habit.</p>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <!-- Main Stickiness Score -->
            <div class="rounded-2xl p-8 text-center text-white"
                :class="{
                    'bg-gradient-to-br from-emerald-500 to-green-600': stickiness >= 50,
                    'bg-gradient-to-br from-blue-500 to-indigo-600': stickiness >= 25 && stickiness < 50,
                    'bg-gradient-to-br from-amber-500 to-orange-600': stickiness >= 13 && stickiness < 25,
                    'bg-gradient-to-br from-red-500 to-rose-600': stickiness < 13
                }">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">DAU/MAU Stickiness</div>
                <div class="text-7xl font-bold mb-2" x-text="stickiness + '%'"></div>
                <div class="text-lg font-medium opacity-90" x-text="getStickinesLevel().label"></div>
            </div>

            <!-- Ratio Cards -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center">
                    <div class="text-xs text-slate-500 uppercase mb-1">DAU / WAU</div>
                    <div class="text-2xl font-bold text-purple-600" x-text="dauWauRatio + '%'"></div>
                    <div class="text-xs text-slate-400 mt-1">Weekly stickiness</div>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center">
                    <div class="text-xs text-slate-500 uppercase mb-1">WAU / MAU</div>
                    <div class="text-2xl font-bold text-indigo-600" x-text="weeklyStickiness + '%'"></div>
                    <div class="text-xs text-slate-400 mt-1">Monthly return rate</div>
                </div>
            </div>

            <!-- Visual Gauge -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-4">Stickiness Scale</h4>
                <div
                    class="relative h-6 bg-gradient-to-r from-red-400 via-amber-400 via-blue-400 to-emerald-400 rounded-full">
                    <div class="absolute inset-y-0 w-1.5 bg-slate-900 rounded-full transform -translate-x-1/2 transition-all shadow-lg"
                        :style="'left: ' + Math.min(stickiness, 100) + '%'"></div>
                    <!-- Markers -->
                    <div class="absolute -top-6 left-[13%] transform -translate-x-1/2 text-xs text-slate-500">13%</div>
                    <div class="absolute -top-6 left-[25%] transform -translate-x-1/2 text-xs text-slate-500">25%</div>
                    <div class="absolute -top-6 left-[50%] transform -translate-x-1/2 text-xs text-slate-500">50%</div>
                </div>
                <div class="flex justify-between text-xs text-slate-500 mt-2">
                    <span>0%</span>
                    <span>100%</span>
                </div>
            </div>

            <!-- Status Card -->
            <div class="rounded-xl p-5 border-2"
                :class="{
                    'bg-emerald-50 border-emerald-200': stickiness >= 50,
                    'bg-blue-50 border-blue-200': stickiness >= 25 && stickiness < 50,
                    'bg-amber-50 border-amber-200': stickiness >= 13 && stickiness < 25,
                    'bg-red-50 border-red-200': stickiness < 13
                }">
                <div class="flex items-start gap-3">
                    <div class="text-3xl"
                        x-text="stickiness >= 50 ? '🔥' : (stickiness >= 25 ? '📈' : (stickiness >= 13 ? '💡' : '🎯'))">
                    </div>
                    <div>
                        <div class="font-bold"
                            :class="{
                                'text-emerald-800': stickiness >= 50,
                                'text-blue-800': stickiness >= 25 && stickiness < 50,
                                'text-amber-800': stickiness >= 13 && stickiness < 25,
                                'text-red-800': stickiness < 13
                            }"
                            x-text="getStickinesLevel().label + ' Engagement'"></div>
                        <div class="text-sm mt-1"
                            :class="{
                                'text-emerald-600': stickiness >= 50,
                                'text-blue-600': stickiness >= 25 && stickiness < 50,
                                'text-amber-600': stickiness >= 13 && stickiness < 25,
                                'text-red-600': stickiness < 13
                            }"
                            x-text="getStickinesLevel().desc"></div>
                    </div>
                </div>
            </div>

            <!-- Benchmarks -->
            <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                <div class="text-sm text-indigo-800">
                    <strong>Benchmarks:</strong> Social Apps: 50%+ | SaaS: 10-20% | E-commerce: 5-10%
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-rose-50 rounded-xl p-4 border border-rose-100 flex-1">
            <div class="text-sm text-rose-800">
                <strong>Formula:</strong> Stickiness = (DAU / MAU) × 100
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-rose-600 rounded-lg hover:bg-rose-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
