@extends('admin.layout')

@section('title', 'User Onboarding Settings')
@section('page-title', 'User Onboarding Settings')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-glass">

            {{-- Header Section --}}
            <div class="mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-100 flex items-start gap-4">
                <div class="p-3 bg-indigo-50 rounded-xl">
                    <i data-lucide="clipboard-list" class="w-8 h-8 text-indigo-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800 mb-2">Feature Configuration</h2>
                    <p class="text-slate-600 leading-relaxed">
                        Control whether new users must complete the professional information onboarding flow before
                        accessing the dashboard.
                    </p>
                    <div class="mt-4 flex gap-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            <i data-lucide="info" class="w-3 h-3 mr-1"></i> Impacts new signups
                        </span>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                            <i data-lucide="alert-circle" class="w-3 h-3 mr-1"></i> Blocks dashboard access
                        </span>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Configuration Form --}}
            <form action="{{ route('admin.onboarding.update') }}" method="POST">
                @csrf

                <div class="space-y-8">

                    {{-- Toggle Switch Card --}}
                    <div
                        class="p-6 rounded-2xl border {{ $isEnabled ? 'bg-indigo-50/50 border-indigo-100' : 'bg-slate-50 border-slate-200' }} transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <label for="onboarding_toggle" class="flex items-center cursor-pointer relative">
                                    <input type="checkbox" id="onboarding_toggle" name="onboarding_feature_enabled"
                                        value="1" class="sr-only peer" {{ $isEnabled ? 'checked' : '' }}>
                                    <div
                                        class="w-14 h-7 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                                <div>
                                    <h3 class="font-bold text-lg text-slate-900">Enable Onboarding Flow</h3>
                                    <p class="text-slate-500 text-sm">Toggle to activate/deactivate the system-wide
                                        requirement</p>
                                </div>
                            </div>

                            <div class="text-right">
                                <span
                                    class="block text-sm font-bold uppercase tracking-wider {{ $isEnabled ? 'text-indigo-600' : 'text-slate-400' }}">
                                    {{ $isEnabled ? 'Active' : 'Disabled' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Feature Breakdown --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="p-5 rounded-2xl border border-slate-100 bg-white hover:shadow-md transition-shadow">
                            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500"></i>
                                If Enabled
                            </h4>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-start gap-2">
                                    <span class="bg-emerald-100 text-emerald-600 rounded-full p-0.5 mt-0.5"><i
                                            data-lucide="check" class="w-3 h-3"></i></span>
                                    New users directed to profile setup
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="bg-emerald-100 text-emerald-600 rounded-full p-0.5 mt-0.5"><i
                                            data-lucide="check" class="w-3 h-3"></i></span>
                                    Job role & experience data collected
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="bg-emerald-100 text-emerald-600 rounded-full p-0.5 mt-0.5"><i
                                            data-lucide="check" class="w-3 h-3"></i></span>
                                    Dashboard locked until completion
                                </li>
                            </ul>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-100 bg-white hover:shadow-md transition-shadow">
                            <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i data-lucide="x-circle" class="w-5 h-5 text-rose-500"></i>
                                If Disabled
                            </h4>
                            <ul class="space-y-3 text-sm text-slate-600">
                                <li class="flex items-start gap-2">
                                    <span class="bg-slate-100 text-slate-500 rounded-full p-0.5 mt-0.5"><i
                                            data-lucide="arrow-right" class="w-3 h-3"></i></span>
                                    Users skip profile collection
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="bg-slate-100 text-slate-500 rounded-full p-0.5 mt-0.5"><i
                                            data-lucide="arrow-right" class="w-3 h-3"></i></span>
                                    Immediate dashboard access
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="bg-slate-100 text-slate-500 rounded-full p-0.5 mt-0.5"><i
                                            data-lucide="arrow-right" class="w-3 h-3"></i></span>
                                    Existing data is preserved
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Action Bar --}}
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" onclick="window.history.back()"
                            class="px-6 py-2.5 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                            Save Changes
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        // Optional: Add client-side confirmation if disabling
        const toggle = document.getElementById('onboarding_toggle');
        toggle.addEventListener('change', function() {
            if (!this.checked) {
                if (!confirm(
                        'Are you sure you want to disable onboarding? New users will skip professional data collection.'
                        )) {
                    this.checked = true;
                }
            }
        });
    </script>
@endsection
