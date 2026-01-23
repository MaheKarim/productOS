<div x-data="{
    features: [
        { name: 'Fast Loading', functional: 'like', dysfunctional: 'dislike', category: '' },
        { name: 'Dark Mode', functional: 'like', dysfunctional: 'neutral', category: '' }
    ],

    responses: ['like', 'expect', 'neutral', 'live_with', 'dislike'],
    responseLabels: {
        'like': 'I like it',
        'expect': 'I expect it',
        'neutral': 'Neutral',
        'live_with': 'I can live with it',
        'dislike': 'I dislike it'
    },

    kanoMatrix: {
        'like_dislike': 'Attractive',
        'like_live_with': 'Attractive',
        'like_neutral': 'Attractive',
        'like_expect': 'Indifferent',
        'like_like': 'Questionable',
        'expect_dislike': 'One-dimensional',
        'expect_live_with': 'Indifferent',
        'expect_neutral': 'Indifferent',
        'expect_expect': 'Indifferent',
        'expect_like': 'Reverse',
        'neutral_dislike': 'Must-be',
        'neutral_live_with': 'Indifferent',
        'neutral_neutral': 'Indifferent',
        'neutral_expect': 'Indifferent',
        'neutral_like': 'Reverse',
        'live_with_dislike': 'Must-be',
        'live_with_live_with': 'Indifferent',
        'live_with_neutral': 'Indifferent',
        'live_with_expect': 'Indifferent',
        'live_with_like': 'Reverse',
        'dislike_dislike': 'Questionable',
        'dislike_live_with': 'Reverse',
        'dislike_neutral': 'Reverse',
        'dislike_expect': 'Reverse',
        'dislike_like': 'Reverse'
    },

    categoryColors: {
        'Must-be': 'red',
        'One-dimensional': 'blue',
        'Attractive': 'emerald',
        'Indifferent': 'slate',
        'Reverse': 'amber',
        'Questionable': 'purple'
    },

    categoryDescriptions: {
        'Must-be': 'Basic expectations. Absence causes dissatisfaction.',
        'One-dimensional': 'More is better. Directly affects satisfaction.',
        'Attractive': 'Delighters. Unexpected features that wow users.',
        'Indifferent': 'Users don\'t care either way.',
        'Reverse': 'This feature may actually reduce satisfaction.',
        'Questionable': 'Contradictory response, review the question.'
    },

    calculate() {
        this.features.forEach(f => {
            const key = f.functional + '_' + f.dysfunctional;
            f.category = this.kanoMatrix[key] || 'Indifferent';
        });
    },

    addFeature() {
        this.features.push({ name: 'New Feature', functional: 'neutral', dysfunctional: 'neutral', category: '' });
        this.calculate();
    },

    removeFeature(index) {
        if (this.features.length > 1) {
            this.features.splice(index, 1);
        }
    },

    getCategoryCounts() {
        const counts = {};
        this.features.forEach(f => {
            counts[f.category] = (counts[f.category] || 0) + 1;
        });
        return counts;
    },

    loadExample() {
        this.features = [
            { name: 'Fast Loading', functional: 'expect', dysfunctional: 'dislike', category: '' },
            { name: 'Dark Mode', functional: 'like', dysfunctional: 'neutral', category: '' },
            { name: 'Data Encryption', functional: 'expect', dysfunctional: 'dislike', category: '' },
            { name: 'AI Assistant', functional: 'like', dysfunctional: 'live_with', category: '' },
            { name: 'Social Sharing', functional: 'neutral', dysfunctional: 'neutral', category: '' }
        ];
        this.calculate();
    },

    copyResults() {
        let text = 'Kano Analysis Results:\\n\\n';
        this.features.forEach(f => {
            text += `${f.name}: ${f.category}\\n`;
        });
        navigator.clipboard.writeText(text);
        alert('Copied!');
    }
}" x-init="calculate()" class="space-y-6">

    <!-- Legend -->
    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
        <h4 class="font-bold text-slate-800 mb-3">Kano Categories</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
            <template x-for="(desc, cat) in categoryDescriptions" :key="cat">
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 rounded-full shrink-0"
                        :class="{
                            'bg-red-500': categoryColors[cat] === 'red',
                            'bg-blue-500': categoryColors[cat] === 'blue',
                            'bg-emerald-500': categoryColors[cat] === 'emerald',
                            'bg-slate-400': categoryColors[cat] === 'slate',
                            'bg-amber-500': categoryColors[cat] === 'amber',
                            'bg-purple-500': categoryColors[cat] === 'purple'
                        }"></span>
                    <span class="font-medium text-slate-700" x-text="cat"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Features List -->
    <div class="space-y-4">
        <template x-for="(feature, index) in features" :key="index">
            <div class="bg-white rounded-xl border border-slate-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    <div class="flex-1 space-y-4">
                        <!-- Feature Name -->
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="feature.name"
                                class="flex-1 px-3 py-2 rounded-lg border border-slate-200 font-medium focus:border-indigo-500"
                                placeholder="Feature name">
                            <button @click="removeFeature(index)" x-show="features.length > 1"
                                class="p-2 text-slate-400 hover:text-red-500 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Questions -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                                <label class="block text-sm font-bold text-emerald-700 mb-2">
                                    If this feature is present...
                                </label>
                                <select x-model="feature.functional" @change="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-emerald-200 text-sm focus:border-emerald-500 bg-white">
                                    <template x-for="resp in responses" :key="'f-' + resp">
                                        <option :value="resp" x-text="responseLabels[resp]"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                                <label class="block text-sm font-bold text-red-700 mb-2">
                                    If this feature is absent...
                                </label>
                                <select x-model="feature.dysfunctional" @change="calculate()"
                                    class="w-full px-3 py-2 rounded-lg border border-red-200 text-sm focus:border-red-500 bg-white">
                                    <template x-for="resp in responses" :key="'d-' + resp">
                                        <option :value="resp" x-text="responseLabels[resp]"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Category Badge -->
                    <div class="text-center px-4 py-3 rounded-xl min-w-[120px]"
                        :class="{
                            'bg-red-100 text-red-700': categoryColors[feature.category] === 'red',
                            'bg-blue-100 text-blue-700': categoryColors[feature.category] === 'blue',
                            'bg-emerald-100 text-emerald-700': categoryColors[feature.category] === 'emerald',
                            'bg-slate-100 text-slate-600': categoryColors[feature.category] === 'slate',
                            'bg-amber-100 text-amber-700': categoryColors[feature.category] === 'amber',
                            'bg-purple-100 text-purple-700': categoryColors[feature.category] === 'purple'
                        }">
                        <div class="text-sm font-bold" x-text="feature.category"></div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Add Feature Button -->
    <button @click="addFeature()"
        class="w-full py-3 border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-medium hover:border-indigo-400 hover:text-indigo-600 transition-colors cursor-pointer flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Feature
    </button>

    <!-- Summary -->
    <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100">
        <h4 class="font-bold text-indigo-900 mb-4">Category Summary</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <template x-for="(count, cat) in getCategoryCounts()" :key="'sum-' + cat">
                <div class="bg-white rounded-lg p-3 border border-indigo-200 flex items-center justify-between">
                    <span class="font-medium text-indigo-800" x-text="cat"></span>
                    <span class="text-lg font-bold text-indigo-600" x-text="count"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 items-start justify-between">
        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100 flex-1">
            <div class="text-sm text-indigo-800">
                <strong>Kano Model:</strong> Categorizes features based on customer satisfaction impact using
                functional/dysfunctional questions.
            </div>
        </div>
        <div class="flex gap-2">
            <button @click="loadExample()"
                class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer">Load
                Example</button>
            <button @click="copyResults()"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 cursor-pointer">Copy
                Results</button>
        </div>
    </div>
</div>
