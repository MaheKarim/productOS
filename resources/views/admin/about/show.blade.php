@extends('admin.layout')

@section('title', 'View About Section')

@section('page-title', 'View About Section')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-teal-900">About Section Details</h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.about.edit', $about) }}"
                    class="px-4 py-2 text-primary hover:text-teal-900 text-sm font-medium">
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                    Edit
                </a>
                <form action="{{ route('admin.about.destroy', $about) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this about section?');" class="inline">
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
                @if ($about->is_active)
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
                <span class="text-sm text-slate-600">Order: {{ $about->order }}</span>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Basic Information</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Heading</label>
                            <p class="text-sm text-slate-900">{{ $about->heading }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Description</label>
                            <p class="text-sm text-slate-900 whitespace-pre-wrap">{{ $about->description }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Image</h4>
                    @if ($about->image)
                        <img src="{{ $about->image_url }}" alt="About image" class="w-full h-64 object-cover rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-slate-500">No image uploaded</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Philosophy Section -->
            @if ($about->philosophy1_title || $about->philosophy2_title || $about->philosophy3_title || $about->philosophy4_title)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Philosophy</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if ($about->philosophy1_title)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h5 class="text-sm font-semibold text-teal-900 mb-2">{{ $about->philosophy1_title }}</h5>
                                <p class="text-sm text-slate-600">{{ $about->philosophy1_description }}</p>
                            </div>
                        @endif
                        @if ($about->philosophy2_title)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h5 class="text-sm font-semibold text-teal-900 mb-2">{{ $about->philosophy2_title }}</h5>
                                <p class="text-sm text-slate-600">{{ $about->philosophy2_description }}</p>
                            </div>
                        @endif
                        @if ($about->philosophy3_title)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h5 class="text-sm font-semibold text-teal-900 mb-2">{{ $about->philosophy3_title }}</h5>
                                <p class="text-sm text-slate-600">{{ $about->philosophy3_description }}</p>
                            </div>
                        @endif
                        @if ($about->philosophy4_title)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h5 class="text-sm font-semibold text-teal-900 mb-2">{{ $about->philosophy4_title }}</h5>
                                <p class="text-sm text-slate-600">{{ $about->philosophy4_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Work Items -->
            @if ($about->work_item1 || $about->work_item2 || $about->work_item3 || $about->work_item4)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Work Items</h4>
                    <ul class="space-y-2">
                        @if ($about->work_item1)
                            <li class="flex items-center space-x-2 text-sm text-slate-900">
                                <i class="fa-solid fa-check text-primary"></i>
                                <span>{{ $about->work_item1 }}</span>
                            </li>
                        @endif
                        @if ($about->work_item2)
                            <li class="flex items-center space-x-2 text-sm text-slate-900">
                                <i class="fa-solid fa-check text-primary"></i>
                                <span>{{ $about->work_item2 }}</span>
                            </li>
                        @endif
                        @if ($about->work_item3)
                            <li class="flex items-center space-x-2 text-sm text-slate-900">
                                <i class="fa-solid fa-check text-primary"></i>
                                <span>{{ $about->work_item3 }}</span>
                            </li>
                        @endif
                        @if ($about->work_item4)
                            <li class="flex items-center space-x-2 text-sm text-slate-900">
                                <i class="fa-solid fa-check text-primary"></i>
                                <span>{{ $about->work_item4 }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

            <!-- Core Values -->
            @if ($about->core_value1 || $about->core_value2 || $about->core_value3 || $about->core_value4)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Core Values</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if ($about->core_value1)
                            <div class="flex items-center space-x-3 p-3 bg-teal-50 rounded-lg">
                                <i class="fa-solid fa-heart text-primary"></i>
                                <span class="text-sm font-medium text-teal-900">{{ $about->core_value1 }}</span>
                            </div>
                        @endif
                        @if ($about->core_value2)
                            <div class="flex items-center space-x-3 p-3 bg-teal-50 rounded-lg">
                                <i class="fa-solid fa-heart text-primary"></i>
                                <span class="text-sm font-medium text-teal-900">{{ $about->core_value2 }}</span>
                            </div>
                        @endif
                        @if ($about->core_value3)
                            <div class="flex items-center space-x-3 p-3 bg-teal-50 rounded-lg">
                                <i class="fa-solid fa-heart text-primary"></i>
                                <span class="text-sm font-medium text-teal-900">{{ $about->core_value3 }}</span>
                            </div>
                        @endif
                        @if ($about->core_value4)
                            <div class="flex items-center space-x-3 p-3 bg-teal-50 rounded-lg">
                                <i class="fa-solid fa-heart text-primary"></i>
                                <span class="text-sm font-medium text-teal-900">{{ $about->core_value4 }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- SEO -->
            @if ($about->meta_title || $about->meta_description)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">SEO</h4>
                    <div class="space-y-4">
                        @if ($about->meta_title)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Meta Title</label>
                                <p class="text-sm text-slate-900">{{ $about->meta_title }}</p>
                            </div>
                        @endif
                        @if ($about->meta_description)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Meta Description</label>
                                <p class="text-sm text-slate-900">{{ $about->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.about.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Back to List
                </a>
                <a href="{{ route('admin.about.edit', $about) }}"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                    Edit About Section
                </a>
            </div>
        </div>
    </div>
@endsection
