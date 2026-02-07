@extends('user.layout')

@section('title', 'New ICP Project')

@section('content')
    <div class="max-w-4xl mx-auto py-8" x-data="icpWizard()">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Create New ICP</h1>
            <p class="text-slate-500 mt-2">Define your product details to generate a comprehensive Ideal Customer Profile.
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors"
                            :class="currentStep > index + 1 ? 'bg-blue-600 border-blue-600 text-white' :
                                (currentStep === index + 1 ? 'border-blue-600 text-blue-600' :
                                    'border-slate-200 text-slate-400')">
                            <span x-text="index + 1"></span>
                        </div>
                    </div>
                </template>
            </div>
            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 transition-all duration-500"
                    :style="`width: ${(currentStep / steps.length) * 100}%`"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 relative overflow-hidden">

            <!-- Loading Overlay -->
            <div x-show="isGenerating"
                class="absolute inset-0 bg-white/90 z-50 flexflex-col items-center justify-center text-center p-8 backdrop-blur-sm"
                style="display: none;">
                <div class="flex flex-col items-center justify-center h-full">
                    <div class="w-16 h-16 border-4 border-blue-100 border-t-blue-600 rounded-full animate-spin mb-4"></div>
                    <h3 class="text-xl font-bold text-slate-900">Generating Your ICP...</h3>
                    <p class="text-slate-500 mt-2">Our AI is analyzing your product and market data. This typically takes
                        30-60 seconds.</p>
                </div>
            </div>

            <form @submit.prevent="submit">
                <!-- Step 1: Basics -->
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-xl font-semibold mb-6">Project Basics</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Project Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" x-model="form.project_name"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="e.g., Enterprise Sales Tool v1">
                            <p x-show="errors.project_name" class="text-red-500 text-xs mt-1">Please enter a project name
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product Name</label>
                            <input type="text" x-model="form.product_name"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="My Awesome Product">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product Description <span
                                    class="text-red-500">*</span></label>
                            <textarea x-model="form.product_description" rows="4"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="Describe what your product does, its main features, and the value it provides..."></textarea>
                            <p class="text-xs text-slate-400 mt-1">Be specific about the problem you solve.</p>
                            <p x-show="errors.product_description" class="text-red-500 text-xs mt-1">Description is required
                                (min 20 chars)</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Market Context -->
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                    style="display: none;">
                    <h2 class="text-xl font-semibold mb-6">Market Context</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product Type</label>
                            <select x-model="form.product_type"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                                <option value="">Select type...</option>
                                <option value="B2B SaaS">B2B SaaS</option>
                                <option value="B2C App">B2C App</option>
                                <option value="Agency / Service">Agency / Service</option>
                                <option value="Marketplace">Marketplace</option>
                                <option value="Ecommerce">Ecommerce</option>
                                <option value="Enterprise Software">Enterprise Software</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Target Market</label>
                            <input type="text" x-model="form.target_market"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500"
                                placeholder="e.g., Global, North America, UK...">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Company Stage</label>
                            <select x-model="form.company_stage"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                                <option value="">Select stage...</option>
                                <option value="Idea / Pre-seed">Idea / Pre-seed</option>
                                <option value="MVP / Early Stage">MVP / Early Stage</option>
                                <option value="Growth">Growth</option>
                                <option value="Scale-up">Scale-up</option>
                                <option value="Mature">Mature</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Primary Goal</label>
                            <select x-model="form.primary_goal"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500">
                                <option value="">Select goal...</option>
                                <option value="Acquisition (New Logos)">Acquisition (New Logos)</option>
                                <option value="Retention (Churn Reduction)">Retention (Churn Reduction)</option>
                                <option value="Expansion (Upsell/Cross-sell)">Expansion (Upsell/Cross-sell)</option>
                                <option value="Market Validation">Market Validation</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Business Details -->
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
                    style="display: none;">
                    <h2 class="text-xl font-semibold mb-6">Business Details</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pricing Model</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <template x-for="model in pricingModels" :key="model.value">
                                    <div @click="form.pricing_model = model.value"
                                        class="cursor-pointer border rounded-lg p-3 text-center transition-all"
                                        :class="form.pricing_model === model.value ?
                                            'bg-blue-50 border-blue-500 text-blue-700' :
                                            'border-slate-200 hover:border-blue-300'">
                                        <div class="text-sm font-medium" x-text="model.label"></div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Average Deal Size
                                (Optional)</label>
                            <input type="text" x-model="form.deal_size"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500"
                                placeholder="e.g., $100/mo or $50k/year">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-between items-center">
                    <button type="button" @click="prevStep" x-show="currentStep > 1"
                        class="px-6 py-2.5 text-slate-600 font-medium hover:text-slate-900 transition-colors">
                        Back
                    </button>
                    <div class="ml-auto">
                        <button type="button" @click="nextStep" x-show="currentStep < steps.length"
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">
                            Continue
                        </button>
                        <button type="submit" x-show="currentStep === steps.length"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium hover:shadow-lg hover:shadow-blue-500/25 transition-all">
                            <i data-lucide="sparkles" class="w-4 h-4"></i>
                            Generate ICP
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function icpWizard() {
            return {
                currentStep: 1,
                steps: ['Basics', 'Market', 'Details'],
                isGenerating: false,
                errors: {},

                pricingModels: [{
                        value: 'Subscription',
                        label: 'Subscription'
                    },
                    {
                        value: 'Usage-based',
                        label: 'Usage-based'
                    },
                    {
                        value: 'One-time',
                        label: 'One-time'
                    },
                    {
                        value: 'Freemium',
                        label: 'Freemium'
                    }
                ],

                form: {
                    project_name: '',
                    product_name: '',
                    product_description: '',
                    product_type: '',
                    target_market: '',
                    company_stage: '',
                    primary_goal: '',
                    pricing_model: '',
                    deal_size: ''
                },

                validateStep() {
                    this.errors = {};
                    let isValid = true;

                    if (this.currentStep === 1) {
                        if (!this.form.project_name.trim()) {
                            this.errors.project_name = true;
                            isValid = false;
                        }
                        if (!this.form.product_description.trim() || this.form.product_description.length < 20) {
                            this.errors.product_description = true;
                            isValid = false;
                        }
                    }

                    return isValid;
                },

                nextStep() {
                    if (this.validateStep()) {
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        this.currentStep++;
                    }
                },

                prevStep() {
                    this.currentStep--;
                },

                async submit() {
                    if (!this.validateStep()) return;

                    this.isGenerating = true;

                    try {
                        const response = await fetch('{{ route('icp-builder.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.form)
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            throw new Error(result.message || 'Something went wrong');
                        }

                        if (result.success && result.redirect_url) {
                            window.location.href = result.redirect_url;
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                        this.isGenerating = false;
                    }
                }
            }
        }
    </script>
@endsection
