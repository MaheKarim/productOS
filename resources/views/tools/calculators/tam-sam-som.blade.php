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
            // Placeholder for Top-Down logic if we had inputs for it
            this.tam = this.tam_customers * this.tam_revenue_per_customer; // Default fallback
        }

        // Projected TAM (Future Value formula: PV * (1 + r)^n)
        this.projected_tam = this.tam * Math.pow((1 + (this.tam_market_growth / 100)), this.tam_years);

        // SAM Calculation
        // SAM is a subset of TAM based on constraints
        let sam_factor = (this.sam_geo_reach / 100) *
            (this.sam_target_segment / 100) *
            (this.sam_regulatory / 100) *
            (this.sam_tech_feasibility / 100);

        // Optional factors could be added here if non-100 defaults meant constraints

        this.sam = this.tam * sam_factor;
        this.sam_cagr = this.tam_market_growth; // Assuming same growth rate for simplification

        // SOM Calculation
        // SOM is capturing a % of SAM
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
}" class="space-y-8">

    <!-- Progress Stepper -->
    <div class="relative">
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-100 rounded-full -z-10"></div>
        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-blue-500 rounded-full -z-10 transition-all duration-300"
            :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>

        <div class="flex justify-between">
            <template x-for="(label, index) in ['TAM', 'SAM', 'SOM', 'Results']">
                <div class="flex flex-col items-center gap-2 cursor-pointer"
                    @click="if(step > index + 1) step = index + 1">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors relative bg-white"
                        :class="step > index + 1 ? 'border-blue-500 bg-blue-500 text-white' : (step === index + 1 ?
                            'border-blue-500 text-blue-500' : 'border-slate-200 text-slate-400')">
                        <span x-show="step <= index + 1" x-text="index + 1"></span>
                        <svg x-show="step > index + 1" class="w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium" :class="step >= index + 1 ? 'text-blue-600' : 'text-slate-400'"
                        x-text="label"></span>
                </div>
            </template>
        </div>
    </div>

    <!-- Step 1: TAM -->
    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Total Addressable Market</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">TAM represents the total demand for your product or
                service. Choose between top-down (using existing market data) or bottom-up (calculating from customer
                numbers) approaches.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">Calculation Method <span
                                class="text-red-500">*</span></label>
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <div class="relative flex items-center mt-0.5">
                                    <input type="radio" name="method" value="top-down" x-model="calculationMethod"
                                        class="peer sr-only">
                                    <div
                                        class="w-5 h-5 border-2 border-slate-300 rounded-full peer-checked:border-blue-500 peer-checked:after:absolute peer-checked:after:w-2.5 peer-checked:after:h-2.5 peer-checked:after:bg-blue-500 peer-checked:after:rounded-full peer-checked:after:top-1 peer-checked:after:left-1 transition-all">
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="block text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Top-Down
                                        (Market Research)</span>
                                    <span class="block text-xs text-slate-500 mt-1 leading-relaxed">Use existing market
                                        research data from analysts like Gartner or IDC. Best when reliable industry
                                        reports are available.</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <div class="relative flex items-center mt-0.5">
                                    <input type="radio" name="method" value="bottom-up" x-model="calculationMethod"
                                        class="peer sr-only">
                                    <div
                                        class="w-5 h-5 border-2 border-slate-300 rounded-full peer-checked:border-blue-500 peer-checked:after:absolute peer-checked:after:w-2.5 peer-checked:after:h-2.5 peer-checked:after:bg-blue-500 peer-checked:after:rounded-full peer-checked:after:top-1 peer-checked:after:left-1 transition-all">
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="block text-sm font-bold text-slate-700 group-hover:text-blue-600 transition-colors">Bottom-Up
                                        (Customer Count)</span>
                                    <span class="block text-xs text-slate-500 mt-1 leading-relaxed">Calculate from your
                                        target customer segments and pricing. More accurate for new or niche
                                        markets.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Average Annual Revenue per Customer
                            <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <span
                                class="absolute left-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">$</span>
                            <input type="number" x-model="tam_revenue_per_customer"
                                class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="1200">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Number of Potential Customers <span
                                class="text-red-500">*</span></label>
                        <input type="number" x-model="tam_customers"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                            placeholder="1000000">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Market Growth Rate (%)</label>
                        <div class="relative group">
                            <input type="number" x-model="tam_market_growth"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="10">
                            <span
                                class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">%</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Time Horizon (years)</label>
                        <input type="number" x-model="tam_years"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                            placeholder="5">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button @click="nextStep()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10">
                    Next: Calculate SAM
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 2: SAM -->
    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
        style="display: none;">
        <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Serviceable Available Market</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">SAM represents the portion of TAM that your product
                can address given geographic, regulatory, and technical constraints.</p>

            <!-- Summary Card -->
            <div class="bg-slate-50 rounded-xl p-6 mb-8 border border-slate-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Current TAM</div>
                        <div class="text-2xl font-bold text-slate-900" x-text="formatCurrency(tam)"></div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Projected TAM
                            (<span x-text="tam_years"></span> yr)</div>
                        <div class="text-2xl font-bold text-slate-900" x-text="formatCurrency(projected_tam)"></div>
                    </div>
                    <div
                        class="flex items-center gap-2 text-sm text-slate-600 bg-white px-3 py-2 rounded-lg border border-slate-200">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span><span class="font-bold" x-text="tam_market_growth"></span>% CAGR</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Geographic Reach</label>
                        <div class="relative group">
                            <input type="number" x-model="sam_geo_reach"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="20">
                            <span
                                class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">%</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Regulatory Access</label>
                        <div class="relative group">
                            <input type="number" x-model="sam_regulatory"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="90">
                            <span
                                class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">%</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Segment Size</label>
                        <div class="relative group">
                            <input type="number" x-model="sam_target_segment"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="30">
                            <span
                                class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">%</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Technical Feasibility</label>
                        <div class="relative group">
                            <input type="number" x-model="sam_tech_feasibility"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="85">
                            <span
                                class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                <button @click="prevStep()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    Back
                </button>
                <button @click="nextStep()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10">
                    Next: Calculate SOM
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 3: SOM -->
    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
        style="display: none;">
        <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-2">Serviceable Obtainable Market</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">SOM represents the portion of SAM you can
                realistically capture given competition, market dynamics, and your execution capabilities.</p>

            <!-- Summary Card -->
            <div class="bg-slate-50 rounded-xl p-6 mb-8 border border-slate-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Calculated SAM
                        </div>
                        <div class="text-2xl font-bold text-slate-900" x-text="formatCurrency(sam)"></div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Excluded Market
                        </div>
                        <div class="text-2xl font-bold text-slate-400" x-text="formatCurrency(tam - sam)"></div>
                    </div>
                    <div class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg text-sm font-bold">
                        <span x-text="((sam/tam)*100).toFixed(1)"></span>% of TAM
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 mb-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Market Share</label>
                        <div class="relative group">
                            <input type="number" x-model="som_market_share"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                                placeholder="5">
                            <span
                                class="absolute right-4 top-3.5 text-slate-400 group-focus-within:text-blue-500 transition-colors">%</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">Competition Intensity</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="competition" value="low" x-model="som_competition"
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Low Competition</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="competition" value="medium" x-model="som_competition"
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Medium Competition</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="competition" value="high" x-model="som_competition"
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">High Competition</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Time to Reach Share (years)</label>
                        <input type="number" x-model="som_years_to_reach"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none font-mono text-slate-700 placeholder:text-slate-300"
                            placeholder="3">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3">Market Maturity</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="maturity" value="nascent" x-model="som_maturity"
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Nascent Market</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="maturity" value="growing" x-model="som_maturity"
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Growing Market</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="maturity" value="mature" x-model="som_maturity"
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-sm text-slate-700">Mature Market</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                <button @click="prevStep()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    Back
                </button>
                <button @click="nextStep()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10">
                    Complete Analysis
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 4: Results -->
    <div x-show="step === 4" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        style="display: none;">
        <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-8">Market Opportunity Funnel</h3>

            <!-- Funnel Visualization -->
            <div class="flex flex-col items-center mb-12">
                <!-- TAM Layer -->
                <div class="w-full max-w-lg relative mb-2">
                    <div
                        class="h-24 skew-x-[20deg] bg-blue-500 rounded-lg flex items-center justify-center shadow-lg relative z-30 transform hover:scale-105 transition-transform duration-300">
                        <span class="text-white font-bold text-xl skew-x-[-20deg]">TAM</span>
                    </div>
                </div>

                <!-- SAM Layer -->
                <div class="w-full max-w-md relative mb-2">
                    <div
                        class="h-24 skew-x-[20deg] bg-purple-500 rounded-lg flex items-center justify-center shadow-lg relative z-20 transform hover:scale-105 transition-transform duration-300">
                        <span class="text-white font-bold text-xl skew-x-[-20deg]">SAM</span>
                    </div>
                </div>

                <!-- SOM Layer -->
                <div class="w-full max-w-xs relative">
                    <div
                        class="h-24 skew-x-[20deg] bg-emerald-500 rounded-lg flex items-center justify-center shadow-lg relative z-10 transform hover:scale-105 transition-transform duration-300">
                        <span class="text-white font-bold text-xl skew-x-[-20deg]">SOM</span>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="p-6 rounded-2xl bg-white border border-slate-100 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="text-sm font-bold text-slate-400 mb-2">TAM</div>
                    <div class="text-3xl font-bold text-slate-900 mb-1" x-text="formatCurrency(tam)"></div>
                    <div class="text-xs text-slate-400">Total Market</div>
                </div>
                <div
                    class="p-6 rounded-2xl bg-white border border-slate-100 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="text-sm font-bold text-slate-400 mb-2">SAM</div>
                    <div class="text-3xl font-bold text-slate-900 mb-1" x-text="formatCurrency(sam)"></div>
                    <div class="text-xs text-blue-500 font-bold" x-text="((sam/tam)*100).toFixed(1) + '% of TAM'">
                    </div>
                </div>
                <div
                    class="p-6 rounded-2xl bg-blue-50 border border-blue-100 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="text-sm font-bold text-blue-400 mb-2">SOM</div>
                    <div class="text-3xl font-bold text-blue-900 mb-1" x-text="formatCurrency(som)"></div>
                    <div class="text-xs text-blue-500 font-bold" x-text="((som/tam)*100).toFixed(2) + '% of TAM'">
                    </div>
                </div>
            </div>

            <!-- Conversion Table -->
            <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 mb-12">
                <h4 class="font-bold text-slate-900 mb-4">Conversion Rates</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-slate-200 last:border-0">
                        <span class="text-slate-600 text-sm">TAM → SAM</span>
                        <span class="font-mono font-bold text-slate-900"
                            x-text="((sam/tam)*100).toFixed(1) + '%'"></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-200 last:border-0">
                        <span class="text-slate-600 text-sm">SAM → SOM</span>
                        <span class="font-mono font-bold text-slate-900"
                            x-text="((som/sam)*100).toFixed(1) + '%'"></span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-200 last:border-0">
                        <span class="text-slate-600 text-sm">TAM → SOM</span>
                        <span class="font-mono font-bold text-slate-900"
                            x-text="((som/tam)*100).toFixed(2) + '%'"></span>
                    </div>
                </div>
            </div>

            <!-- Dynamic Decision Guidance -->
            <section
                class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl shadow-xl p-8 relative overflow-hidden mb-8">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 blur-[120px] opacity-20"></div>
                <h2 class="text-2xl font-bold mb-8 flex items-center gap-3 relative z-10">
                    <span
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </span>
                    Strategic Guidance
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                    <div>
                        <h3 class="font-bold text-lg mb-4 text-slate-200">Recommended Actions</h3>
                        <ul class="space-y-4 text-slate-400 text-sm">

                            <!-- Low TAM Opportunity -->
                            <li class="flex gap-3" x-show="tam < 50000000">
                                <svg class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <span><strong>Niche Opportunity (TAM <$50M):< /strong> Focus on high margins and
                                            dominance. This market size may limit VC interest but is great for a
                                            lifestyle business.</span>
                            </li>

                            <!-- High TAM Opportunity -->
                            <li class="flex gap-3" x-show="tam >= 50000000">
                                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span><strong>Venture Scale (TAM >$50M):</strong> Market size is healthy for investment.
                                    Focus on executing your go-to-market strategy rapidly.</span>
                            </li>

                            <!-- Low SOM Capture -->
                            <li class="flex gap-3" x-show="((som/sam)*100) < 10">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span><strong>Growth Potential:</strong> You are targeting <10% of your SAM. Aggressive
                                        sales and marketing could yield significant upside.</span>
                            </li>

                            <!-- High SOM Capture (Unrealistic?) -->
                            <li class="flex gap-3" x-show="((som/sam)*100) > 30">
                                <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <span><strong>Aggressive Target:</strong> Aiming for >30% market share is ambitious.
                                    Ensure your competitive advantage is defensible.</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-4 text-slate-200">Investment Readiness</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-400">Market Attractiveness</span>
                                    <span class="font-mono text-white"
                                        x-text="tam > 100000000 ? 'High' : (tam > 10000000 ? 'Medium' : 'Niche')"></span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-emerald-400 to-blue-500 h-2 rounded-full transition-all duration-500"
                                        :style="'width: ' + (tam > 100000000 ? '90%' : (tam > 10000000 ? '50%' : '20%'))">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-400">Execution Difficulty</span>
                                    <span class="font-mono text-white"
                                        x-text="som_competition === 'low' ? 'Low' : (som_competition === 'medium' ? 'Medium' : 'High')"></span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-red-500 h-2 rounded-full transition-all duration-500"
                                        :style="'width: ' + (som_competition === 'low' ? '20%' : (
                                            som_competition === 'medium' ? '50%' : '90%'))">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-8 flex justify-between">
                <button @click="prevStep()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    Back to Adjust
                </button>
                <button @click="step = 1; window.scrollTo({top:0, behavior:'smooth'})"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors">
                    Start New Calculation
                </button>
            </div>
        </div>
    </div>
</div>
