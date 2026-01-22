@extends('admin.layout')

@section('title', 'View Service')

@section('page-title', 'View Service')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-teal-900">Service Details</h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.services.edit', $service) }}"
                    class="px-4 py-2 text-primary hover:text-teal-900 text-sm font-medium">
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                    Edit
                </a>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this service?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-red-500 hover:text-red-700 text-sm font-medium">
                        <i class="fa-solid fa-trash mr-1"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Status -->
            <div class="flex items-center space-x-2">
                @if ($service->is_active)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        Active
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                        <i class="fa-solid fa-circle-xmark mr-1"></i>
                        Inactive
                    </span>
                @endif
                <span class="text-sm text-slate-600">Order: {{ $service->order }}</span>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Basic Information</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Title</label>
                            <p class="text-sm text-slate-900">{{ $service->title }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Description</label>
                            <p class="text-sm text-slate-900 whitespace-pre-wrap">{{ $service->description }}</p>
                        </div>
                        @if ($service->problem_solves)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Problem Solves</label>
                                <p class="text-sm text-slate-900 whitespace-pre-wrap">{{ $service->problem_solves }}</p>
                            </div>
                        @endif
                        @if ($service->tangible_outcome)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Tangible Outcome</label>
                                <p class="text-sm text-slate-900 whitespace-pre-wrap">{{ $service->tangible_outcome }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Image & Icon</h4>
                    @if ($service->image)
                        <img src="{{ $service->image_url }}" alt="Service image"
                            class="w-full h-64 object-cover rounded-lg mb-4">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
                            <span class="text-slate-500">No image uploaded</span>
                        </div>
                    @endif
                    @if ($service->icon)
                        <div class="flex items-center space-x-3 p-4 bg-teal-50 rounded-lg">
                            <i class="{{ $service->full_icon }} text-2xl text-primary"></i>
                            <span class="text-sm font-medium text-teal-900">{{ $service->icon }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Features -->
            @if ($service->features && count($service->features) > 0)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Features</h4>
                    <ul class="space-y-2">
                        @foreach ($service->features as $feature)
                            @if ($feature)
                                <li class="flex items-center space-x-2 text-sm text-slate-900">
                                    <i class="fa-solid fa-check text-primary"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- CTA -->
            @if ($service->cta_text || $service->cta_url)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Call-to-Action</h4>
                    <div class="space-y-2">
                        @if ($service->cta_text)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">CTA Text</label>
                                <p class="text-sm text-slate-900">{{ $service->cta_text }}</p>
                            </div>
                        @endif
                        @if ($service->cta_url)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">CTA URL</label>
                                <p class="text-sm text-slate-900">{{ $service->cta_url }}</p>
                            </div>
                        @endif
                        @if ($service->cta_style)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">CTA Style</label>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800">
                                    {{ ucfirst($service->cta_style) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- SEO -->
            @if ($service->meta_title || $service->meta_description)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">SEO</h4>
                    <div class="space-y-4">
                        @if ($service->meta_title)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Meta Title</label>
                                <p class="text-sm text-slate-900">{{ $service->meta_title }}</p>
                            </div>
                        @endif
                        @if ($service->meta_description)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Meta Description</label>
                                <p class="text-sm text-slate-900">{{ $service->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.services.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Back to List
                </a>
                <a href="{{ route('admin.services.edit', $service) }}"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                    Edit Service
                </a>
            </div>
        </div>
    </div>
@endsection
