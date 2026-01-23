<div x-data="{
    step: 1,
    calculationMethod: 'bottom-up',

    // TAM Inputs
    tam_customers: 1000000,
    tam_revenue_per_customer: 1200,
    tam_market_growth: 10,
    tam_years: 5,
    tam: 0,
    projected_tam: 0,

    // SAM Inputs
    sam_geo_reach: 20,
    sam_target_segment: 30,
    sam_regulatory: 90,
    sam_tech_feasibility: 85,
    sam_language: 100,
    sam_payment: 95,
    sam: 0,
    sam_cagr: 10,

    // SOM Inputs
    som_market_share: 5,
    som_years_to_reach: 5,
    som_competition: 'medium', // low, medium, high, vhigh
    som_maturity: 'growing', // nascent, growing, mature, declining
    som_gtm_readiness: 60,
    som_product_readiness: 70,
    som_funding: 80,
    som: 0,
    som_percentage_of_tam: 0,

    init() {
        this.calculate();
    },

    calculate() {
        // TAM Calculation
        if (this.calculationMethod === 'bottom-up') {
            this.tam = this.tam_customers * this.tam_revenue_per_customer;
        } else {
            // Placeholder for Top-Down logic
            this.tam = this.tam_customers * this.tam_revenue_per_customer;
        }

        // Projected TAM (Future Value formula: PV * (1 + r)^n)
        this.projected_tam = this.tam * Math.pow((1 + (this.tam_market_growth / 100)), this.tam_years);

        // SAM Calculation
        let sam_factor = (this.sam_geo_reach / 100) *
            (this.sam_target_segment / 100) *
            (this.sam_regulatory / 100) *
            (this.sam_tech_feasibility / 100);

        this.sam = this.tam * sam_factor;
        this.sam_cagr = this.tam_market_growth;

        // SOM Calculation
        this.som = this.sam * (this.som_market_share / 100);

        this.som_percentage_of_tam = (this.som / this.tam) * 100;
    },

    nextStep() {
        this.calculate();
        if (this.step < 4) this.step++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    prevStep() {
        if (this.step > 1) this.step--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    formatCurrency(value) {
        if (value >= 1000000000) return '$' + (value / 1000000000).toFixed(1) + 'B';
        if (value >= 1000000) return '$' + (value / 1000000).toFixed(1) + 'M';
        if (value >= 1000) return '$' + (value / 1000).toFixed(1) + 'K';
        return '$' + Math.round(value).toLocaleString();
    },

    formatNumber(value) {
        return Math.round(value).toLocaleString();
    }
}" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- Main Calculator Section (8 cols) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Progress Stepper -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                <div class="relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-100 rounded-full -z-10">
                    </div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-teal-500 rounded-full -z-10 transition-all duration-300"
                        :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>

                    <div class="flex justify-between">
                        <template x-for="(label, index) in ['TAM', 'SAM', 'SOM', 'Results']">
                            <div class="flex flex-col items-center gap-2 cursor-pointer group"
                                @click="if(step > index + 1) step = index + 1">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all relative transform group-hover:scale-110"
                                    :class="step > index + 1 ?
                                        'border-teal-500 bg-teal-500 text-white shadow-lg shadow-teal-500/30' : (
                                            step === index + 1 ?
                                            'border-teal-500 text-teal-600 bg-white ring-2 ring-teal-500/20' :
                                            'border-slate-200 text-slate-400 bg-white')">
                                    <span x-show="step <= index + 1" x-text="index + 1"></span>
                                    <i x-show="step > index + 1" class="fas fa-check text-xs"></i>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider transition-colors"
                                    :class="step >= index + 1 ? 'text-teal-700' : 'text-slate-400'"
                                    x-text="label"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Step 1: TAM -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-level-2">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                            <span
                                class="w-10 h-10 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center">
                                <i class="fas fa-globe"></i>
                            </span>
                            Total Addressable Market
                        </h2>
                        <p class="text-slate-500 mt-2 text-sm max-w-2xl">Calculates the total possible demand for your
                            product or service, assuming 100% market share.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-4">Methodology</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <label
                                        class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50"
                                        :class="calculationMethod === 'bottom-up' ?
                                            'border-teal-500 bg-teal-50/50 ring-1 ring-teal-500/20' : 'border-slate-200'">
                                        <input type="radio" name="method" value="bottom-up"
                                            x-model="calculationMethod" class="sr-only">
                                        <span class="flex-1">
                                            <span class="block text-sm font-bold text-slate-900">Bottom-Up</span>
                                            <span class="block text-xs text-slate-500 mt-1">Based on customers &
                                                pricing</span>
                                        </span>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                            :class="calculationMethod === 'bottom-up' ? 'border-teal-500' : 'border-slate-300'">
                                            <div class="w-2.5 h-2.5 rounded-full bg-teal-500 transition-transform scale-0"
                                                :class="calculationMethod === 'bottom-up' && 'scale-100'"></div>
                                        </div>
                                    </label>

                                    <label
                                        class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all hover:bg-slate-50"
                                        :class="calculationMethod === 'top-down' ?
                                            'border-teal-500 bg-teal-50/50 ring-1 ring-teal-500/20' : 'border-slate-200'">
                                        <input type="radio" name="method" value="top-down"
                                            x-model="calculationMethod" class="sr-only">
                                        <span class="flex-1">
                                            <span class="block text-sm font-bold text-slate-900">Top-Down</span>
                                            <span class="block text-xs text-slate-500 mt-1">Based on industry
                                                reports</span>
                                        </span>
                                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                            :class="calculationMethod === 'top-down' ? 'border-teal-500' : 'border-slate-300'">
                                            <div class="w-2.5 h-2.5 rounded-full bg-teal-500 transition-transform scale-0"
                                                :class="calculationMethod === 'top-down' && 'scale-100'"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Annual Revenue per
                                    Customer</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold">$</span>
                                    </div>
                                    <input type="number" x-model="tam_revenue_per_customer"
                                        class="w-full pl-8 pr-4 py-3.5 rounded-xl border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all font-mono text-slate-900 font-medium placeholder:text-slate-300 shadow-sm"
                                        placeholder="1200">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Total Potential
                                    Customers</label>
                                <input type="number" x-model="tam_customers"
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all font-mono text-slate-900 font-medium placeholder:text-slate-300 shadow-sm"
                                    placeholder="1000000">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Market Growth</label>
                                    <div class="relative">
                                        <input type="number" x-model="tam_market_growth"
                                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all font-mono text-slate-900 font-medium placeholder:text-slate-300 shadow-sm"
                                            placeholder="10">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-slate-400 font-bold">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Time (Years)</label>
                                    <input type="number" x-model="tam_years"
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all font-mono text-slate-900 font-medium placeholder:text-slate-300 shadow-sm"
                                        placeholder="5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end border-t border-slate-100 pt-6">
                        <button @click="nextStep()"
                            class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 hover:-translate-y-0.5 transition-all shadow-lg shadow-slate-900/20">
                            Next: Calculate SAM
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: SAM -->
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;">
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-level-2">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                            <span
                                class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <i class="fas fa-bullseye"></i>
                            </span>
                            Serviceable Available Market
                        </h2>
                        <p class="text-slate-500 mt-2 text-sm max-w-2xl">Subset of TAM constrained by geography,
                            regulations, or technology.</p>
                    </div>

                    <!-- Live Summary -->
                    <div class="bg-slate-50 rounded-xl p-6 mb-8 border border-slate-200/60">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Calculated
                                    TAM</p>
                                <p class="text-2xl font-bold text-slate-900" x-text="formatCurrency(tam)"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Projected
                                    (<span x-text="tam_years"></span>y)</p>
                                <p class="text-2xl font-bold text-slate-900" x-text="formatCurrency(projected_tam)">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-sm font-bold text-slate-700">Geographic Reach</label>
                                    <span class="text-sm font-mono font-bold text-indigo-600"
                                        x-text="sam_geo_reach + '%'"></span>
                                </div>
                                <input type="range" x-model="sam_geo_reach" min="0" max="100"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <p class="text-xs text-slate-400 mt-2">% of TAM available in your regions</p>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-sm font-bold text-slate-700">Regulatory Access</label>
                                    <span class="text-sm font-mono font-bold text-indigo-600"
                                        x-text="sam_regulatory + '%'"></span>
                                </div>
                                <input type="range" x-model="sam_regulatory" min="0" max="100"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <p class="text-xs text-slate-400 mt-2">% compliant with your legal constraints</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-sm font-bold text-slate-700">Target Segment Size</label>
                                    <span class="text-sm font-mono font-bold text-indigo-600"
                                        x-text="sam_target_segment + '%'"></span>
                                </div>
                                <input type="range" x-model="sam_target_segment" min="0" max="100"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <p class="text-xs text-slate-400 mt-2">% fitting your ideal customer profile</p>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <label class="text-sm font-bold text-slate-700">Tech Feasibility</label>
                                    <span class="text-sm font-mono font-bold text-indigo-600"
                                        x-text="sam_tech_feasibility + '%'"></span>
                                </div>
                                <input type="range" x-model="sam_tech_feasibility" min="0" max="100"
                                    class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <p class="text-xs text-slate-400 mt-2">% you can technically serve today</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between border-t border-slate-100 pt-6">
                        <button @click="prevStep()"
                            class="px-6 py-3 text-slate-600 font-bold hover:text-slate-900 transition-colors">
                            Back
                        </button>
                        <button @click="nextStep()"
                            class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 hover:-translate-y-0.5 transition-all shadow-lg shadow-slate-900/20">
                            Next: Calculate SOM
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 3: SOM -->
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;">
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-level-2">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                            <span
                                class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <i class="fas fa-flag"></i>
                            </span>
                            Serviceable Obtainable Market
                        </h2>
                        <p class="text-slate-500 mt-2 text-sm max-w-2xl">Realistic market share you can capture from
                            SAM based on competition and resources.</p>
                    </div>

                    <!-- Live Summary -->
                    <div
                        class="bg-slate-50 rounded-xl p-6 mb-8 border border-slate-200/60 flex flex-wrap gap-6 items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Calculated SAM
                            </p>
                            <p class="text-2xl font-bold text-slate-900" x-text="formatCurrency(sam)"></p>
                        </div>
                        <div class="bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                            <span class="text-sm text-slate-500 mr-2">SAM is</span>
                            <span class="text-lg font-bold text-indigo-600"
                                x-text="((sam/tam)*100).toFixed(1) + '%'"></span>
                            <span class="text-sm text-slate-500 ml-2">of TAM</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Target Market Share</label>
                                <div class="relative">
                                    <input type="number" x-model="som_market_share"
                                        class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all font-mono text-slate-900 font-medium placeholder:text-slate-300 shadow-sm"
                                        placeholder="5">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold">%</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Time to Reach
                                    (Years)</label>
                                <input type="number" x-model="som_years_to_reach"
                                    class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all font-mono text-slate-900 font-medium placeholder:text-slate-300 shadow-sm"
                                    placeholder="3">
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3">Competition Level</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="level in ['low', 'medium', 'high']">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="competition" :value="level"
                                                x-model="som_competition" class="sr-only peer">
                                            <div class="py-3 px-2 rounded-xl border text-center transition-all capitalize text-sm font-bold"
                                                :class="som_competition === level ?
                                                    'bg-emerald-50 border-emerald-500 text-emerald-700 ring-1 ring-emerald-500/20' :
                                                    'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                                                <span x-text="level"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3">Market Maturity</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <template x-for="stage in ['nascent', 'growing', 'mature']">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="maturity" :value="stage"
                                                x-model="som_maturity" class="sr-only peer">
                                            <div class="py-3 px-2 rounded-xl border text-center transition-all capitalize text-sm font-bold"
                                                :class="som_maturity === stage ?
                                                    'bg-emerald-50 border-emerald-500 text-emerald-700 ring-1 ring-emerald-500/20' :
                                                    'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                                                <span x-text="stage"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between border-t border-slate-100 pt-6">
                        <button @click="prevStep()"
                            class="px-6 py-3 text-slate-600 font-bold hover:text-slate-900 transition-colors">
                            Back
                        </button>
                        <button @click="nextStep()"
                            class="inline-flex items-center gap-2 px-8 py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 hover:-translate-y-0.5 transition-all shadow-lg shadow-slate-900/20">
                            See Final Results
                            <i class="fas fa-chart-pie"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 4: Results -->
            <div x-show="step === 4" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;">

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- TAM -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-100 shadow-level-1 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <i class="fas fa-globe text-6xl text-slate-900"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Total Market (TAM)
                        </p>
                        <p class="text-3xl font-bold text-slate-900 tracking-tight" x-text="formatCurrency(tam)"></p>
                        <div
                            class="mt-4 flex items-center text-xs font-medium text-emerald-600 bg-emerald-50 w-fit px-2 py-1 rounded">
                            <i class="fas fa-chart-line mr-1"></i>
                            <span x-text="tam_market_growth + '% Annual Growth'"></span>
                        </div>
                    </div>

                    <!-- SAM -->
                    <div
                        class="bg-white p-6 rounded-2xl border border-slate-100 shadow-level-1 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <i class="fas fa-bullseye text-6xl text-indigo-600"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Serviceable (SAM)</p>
                        <p class="text-3xl font-bold text-indigo-600 tracking-tight" x-text="formatCurrency(sam)"></p>
                        <p class="mt-4 text-xs font-bold text-slate-400">
                            <span x-text="((sam/tam)*100).toFixed(1) + '%'"></span> of TAM
                        </p>
                    </div>

                    <!-- SOM -->
                    <div
                        class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-level-2 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <i class="fas fa-flag text-6xl text-white"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Target (SOM)</p>
                        <p class="text-3xl font-bold text-white tracking-tight" x-text="formatCurrency(som)"></p>
                        <p class="mt-4 text-xs font-bold text-slate-500">
                            <span x-text="((som/sam)*100).toFixed(1) + '%'"></span> of SAM
                        </p>
                    </div>
                </div>

                <!-- Guidance Section -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                            <i class="fas fa-lightbulb text-amber-400"></i>
                            Strategic Analysis
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Market
                                Opportunity</h4>
                            <ul class="space-y-4">
                                <!-- TAM Insights -->
                                <li class="flex gap-3 text-sm">
                                    <div class="mt-1">
                                        <i class="fas fa-circle text-[6px]"
                                            :class="tam > 100000000 ? 'text-emerald-500' : 'text-amber-500'"></i>
                                    </div>
                                    <span class="text-slate-600">
                                        <strong class="text-slate-900"
                                            x-text="tam > 100000000 ? 'Venture Scale:' : 'Niche Market:'"></strong>
                                        <span
                                            x-text="tam > 100000000 ? 'Market size supports VC investment and high-growth trajectory.' : 'Focus on high margins; market size implies a specialized or lifestyle business model.'"></span>
                                    </span>
                                </li>
                                <!-- SOM Insights -->
                                <li class="flex gap-3 text-sm">
                                    <div class="mt-1">
                                        <i class="fas fa-circle text-[6px]"
                                            :class="((som / sam) * 100) < 20 ? 'text-emerald-500' : 'text-red-500'"></i>
                                    </div>
                                    <span class="text-slate-600">
                                        <strong class="text-slate-900">Market Share Goal:</strong>
                                        <span
                                            x-text="((som/sam)*100) < 20 ? 'Realistic target (<20% of SAM). Achievable with focused execution.' : 'Aggressive target (>20% of SAM). Requires significant competitive advantage.'"></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Execution Risk
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1">
                                        <span class="text-slate-600">Competition</span>
                                        <span class="capitalize"
                                            :class="{
                                                'text-emerald-600': som_competition === 'low',
                                                'text-amber-600': som_competition === 'medium',
                                                'text-red-600': som_competition === 'high'
                                            }"
                                            x-text="som_competition"></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500"
                                            :class="{
                                                'bg-emerald-500 w-1/3': som_competition === 'low',
                                                'bg-amber-500 w-2/3': som_competition === 'medium',
                                                'bg-red-500 w-full': som_competition === 'high'
                                            }">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs font-bold mb-1">
                                        <span class="text-slate-600">Market Readiness</span>
                                        <span class="capitalize text-slate-900" x-text="som_maturity"></span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500 bg-blue-500"
                                            :class="{
                                                'w-1/3': som_maturity === 'nascent',
                                                'w-2/3': som_maturity === 'growing',
                                                'w-full': som_maturity === 'mature'
                                            }">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button @click="step = 1; window.scrollTo({top:0, behavior:'smooth'})"
                        class="text-slate-500 font-bold text-sm hover:text-slate-900 flex items-center gap-2 transition-colors">
                        <i class="fas fa-redo"></i>
                        Start New Analysis
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Sidebar: About -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-book-open text-teal-500"></i>
                    Tool Guide
                </h3>
                <div class="prose prose-sm prose-slate">
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">
                        The <strong>TAM SAM SOM</strong> framework helps you quantify your market opportunity. Investors
                        require this to validate the scale of your business.
                    </p>

                    <div class="space-y-4">
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <strong class="block text-slate-900 text-xs uppercase tracking-wider mb-1">TAM
                                (Total)</strong>
                            <p class="text-xs text-slate-500">Total revenue if you had 100% market share of every
                                possible customer.</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <strong class="block text-slate-900 text-xs uppercase tracking-wider mb-1">SAM
                                (Serviceable)</strong>
                            <p class="text-xs text-slate-500">The segment of TAM you can actually reach with your
                                business model.</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <strong class="block text-slate-900 text-xs uppercase tracking-wider mb-1">SOM
                                (Target)</strong>
                            <p class="text-xs text-slate-500">Your specific target for the next 3-5 years.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
