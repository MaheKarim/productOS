<div x-data="{
    sprints: [
        { name: 'Sprint 1', points: 24 },
        { name: 'Sprint 2', points: 28 },
        { name: 'Sprint 3', points: 22 },
        { name: 'Sprint 4', points: 26 },
        { name: 'Sprint 5', points: 30 }
    ],
    sprintLength: 2,

    avgVelocity: 0,
    totalPoints: 0,
    trend: 0,
    forecastPoints: 0,

    calculate() {
        if (this.sprints.length === 0) return;

        this.totalPoints = this.sprints.reduce((sum, s) => sum + Number(s.points), 0);
        this.avgVelocity = (this.totalPoints / this.sprints.length).toFixed(1);

        if (this.sprints.length >= 2) {
            const halfLen = Math.floor(this.sprints.length / 2);
            const firstHalf = this.sprints.slice(0, halfLen).reduce((sum, s) => sum + Number(s.points), 0) / halfLen;
            const secondHalf = this.sprints.slice(halfLen).reduce((sum, s) => sum + Number(s.points), 0) / (this.sprints.length - halfLen);
            this.trend = (((secondHalf - firstHalf) / firstHalf) * 100).toFixed(1);
        }

        this.forecastPoints = Math.round(this.avgVelocity * 6);
    },

    addSprint() {
        const nextNum = this.sprints.length + 1;
        this.sprints.push({ name: 'Sprint ' + nextNum, points: Math.round(this.avgVelocity) || 20 });
        this.calculate();
    },

    removeSprint(index) {
        if (this.sprints.length > 2) {
            this.sprints.splice(index, 1);
            this.calculate();
        }
    },

    getMaxPoints() {
        return Math.max(...this.sprints.map(s => Number(s.points)), 1);
    },

    loadExample() {
        this.sprints = [
            { name: 'Sprint 1', points: 24 },
            { name: 'Sprint 2', points: 28 },
            { name: 'Sprint 3', points: 22 },
            { name: 'Sprint 4', points: 26 },
            { name: 'Sprint 5', points: 30 }
        ];
        this.sprintLength = 2;
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`Velocity Calculator Results\nAverage Velocity: ${this.avgVelocity} points/sprint\nTrend: ${this.trend >= 0 ? '+' : ''}${this.trend}%\n3-Month Forecast: ${this.forecastPoints} points`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Sprint Data Entry -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <h4 class="font-bold text-slate-800">Sprint History</h4>
                <button @click="addSprint()"
                    class="text-sm font-medium text-sky-600 hover:text-sky-700 cursor-pointer flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Sprint
                </button>
            </div>

            <div class="space-y-3 max-h-80 overflow-y-auto">
                <template x-for="(sprint, index) in sprints" :key="index">
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl">
                        <input type="text" x-model="sprint.name"
                            class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-sky-500"
                            placeholder="Sprint name">
                        <div class="flex items-center gap-2">
                            <input type="number" x-model="sprint.points" @input="calculate()"
                                class="w-20 px-3 py-2 rounded-lg border border-slate-200 text-sm font-mono text-center focus:border-sky-500"
                                min="0" placeholder="0">
                            <span class="text-xs text-slate-500">pts</span>
                        </div>
                        <button @click="removeSprint(index)" x-show="sprints.length > 2"
                            class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Sprint Length -->
            <div class="pt-4 border-t border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">Sprint Length (weeks)</label>
                <div class="flex gap-3">
                    <template x-for="weeks in [1, 2, 3, 4]" :key="weeks">
                        <button @click="sprintLength = weeks; calculate()"
                            class="flex-1 py-2.5 rounded-xl font-bold text-sm cursor-pointer transition-all"
                            :class="sprintLength === weeks ? 'bg-sky-600 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            x-text="weeks + 'w'"></button>
                    </template>
                </div>
            </div>

            <!-- Mini Chart -->
            <div class="bg-white rounded-xl p-5 border border-slate-200">
                <h4 class="text-sm font-bold text-slate-700 mb-4">Velocity Trend</h4>
                <div class="flex items-end gap-2 h-32">
                    <template x-for="(sprint, index) in sprints" :key="'bar-' + index">
                        <div class="flex-1 flex flex-col items-center">
                            <div class="text-xs font-mono text-slate-600 mb-1" x-text="sprint.points"></div>
                            <div class="w-full rounded-t-lg transition-all"
                                :class="index === sprints.length - 1 ? 'bg-sky-500' : 'bg-slate-300'"
                                :style="'height: ' + (sprint.points / getMaxPoints() * 100) + '%'"></div>
                        </div>
                    </template>
                </div>
                <div class="flex justify-between text-xs text-slate-400 mt-2">
                    <span x-text="sprints[0]?.name"></span>
                    <span x-text="sprints[sprints.length - 1]?.name"></span>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <!-- Main Velocity -->
            <div class="bg-gradient-to-br from-sky-500 to-blue-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Average Velocity</div>
                <div class="text-6xl font-bold mb-2" x-text="avgVelocity"></div>
                <div class="opacity-80">story points per sprint</div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center">
                    <div class="text-sm text-slate-500 mb-1">Trend</div>
                    <div class="text-2xl font-bold" :class="trend >= 0 ? 'text-emerald-600' : 'text-red-600'"
                        x-text="(trend >= 0 ? '↑ ' : '↓ ') + Math.abs(trend) + '%'"></div>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-200 text-center">
                    <div class="text-sm text-slate-500 mb-1">Total Completed</div>
                    <div class="text-2xl font-bold text-slate-900" x-text="totalPoints + ' pts'"></div>
                </div>
            </div>

            <!-- Forecast -->
            <div class="bg-sky-50 rounded-xl p-5 border border-sky-200">
                <h4 class="font-bold text-sky-800 mb-3">3-Month Forecast</h4>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-sky-600" x-text="forecastPoints"></span>
                    <span class="text-sky-600">story points</span>
                </div>
                <p class="text-sm text-sky-700 mt-2">
                    Based on <span class="font-bold" x-text="avgVelocity"></span> pts/sprint ×
                    <span class="font-bold">6 sprints</span> (<span x-text="sprintLength"></span>-week sprints)
                </p>
            </div>

            <!-- Stability Indicator -->
            <div class="bg-white rounded-xl p-4 border border-slate-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Velocity Stability</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold"
                        :class="{
                            'bg-emerald-100 text-emerald-700': Math.abs(trend) <= 10,
                            'bg-amber-100 text-amber-700': Math.abs(trend) > 10 && Math.abs(trend) <= 25,
                            'bg-red-100 text-red-700': Math.abs(trend) > 25
                        }"
                        x-text="Math.abs(trend) <= 10 ? 'Stable' : (Math.abs(trend) <= 25 ? 'Variable' : 'Volatile')"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-sky-50 rounded-xl p-4 border border-sky-100 flex-1">
            <div class="text-sm text-sky-800">
                <strong>Velocity:</strong> Average story points completed per sprint. Use for capacity planning.
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
