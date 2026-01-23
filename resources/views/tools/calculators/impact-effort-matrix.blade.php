<div x-data="{
    items: [
        { name: 'Quick Win Feature', impact: 8, effort: 2, quadrant: '' },
        { name: 'Major Project', impact: 9, effort: 9, quadrant: '' },
        { name: 'Fill-in Task', impact: 3, effort: 2, quadrant: '' },
        { name: 'Time Sink', impact: 2, effort: 8, quadrant: '' }
    ],

    quadrants: {
        'quick-win': { name: 'Quick Wins', color: 'emerald', icon: '🚀', description: 'High Impact, Low Effort - Do First!' },
        'major': { name: 'Major Projects', color: 'blue', icon: '📋', description: 'High Impact, High Effort - Plan Carefully' },
        'fill-in': { name: 'Fill-ins', color: 'amber', icon: '📝', description: 'Low Impact, Low Effort - Do When Free' },
        'avoid': { name: 'Time Sinks', color: 'red', icon: '⚠️', description: 'Low Impact, High Effort - Avoid!' }
    },

    calculate() {
        this.items.forEach(item => {
            if (item.impact >= 5 && item.effort < 5) {
                item.quadrant = 'quick-win';
            } else if (item.impact >= 5 && item.effort >= 5) {
                item.quadrant = 'major';
            } else if (item.impact < 5 && item.effort < 5) {
                item.quadrant = 'fill-in';
            } else {
                item.quadrant = 'avoid';
            }
        });
    },

    addItem() {
        this.items.push({ name: 'New Item', impact: 5, effort: 5, quadrant: '' });
        this.calculate();
    },

    removeItem(index) {
        if (this.items.length > 1) {
            this.items.splice(index, 1);
            this.calculate();
        }
    },

    getQuadrantItems(quadrant) {
        return this.items.filter(i => i.quadrant === quadrant);
    },

    loadExample() {
        this.items = [
            { name: 'Fix Checkout Bug', impact: 9, effort: 2, quadrant: '' },
            { name: 'AI Feature', impact: 8, effort: 9, quadrant: '' },
            { name: 'Update FAQ', impact: 3, effort: 1, quadrant: '' },
            { name: 'Legacy Migration', impact: 2, effort: 8, quadrant: '' },
            { name: 'Add Dark Mode', impact: 6, effort: 3, quadrant: '' }
        ];
        this.calculate();
    },

    copyResults() {
        let text = 'Impact/Effort Matrix Results:\\n\\n';
        Object.keys(this.quadrants).forEach(q => {
            const items = this.getQuadrantItems(q);
            if (items.length) {
                text += `${this.quadrants[q].name}:\\n`;
                items.forEach(i => text += `  - ${i.name}\\n`);
                text += '\\n';
            }
        });
        navigator.clipboard.writeText(text);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-6">

    <!-- Items Input -->
    <div class="space-y-3">
        <template x-for="(item, index) in items" :key="index">
            <div class="bg-white rounded-xl border border-slate-200 p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <!-- Quadrant Badge -->
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl shrink-0"
                        :class="{
                            'bg-emerald-100': item.quadrant === 'quick-win',
                            'bg-blue-100': item.quadrant === 'major',
                            'bg-amber-100': item.quadrant === 'fill-in',
                            'bg-red-100': item.quadrant === 'avoid'
                        }"
                        x-text="quadrants[item.quadrant]?.icon || '○'">
                    </div>

                    <!-- Item Name -->
                    <input type="text" x-model="item.name"
                        class="flex-1 px-3 py-2 rounded-lg border border-slate-200 font-medium focus:border-violet-500"
                        placeholder="Item name">

                    <!-- Impact Slider -->
                    <div class="w-32">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500">Impact</span>
                            <span class="font-bold text-violet-600" x-text="item.impact"></span>
                        </div>
                        <input type="range" x-model="item.impact" @input="calculate()" min="1" max="10"
                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-violet-600">
                    </div>

                    <!-- Effort Slider -->
                    <div class="w-32">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500">Effort</span>
                            <span class="font-bold text-violet-600" x-text="item.effort"></span>
                        </div>
                        <input type="range" x-model="item.effort" @input="calculate()" min="1" max="10"
                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-violet-600">
                    </div>

                    <button @click="removeItem(index)" x-show="items.length > 1"
                        class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Add Item Button -->
    <button @click="addItem()"
        class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-violet-400 hover:text-violet-600 transition-colors cursor-pointer flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Item
    </button>

    <!-- 2x2 Matrix Visualization -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Quick Wins -->
        <div class="bg-emerald-50 rounded-xl p-4 border-2 border-emerald-200 min-h-[150px]">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">🚀</span>
                <h4 class="font-bold text-emerald-800">Quick Wins</h4>
            </div>
            <p class="text-xs text-emerald-600 mb-3">High Impact, Low Effort</p>
            <div class="space-y-2">
                <template x-for="item in getQuadrantItems('quick-win')" :key="'qw-' + item.name">
                    <div class="bg-white rounded-lg px-3 py-2 text-sm font-medium text-emerald-700 border border-emerald-200"
                        x-text="item.name"></div>
                </template>
            </div>
        </div>

        <!-- Major Projects -->
        <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200 min-h-[150px]">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">📋</span>
                <h4 class="font-bold text-blue-800">Major Projects</h4>
            </div>
            <p class="text-xs text-blue-600 mb-3">High Impact, High Effort</p>
            <div class="space-y-2">
                <template x-for="item in getQuadrantItems('major')" :key="'mp-' + item.name">
                    <div class="bg-white rounded-lg px-3 py-2 text-sm font-medium text-blue-700 border border-blue-200"
                        x-text="item.name"></div>
                </template>
            </div>
        </div>

        <!-- Fill-ins -->
        <div class="bg-amber-50 rounded-xl p-4 border-2 border-amber-200 min-h-[150px]">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">📝</span>
                <h4 class="font-bold text-amber-800">Fill-ins</h4>
            </div>
            <p class="text-xs text-amber-600 mb-3">Low Impact, Low Effort</p>
            <div class="space-y-2">
                <template x-for="item in getQuadrantItems('fill-in')" :key="'fi-' + item.name">
                    <div class="bg-white rounded-lg px-3 py-2 text-sm font-medium text-amber-700 border border-amber-200"
                        x-text="item.name"></div>
                </template>
            </div>
        </div>

        <!-- Time Sinks -->
        <div class="bg-red-50 rounded-xl p-4 border-2 border-red-200 min-h-[150px]">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">⚠️</span>
                <h4 class="font-bold text-red-800">Time Sinks</h4>
            </div>
            <p class="text-xs text-red-600 mb-3">Low Impact, High Effort</p>
            <div class="space-y-2">
                <template x-for="item in getQuadrantItems('avoid')" :key="'ts-' + item.name">
                    <div class="bg-white rounded-lg px-3 py-2 text-sm font-medium text-red-700 border border-red-200"
                        x-text="item.name"></div>
                </template>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-violet-50 rounded-xl p-4 border border-violet-100 flex-1">
            <div class="text-sm text-violet-800">
                <strong>Priority Order:</strong> Quick Wins → Major Projects → Fill-ins → Avoid Time Sinks
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
