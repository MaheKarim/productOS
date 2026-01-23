<div x-data="{
    tasks: [
        { name: 'User Story #101', startDate: '2026-01-10', endDate: '2026-01-14', cycleTime: 0 },
        { name: 'User Story #102', startDate: '2026-01-12', endDate: '2026-01-18', cycleTime: 0 },
        { name: 'Bug Fix #45', startDate: '2026-01-15', endDate: '2026-01-16', cycleTime: 0 }
    ],

    avgCycleTime: 0,
    minCycleTime: 0,
    maxCycleTime: 0,
    totalTasks: 0,

    calculate() {
        this.totalTasks = this.tasks.length;
        if (this.totalTasks === 0) return;

        this.tasks.forEach(task => {
            if (task.startDate && task.endDate) {
                const start = new Date(task.startDate);
                const end = new Date(task.endDate);
                task.cycleTime = Math.max(0, Math.ceil((end - start) / (1000 * 60 * 60 * 24)));
            }
        });

        const cycleTimes = this.tasks.map(t => t.cycleTime).filter(ct => ct > 0);
        if (cycleTimes.length > 0) {
            this.avgCycleTime = (cycleTimes.reduce((sum, ct) => sum + ct, 0) / cycleTimes.length).toFixed(1);
            this.minCycleTime = Math.min(...cycleTimes);
            this.maxCycleTime = Math.max(...cycleTimes);
        }
    },

    addTask() {
        const today = new Date().toISOString().split('T')[0];
        this.tasks.push({ name: 'New Task', startDate: today, endDate: today, cycleTime: 0 });
        this.calculate();
    },

    removeTask(index) {
        if (this.tasks.length > 1) {
            this.tasks.splice(index, 1);
            this.calculate();
        }
    },

    getCycleTimeHealth(days) {
        if (days <= 3) return { label: 'Fast', color: 'emerald' };
        if (days <= 7) return { label: 'Normal', color: 'blue' };
        if (days <= 14) return { label: 'Slow', color: 'amber' };
        return { label: 'Very Slow', color: 'red' };
    },

    loadExample() {
        this.tasks = [
            { name: 'User Story #101', startDate: '2026-01-10', endDate: '2026-01-14', cycleTime: 0 },
            { name: 'User Story #102', startDate: '2026-01-12', endDate: '2026-01-18', cycleTime: 0 },
            { name: 'Bug Fix #45', startDate: '2026-01-15', endDate: '2026-01-16', cycleTime: 0 },
            { name: 'Feature #23', startDate: '2026-01-08', endDate: '2026-01-15', cycleTime: 0 },
            { name: 'Refactor DB', startDate: '2026-01-05', endDate: '2026-01-12', cycleTime: 0 }
        ];
        this.calculate();
    },

    copyResults() {
        navigator.clipboard.writeText(`Cycle Time Analysis\nAverage: ${this.avgCycleTime} days\nMin: ${this.minCycleTime} days\nMax: ${this.maxCycleTime} days\nTasks Analyzed: ${this.totalTasks}`);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Task Entry -->
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <h4 class="font-bold text-slate-800">Task Data</h4>
                <button @click="addTask()"
                    class="text-sm font-medium text-cyan-600 hover:text-cyan-700 cursor-pointer flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Task
                </button>
            </div>

            <div class="space-y-3 max-h-96 overflow-y-auto">
                <template x-for="(task, index) in tasks" :key="index">
                    <div class="bg-white rounded-xl border border-slate-200 p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <input type="text" x-model="task.name"
                                class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-sm font-medium focus:border-cyan-500"
                                placeholder="Task name">
                            <span class="px-3 py-1 rounded-full text-xs font-bold"
                                :class="{
                                    'bg-emerald-100 text-emerald-700': getCycleTimeHealth(task.cycleTime)
                                        .color === 'emerald',
                                    'bg-blue-100 text-blue-700': getCycleTimeHealth(task.cycleTime)
                                        .color === 'blue',
                                    'bg-amber-100 text-amber-700': getCycleTimeHealth(task.cycleTime)
                                        .color === 'amber',
                                    'bg-red-100 text-red-700': getCycleTimeHealth(task.cycleTime).color === 'red'
                                }"
                                x-text="task.cycleTime + ' days'"></span>
                            <button @click="removeTask(index)" x-show="tasks.length > 1"
                                class="p-1.5 text-slate-400 hover:text-red-500 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Started</label>
                                <input type="date" x-model="task.startDate" @change="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-cyan-500">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Completed</label>
                                <input type="date" x-model="task.endDate" @change="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-cyan-500">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <!-- Main Result -->
            <div class="bg-gradient-to-br from-cyan-500 to-teal-600 rounded-2xl p-8 text-white text-center">
                <div class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Average Cycle Time</div>
                <div class="text-6xl font-bold mb-2" x-text="avgCycleTime"></div>
                <div class="opacity-80">days per task</div>
            </div>

            <!-- Min/Max Stats -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-4 border border-slate-200 text-center">
                    <div class="text-xs text-slate-500 uppercase mb-1">Fastest</div>
                    <div class="text-2xl font-bold text-emerald-600" x-text="minCycleTime + 'd'"></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-slate-200 text-center">
                    <div class="text-xs text-slate-500 uppercase mb-1">Average</div>
                    <div class="text-2xl font-bold text-cyan-600" x-text="avgCycleTime + 'd'"></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-slate-200 text-center">
                    <div class="text-xs text-slate-500 uppercase mb-1">Slowest</div>
                    <div class="text-2xl font-bold text-amber-600" x-text="maxCycleTime + 'd'"></div>
                </div>
            </div>

            <!-- Distribution Visual -->
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200">
                <h4 class="font-bold text-slate-800 mb-4">Cycle Time Distribution</h4>
                <div class="space-y-2">
                    <template x-for="(task, index) in tasks" :key="'dist-' + index">
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500 w-28 truncate" x-text="task.name"></span>
                            <div class="flex-1 h-4 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all"
                                    :class="{
                                        'bg-emerald-500': getCycleTimeHealth(task.cycleTime).color === 'emerald',
                                        'bg-blue-500': getCycleTimeHealth(task.cycleTime).color === 'blue',
                                        'bg-amber-500': getCycleTimeHealth(task.cycleTime).color === 'amber',
                                        'bg-red-500': getCycleTimeHealth(task.cycleTime).color === 'red'
                                    }"
                                    :style="'width: ' + Math.min(task.cycleTime / maxCycleTime * 100, 100) + '%'"></div>
                            </div>
                            <span class="text-xs font-mono font-bold w-8" x-text="task.cycleTime + 'd'"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Benchmarks -->
            <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-100">
                <div class="text-sm text-cyan-800">
                    <strong>Benchmarks:</strong> Fast teams: 1-3 days | Normal: 4-7 days | Slow: 8-14 days
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-100 flex-1">
            <div class="text-sm text-cyan-800">
                <strong>Cycle Time:</strong> Days from work started to work completed. Lower is better.
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-cyan-600 rounded-lg hover:bg-cyan-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
