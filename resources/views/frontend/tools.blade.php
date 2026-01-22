@extends('frontend.layout')

@section('title', 'Product Manager Toolkit')

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 px-4 md:px-8 overflow-hidden bg-white">
        {{-- Dynamic Background --}}
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-br from-teal-100/40 to-primary/20 rounded-full blur-3xl opacity-60 -translate-y-1/2 translate-x-1/3 animate-pulse-slow">
        </div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-accent/10 rounded-full blur-3xl opacity-40 translate-y-1/3 -translate-x-1/4 animate-pulse-slow"
            style="animation-delay: 1s;"></div>

        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="text-center animate-fade-in-up">
                <span
                    class="inline-block py-2 px-4 rounded-full bg-teal-50 text-teal-600 text-sm font-semibold mb-6 border border-teal-100">
                    <i class="fa-solid fa-toolbox mr-2"></i>Free PM Tools
                </span>
                <h1 class="text-4xl md:text-6xl font-bold text-teal-900 leading-tight mb-6">
                    Product Manager<br><span class="text-primary">Toolkit</span>
                </h1>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed mb-8">
                    Interactive calculators and frameworks I use daily to make data-driven product decisions.
                    <span class="text-primary font-semibold">100% free for you.</span>
                </p>

                {{-- Quick Navigation --}}
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="#cac-calculator"
                        class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-medium hover:bg-blue-100 transition-colors cursor-pointer">
                        <i class="fa-solid fa-chart-pie mr-2"></i>CAC Calculator
                    </a>
                    <a href="#ltv-calculator"
                        class="inline-flex items-center px-4 py-2 bg-purple-50 text-purple-600 rounded-full text-sm font-medium hover:bg-purple-100 transition-colors cursor-pointer">
                        <i class="fa-solid fa-infinity mr-2"></i>LTV/CAC Model
                    </a>
                    <a href="#rice-framework"
                        class="inline-flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-full text-sm font-medium hover:bg-teal-100 transition-colors cursor-pointer">
                        <i class="fa-solid fa-list-check mr-2"></i>RICE Framework
                    </a>
                    <a href="#churn-calculator"
                        class="inline-flex items-center px-4 py-2 bg-orange-50 text-orange-600 rounded-full text-sm font-medium hover:bg-orange-100 transition-colors cursor-pointer">
                        <i class="fa-solid fa-arrow-trend-down mr-2"></i>Churn Rate
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CAC Calculator Section --}}
    <section id="cac-calculator" class="py-20 px-4 md:px-8 bg-gradient-to-b from-white to-slate-50">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Info Column --}}
                <div class="animate-fade-in-up">
                    <div
                        class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold mb-4">
                        <i class="fa-solid fa-star mr-1"></i>Most Popular
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-900 mb-4">
                        Customer Acquisition Cost <span class="text-blue-500">(CAC)</span>
                    </h2>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Calculate how much you're spending to acquire each new customer. Essential for understanding your
                        unit economics and optimizing marketing spend.
                    </p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-lightbulb text-blue-500 text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-teal-900">Why it matters</div>
                                <p class="text-sm text-slate-600">If CAC exceeds customer LTV, you're losing money on every
                                    acquisition.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-bullseye text-blue-500 text-sm"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-teal-900">Target benchmark</div>
                                <p class="text-sm text-slate-600">SaaS: LTV/CAC ratio of 3:1 or higher is considered
                                    healthy.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="text-sm font-semibold text-blue-800 mb-2">
                            <i class="fa-solid fa-calculator mr-2"></i>Formula
                        </div>
                        <code class="text-sm text-blue-700 font-mono">
                            CAC = (Marketing Costs + Sales Costs) / New Customers Acquired
                        </code>
                    </div>
                </div>

                {{-- Calculator Column --}}
                <div class="glass p-8 rounded-3xl shadow-glass" id="cac-calculator-form">
                    <h3 class="text-xl font-bold text-teal-900 mb-6">
                        <i class="fa-solid fa-chart-pie text-blue-500 mr-2"></i>CAC Calculator
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label for="cac-marketing" class="block text-sm font-semibold text-slate-700 mb-2">
                                Marketing Spend ($)
                            </label>
                            <input type="number" id="cac-marketing" inputmode="numeric"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-text"
                                placeholder="e.g., 50000" value="50000">
                        </div>

                        <div>
                            <label for="cac-sales" class="block text-sm font-semibold text-slate-700 mb-2">
                                Sales & BD Costs ($)
                            </label>
                            <input type="number" id="cac-sales" inputmode="numeric"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-text"
                                placeholder="e.g., 30000" value="30000">
                        </div>

                        <div>
                            <label for="cac-customers" class="block text-sm font-semibold text-slate-700 mb-2">
                                New Customers Acquired
                            </label>
                            <input type="number" id="cac-customers" inputmode="numeric"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-text"
                                placeholder="e.g., 200" value="200">
                        </div>

                        <button onclick="calculateCAC()"
                            class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                            <i class="fa-solid fa-calculator mr-2"></i>Calculate CAC
                        </button>

                        <div id="cac-result"
                            class="hidden p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border border-blue-200">
                            <div class="text-sm font-semibold text-blue-600 mb-2">Your CAC is</div>
                            <div class="text-4xl font-bold text-blue-700 mb-3" id="cac-value">$0</div>
                            <div class="text-sm text-slate-600" id="cac-interpretation"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LTV/CAC Calculator Section --}}
    <section id="ltv-calculator" class="py-20 px-4 md:px-8 bg-white">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Calculator Column (Left this time) --}}
                <div class="glass p-8 rounded-3xl shadow-glass order-2 lg:order-1" id="ltv-calculator-form">
                    <h3 class="text-xl font-bold text-teal-900 mb-6">
                        <i class="fa-solid fa-infinity text-purple-500 mr-2"></i>LTV/CAC Calculator
                    </h3>

                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="ltv-arpu" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Monthly ARPU ($)
                                </label>
                                <input type="number" id="ltv-arpu" inputmode="numeric"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all cursor-text"
                                    placeholder="e.g., 99" value="99">
                            </div>
                            <div>
                                <label for="ltv-margin" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Gross Margin (%)
                                </label>
                                <input type="number" id="ltv-margin" inputmode="numeric" min="0" max="100"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all cursor-text"
                                    placeholder="e.g., 70" value="70">
                            </div>
                        </div>

                        <div>
                            <label for="ltv-churn" class="block text-sm font-semibold text-slate-700 mb-2">
                                Monthly Churn Rate (%)
                            </label>
                            <input type="number" id="ltv-churn" inputmode="numeric" min="0" max="100"
                                step="0.1"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all cursor-text"
                                placeholder="e.g., 3" value="3">
                        </div>

                        <div>
                            <label for="ltv-cac" class="block text-sm font-semibold text-slate-700 mb-2">
                                Your CAC ($)
                            </label>
                            <input type="number" id="ltv-cac" inputmode="numeric"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all cursor-text"
                                placeholder="e.g., 400" value="400">
                        </div>

                        <button onclick="calculateLTV()"
                            class="w-full py-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                            <i class="fa-solid fa-infinity mr-2"></i>Calculate LTV & Ratio
                        </button>

                        <div id="ltv-result" class="hidden space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                                    <div class="text-xs font-semibold text-purple-600 mb-1">Customer LTV</div>
                                    <div class="text-2xl font-bold text-purple-700" id="ltv-value">$0</div>
                                </div>
                                <div
                                    class="p-4 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border border-teal-200">
                                    <div class="text-xs font-semibold text-teal-600 mb-1">LTV/CAC Ratio</div>
                                    <div class="text-2xl font-bold text-teal-700" id="ltv-ratio">0x</div>
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <div class="text-xs font-semibold text-slate-600 mb-1">CAC Payback Period</div>
                                <div class="text-lg font-bold text-slate-800" id="ltv-payback">0 months</div>
                            </div>
                            <div class="p-4 rounded-xl" id="ltv-health">
                                <div class="text-sm" id="ltv-interpretation"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Column --}}
                <div class="animate-fade-in-up order-1 lg:order-2">
                    <div
                        class="inline-flex items-center px-3 py-1 bg-purple-50 text-purple-600 rounded-full text-xs font-semibold mb-4">
                        <i class="fa-solid fa-chart-line mr-1"></i>Strategic
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-900 mb-4">
                        LTV/CAC <span class="text-purple-500">Ratio Model</span>
                    </h2>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        The LTV/CAC ratio is the single most important metric for subscription businesses. It tells you if
                        your business model is sustainable.
                    </p>

                    <div class="space-y-4 mb-8">
                        <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fa-solid fa-check text-white text-xs"></i>
                                </div>
                                <span class="font-semibold text-green-800">Healthy: 3:1 or higher</span>
                            </div>
                            <p class="text-sm text-green-700">You're earning 3x what you spend to acquire customers.</p>
                        </div>
                        <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-6 h-6 rounded-full bg-yellow-500 flex items-center justify-center">
                                    <i class="fa-solid fa-exclamation text-white text-xs"></i>
                                </div>
                                <span class="font-semibold text-yellow-800">Caution: 1:1 to 3:1</span>
                            </div>
                            <p class="text-sm text-yellow-700">Room for improvement in retention or CAC efficiency.</p>
                        </div>
                        <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-6 h-6 rounded-full bg-red-500 flex items-center justify-center">
                                    <i class="fa-solid fa-xmark text-white text-xs"></i>
                                </div>
                                <span class="font-semibold text-red-800">Warning: Below 1:1</span>
                            </div>
                            <p class="text-sm text-red-700">You're losing money on each customer acquired.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RICE Framework Section --}}
    <section id="rice-framework" class="py-20 px-4 md:px-8 bg-gradient-to-b from-white to-teal-50">
        <div class="max-w-[1200px] mx-auto">
            <div class="text-center mb-12 animate-fade-in-up">
                <div
                    class="inline-flex items-center px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-xs font-semibold mb-4 border border-teal-100">
                    <i class="fa-solid fa-list-check mr-1"></i>Prioritization
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-teal-900 mb-4">
                    RICE <span class="text-primary">Scoring Framework</span>
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Prioritize features objectively using Reach, Impact, Confidence, and Effort scoring.
                </p>
            </div>

            <div class="glass p-8 rounded-3xl shadow-glass">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                    <div>
                        <label for="rice-reach" class="block text-sm font-semibold text-slate-700 mb-2">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 bg-teal-100 text-teal-600 rounded-full text-xs font-bold mr-2">R</span>
                            Reach (users/quarter)
                        </label>
                        <input type="number" id="rice-reach" inputmode="numeric"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all cursor-text"
                            placeholder="e.g., 5000" value="5000">
                        <p class="text-xs text-slate-500 mt-1">How many users will this impact?</p>
                    </div>
                    <div>
                        <label for="rice-impact" class="block text-sm font-semibold text-slate-700 mb-2">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 bg-teal-100 text-teal-600 rounded-full text-xs font-bold mr-2">I</span>
                            Impact (0.25-3)
                        </label>
                        <select id="rice-impact"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all cursor-pointer">
                            <option value="3">3 - Massive</option>
                            <option value="2" selected>2 - High</option>
                            <option value="1">1 - Medium</option>
                            <option value="0.5">0.5 - Low</option>
                            <option value="0.25">0.25 - Minimal</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-1">How much will this move the needle?</p>
                    </div>
                    <div>
                        <label for="rice-confidence" class="block text-sm font-semibold text-slate-700 mb-2">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 bg-teal-100 text-teal-600 rounded-full text-xs font-bold mr-2">C</span>
                            Confidence (%)
                        </label>
                        <select id="rice-confidence"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all cursor-pointer">
                            <option value="100">100% - High confidence</option>
                            <option value="80" selected>80% - Medium-high</option>
                            <option value="50">50% - Medium</option>
                            <option value="20">20% - Low confidence</option>
                        </select>
                        <p class="text-xs text-slate-500 mt-1">How confident are you in estimates?</p>
                    </div>
                    <div>
                        <label for="rice-effort" class="block text-sm font-semibold text-slate-700 mb-2">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 bg-teal-100 text-teal-600 rounded-full text-xs font-bold mr-2">E</span>
                            Effort (person-months)
                        </label>
                        <input type="number" id="rice-effort" inputmode="numeric" min="0.5" step="0.5"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all cursor-text"
                            placeholder="e.g., 2" value="2">
                        <p class="text-xs text-slate-500 mt-1">How many person-months to build?</p>
                    </div>
                </div>

                <button onclick="calculateRICE()"
                    class="w-full py-4 gradient-primary text-white font-bold rounded-xl hover:shadow-glow hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                    <i class="fa-solid fa-calculator mr-2"></i>Calculate RICE Score
                </button>

                <div id="rice-result" class="hidden mt-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-gradient-to-br from-teal-500 to-primary rounded-2xl text-white">
                            <div class="text-sm font-semibold opacity-90 mb-2">RICE Score</div>
                            <div class="text-5xl font-bold mb-2" id="rice-score">0</div>
                            <div class="text-sm opacity-80">Higher is better</div>
                        </div>
                        <div class="p-6 bg-white rounded-2xl border border-slate-200">
                            <div class="text-sm font-semibold text-slate-600 mb-3">Score Breakdown</div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Reach × Impact × Confidence</span>
                                    <span class="font-semibold text-teal-900" id="rice-numerator">0</span>
                                </div>
                                <div class="flex justify-between border-t border-slate-100 pt-2">
                                    <span class="text-slate-600">÷ Effort</span>
                                    <span class="font-semibold text-teal-900" id="rice-effort-display">0</span>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-slate-50 rounded-lg">
                                <div class="text-xs text-slate-500">Formula: (R × I × C) / E</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 p-4 rounded-xl" id="rice-interpretation-box">
                        <p class="text-sm" id="rice-interpretation"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Churn Rate Calculator --}}
    <section id="churn-calculator" class="py-20 px-4 md:px-8 bg-white">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                {{-- Info Column --}}
                <div class="animate-fade-in-up">
                    <div
                        class="inline-flex items-center px-3 py-1 bg-orange-50 text-orange-600 rounded-full text-xs font-semibold mb-4">
                        <i class="fa-solid fa-arrow-trend-down mr-1"></i>Retention Metric
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-900 mb-4">
                        Churn Rate <span class="text-orange-500">Calculator</span>
                    </h2>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Understand your customer attrition rate and its impact on growth. A 5% reduction in churn can
                        increase profits by 25-95%.
                    </p>

                    <div class="p-6 bg-orange-50 rounded-2xl border border-orange-100 mb-6">
                        <h4 class="font-semibold text-orange-800 mb-3">
                            <i class="fa-solid fa-chart-line mr-2"></i>Industry Benchmarks
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-orange-700">SaaS (Enterprise)</span>
                                <span class="font-semibold text-orange-800">1-2% monthly</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-orange-700">SaaS (SMB)</span>
                                <span class="font-semibold text-orange-800">3-5% monthly</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-orange-700">Consumer Apps</span>
                                <span class="font-semibold text-orange-800">5-7% monthly</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-orange-700">E-commerce</span>
                                <span class="font-semibold text-orange-800">20-25% annually</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="text-sm font-semibold text-slate-700 mb-2">
                            <i class="fa-solid fa-calculator mr-2"></i>Formula
                        </div>
                        <code class="text-sm text-slate-600 font-mono">
                            Churn Rate = (Lost Customers / Start Customers) × 100
                        </code>
                    </div>
                </div>

                {{-- Calculator Column --}}
                <div class="glass p-8 rounded-3xl shadow-glass">
                    <h3 class="text-xl font-bold text-teal-900 mb-6">
                        <i class="fa-solid fa-arrow-trend-down text-orange-500 mr-2"></i>Churn Calculator
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label for="churn-start" class="block text-sm font-semibold text-slate-700 mb-2">
                                Customers at Start of Period
                            </label>
                            <input type="number" id="churn-start" inputmode="numeric"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all cursor-text"
                                placeholder="e.g., 1000" value="1000">
                        </div>

                        <div>
                            <label for="churn-lost" class="block text-sm font-semibold text-slate-700 mb-2">
                                Customers Lost During Period
                            </label>
                            <input type="number" id="churn-lost" inputmode="numeric"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all cursor-text"
                                placeholder="e.g., 50" value="50">
                        </div>

                        <div>
                            <label for="churn-period" class="block text-sm font-semibold text-slate-700 mb-2">
                                Time Period
                            </label>
                            <select id="churn-period"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-800 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all cursor-pointer">
                                <option value="monthly" selected>Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="annually">Annually</option>
                            </select>
                        </div>

                        <button onclick="calculateChurn()"
                            class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                            <i class="fa-solid fa-calculator mr-2"></i>Calculate Churn Rate
                        </button>

                        <div id="churn-result" class="hidden space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="p-4 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                                    <div class="text-xs font-semibold text-orange-600 mb-1">Churn Rate</div>
                                    <div class="text-2xl font-bold text-orange-700" id="churn-rate">0%</div>
                                </div>
                                <div
                                    class="p-4 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border border-teal-200">
                                    <div class="text-xs font-semibold text-teal-600 mb-1">Retention Rate</div>
                                    <div class="text-2xl font-bold text-teal-700" id="retention-rate">0%</div>
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <div class="text-xs font-semibold text-slate-600 mb-1">Avg Customer Lifespan</div>
                                <div class="text-lg font-bold text-slate-800" id="customer-lifespan">0 months</div>
                            </div>
                            <div class="p-4 rounded-xl" id="churn-health">
                                <p class="text-sm" id="churn-interpretation"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-24 px-4 md:px-8 bg-gradient-to-br from-teal-900 to-primary relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-400 rounded-full blur-[150px] opacity-20 animate-pulse-slow">
        </div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent rounded-full blur-[150px] opacity-20 animate-pulse-slow"
            style="animation-delay: 2s;"></div>

        <div class="max-w-[800px] mx-auto text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Need a Custom Tool?</h2>
            <p class="text-xl text-teal-100 mb-10 leading-relaxed">
                I build custom decision-making tools for product teams. From pricing models to retention calculators—let's
                discuss your specific needs.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}#contact"
                    class="inline-flex items-center px-8 py-4 bg-white text-teal-900 font-bold rounded-xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <i class="fa-solid fa-envelope mr-2"></i>Get in Touch
                </a>
                <a href="{{ route('home') }}#portfolio"
                    class="inline-flex items-center px-8 py-4 bg-white/10 backdrop-blur text-white font-bold rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-pointer">
                    <i class="fa-solid fa-briefcase mr-2"></i>View Case Studies
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // CAC Calculator
        function calculateCAC() {
            const marketing = parseFloat(document.getElementById('cac-marketing').value) || 0;
            const sales = parseFloat(document.getElementById('cac-sales').value) || 0;
            const customers = parseFloat(document.getElementById('cac-customers').value) || 1;

            const cac = (marketing + sales) / customers;

            document.getElementById('cac-value').textContent = '$' + cac.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            let interpretation = '';
            if (cac < 100) {
                interpretation =
                    '<span class="text-green-600 font-semibold">Excellent!</span> Your CAC is very efficient. Focus on scaling acquisition channels.';
            } else if (cac < 300) {
                interpretation =
                    '<span class="text-teal-600 font-semibold">Good.</span> Healthy CAC for most B2B businesses. Monitor as you scale.';
            } else if (cac < 500) {
                interpretation =
                    '<span class="text-yellow-600 font-semibold">Moderate.</span> Consider optimizing conversion rates or reducing ad spend.';
            } else {
                interpretation =
                    '<span class="text-red-600 font-semibold">High CAC.</span> Review your funnel efficiency and sales cycle length.';
            }

            document.getElementById('cac-interpretation').innerHTML = interpretation;
            document.getElementById('cac-result').classList.remove('hidden');
        }

        // LTV Calculator
        function calculateLTV() {
            const arpu = parseFloat(document.getElementById('ltv-arpu').value) || 0;
            const margin = parseFloat(document.getElementById('ltv-margin').value) / 100 || 0;
            const churn = parseFloat(document.getElementById('ltv-churn').value) / 100 || 0.01;
            const cac = parseFloat(document.getElementById('ltv-cac').value) || 1;

            const ltv = (arpu * margin) / churn;
            const ratio = ltv / cac;
            const paybackMonths = cac / (arpu * margin);

            document.getElementById('ltv-value').textContent = '$' + ltv.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            document.getElementById('ltv-ratio').textContent = ratio.toFixed(1) + 'x';
            document.getElementById('ltv-payback').textContent = paybackMonths.toFixed(1) + ' months';

            const healthBox = document.getElementById('ltv-health');
            let interpretation = '';

            if (ratio >= 3) {
                healthBox.className = 'p-4 rounded-xl bg-green-50 border border-green-200';
                interpretation =
                    '<span class="text-green-700 font-semibold">🎉 Excellent unit economics!</span> Your LTV/CAC ratio is healthy. You have room to invest more in growth.';
            } else if (ratio >= 1) {
                healthBox.className = 'p-4 rounded-xl bg-yellow-50 border border-yellow-200';
                interpretation =
                    '<span class="text-yellow-700 font-semibold">⚠️ Room for improvement.</span> Focus on increasing retention or reducing CAC to improve profitability.';
            } else {
                healthBox.className = 'p-4 rounded-xl bg-red-50 border border-red-200';
                interpretation =
                    '<span class="text-red-700 font-semibold">🚨 Warning!</span> You\'re losing money on each customer. Urgent action needed on retention and/or acquisition costs.';
            }

            document.getElementById('ltv-interpretation').innerHTML = interpretation;
            document.getElementById('ltv-result').classList.remove('hidden');
        }

        // RICE Calculator
        function calculateRICE() {
            const reach = parseFloat(document.getElementById('rice-reach').value) || 0;
            const impact = parseFloat(document.getElementById('rice-impact').value) || 0;
            const confidence = parseFloat(document.getElementById('rice-confidence').value) / 100 || 0;
            const effort = parseFloat(document.getElementById('rice-effort').value) || 1;

            const numerator = reach * impact * confidence;
            const score = numerator / effort;

            document.getElementById('rice-score').textContent = score.toLocaleString('en-US', {
                maximumFractionDigits: 0
            });
            document.getElementById('rice-numerator').textContent = numerator.toLocaleString('en-US', {
                maximumFractionDigits: 0
            });
            document.getElementById('rice-effort-display').textContent = effort + ' person-months';

            const interpretationBox = document.getElementById('rice-interpretation-box');
            let interpretation = '';

            if (score >= 5000) {
                interpretationBox.className = 'mt-6 p-4 rounded-xl bg-green-50 border border-green-200';
                interpretation =
                    '<span class="text-green-700 font-semibold">🚀 High Priority!</span> This feature has excellent ROI potential. Consider prioritizing it in your next sprint.';
            } else if (score >= 1000) {
                interpretationBox.className = 'mt-6 p-4 rounded-xl bg-teal-50 border border-teal-200';
                interpretation =
                    '<span class="text-teal-700 font-semibold">✓ Good candidate.</span> Solid RICE score. Compare with other features using the same framework.';
            } else if (score >= 500) {
                interpretationBox.className = 'mt-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200';
                interpretation =
                    '<span class="text-yellow-700 font-semibold">📊 Moderate priority.</span> Consider if there are higher-impact alternatives before committing resources.';
            } else {
                interpretationBox.className = 'mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200';
                interpretation =
                    '<span class="text-slate-700 font-semibold">⏸ Lower priority.</span> May not be the best use of limited resources right now.';
            }

            document.getElementById('rice-interpretation').innerHTML = interpretation;
            document.getElementById('rice-result').classList.remove('hidden');
        }

        // Churn Calculator
        function calculateChurn() {
            const startCustomers = parseFloat(document.getElementById('churn-start').value) || 1;
            const lostCustomers = parseFloat(document.getElementById('churn-lost').value) || 0;
            const period = document.getElementById('churn-period').value;

            const churnRate = (lostCustomers / startCustomers) * 100;
            const retentionRate = 100 - churnRate;

            // Calculate average lifespan (1 / churn rate)
            let lifespanMonths = 0;
            if (churnRate > 0) {
                const monthlyChurn = period === 'quarterly' ? churnRate / 3 :
                    period === 'annually' ? churnRate / 12 : churnRate;
                lifespanMonths = 100 / monthlyChurn;
            }

            document.getElementById('churn-rate').textContent = churnRate.toFixed(2) + '%';
            document.getElementById('retention-rate').textContent = retentionRate.toFixed(2) + '%';
            document.getElementById('customer-lifespan').textContent = lifespanMonths.toFixed(1) + ' months';

            const healthBox = document.getElementById('churn-health');
            let interpretation = '';

            // Interpretation based on period
            let thresholdLow, thresholdMed;
            if (period === 'monthly') {
                thresholdLow = 3;
                thresholdMed = 7;
            } else if (period === 'quarterly') {
                thresholdLow = 9;
                thresholdMed = 20;
            } else {
                thresholdLow = 20;
                thresholdMed = 40;
            }

            if (churnRate <= thresholdLow) {
                healthBox.className = 'p-4 rounded-xl bg-green-50 border border-green-200';
                interpretation =
                    '<span class="text-green-700 font-semibold">✅ Excellent retention!</span> Your churn rate is within healthy benchmarks. Keep focusing on customer success.';
            } else if (churnRate <= thresholdMed) {
                healthBox.className = 'p-4 rounded-xl bg-yellow-50 border border-yellow-200';
                interpretation =
                    '<span class="text-yellow-700 font-semibold">⚠️ Moderate churn.</span> There\'s room for improvement. Analyze why customers leave and address top reasons.';
            } else {
                healthBox.className = 'p-4 rounded-xl bg-red-50 border border-red-200';
                interpretation =
                    '<span class="text-red-700 font-semibold">🚨 High churn alert!</span> This rate is concerning. Prioritize customer research and retention initiatives immediately.';
            }

            document.getElementById('churn-interpretation').innerHTML = interpretation;
            document.getElementById('churn-result').classList.remove('hidden');
        }

        // Auto-calculate on page load with default values
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll behavior for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endpush
