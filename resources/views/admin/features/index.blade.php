@extends('admin.layout')

@section('title', 'Credit Cost Management')
@section('page-title', 'Credit Cost Management')

@section('content')
    <div class="px-6 py-6 font-dm-sans min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700">
                    Credit Cost Management</h1>
                <p class="text-sm text-slate-500 mt-1">Manage feature availability and credit costs</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Feature</th>
                            <th class="px-6 py-4 font-semibold">Description</th>
                            <th class="px-6 py-4 font-semibold">Credit Cost</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($features as $feature)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <form action="{{ route('admin.features.update', $feature) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($feature->icon)
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                                    <i class="{{ $feature->icon }}"></i>
                                                </div>
                                            @endif
                                            <span class="font-medium text-slate-900">{{ $feature->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        {{ $feature->description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @if ($feature->credit_cost == -1)
                                                <i class="fa-solid fa-infinity text-green-500 text-xs"></i>
                                            @else
                                                <i class="fa-solid fa-coins text-amber-500 text-xs"></i>
                                            @endif
                                            <input type="number" name="credit_cost" value="{{ $feature->credit_cost }}"
                                                min="-1"
                                                class="w-20 px-2 py-1 text-sm border border-slate-200 rounded-md focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all {{ $feature->credit_cost == -1 ? 'text-green-600 font-medium' : '' }}">
                                        </div>
                                        <p class="text-xs text-slate-400 mt-1">-1 = Unlimited</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="hidden" name="is_active" value="0">
                                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                                {{ $feature->is_active ? 'checked' : '' }}>
                                            <div
                                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                            </div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-medium rounded-lg transition-colors shadow-sm">
                                            Save
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
