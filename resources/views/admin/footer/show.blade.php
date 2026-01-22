@extends('admin.layout')

@section('title', 'View Footer')

@section('page-title', 'View Footer')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-teal-900">Footer Details</h3>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.footer.edit', $footer) }}"
                    class="px-4 py-2 text-primary hover:text-teal-900 text-sm font-medium">
                    <i class="fa-solid fa-pen-to-square mr-1"></i>
                    Edit
                </a>
                <form action="{{ route('admin.footer.destroy', $footer) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this footer configuration?');" class="inline">
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
                @if ($footer->is_active)
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
                <span class="text-sm text-slate-600">Order: {{ $footer->order }}</span>
            </div>

            <!-- Brand & Description -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Brand & Description</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Logo Text</label>
                            <p class="text-sm text-slate-900">{{ $footer->logo_text ?: 'Not set' }}</p>
                        </div>
                        @if ($footer->description)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Description</label>
                                <p class="text-sm text-slate-900 whitespace-pre-wrap">{{ $footer->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Logo Image</h4>
                    @if ($footer->logo_image)
                        <img src="{{ $footer->logo_image_url }}" alt="Footer logo"
                            class="w-full h-64 object-cover rounded-lg">
                    @else
                        <div class="w-full h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-slate-500">No logo uploaded</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            @if ($footer->email)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Contact Information</h4>
                    <div class="space-y-2">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Email Address</label>
                            <p class="text-sm text-slate-900">{{ $footer->email }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Social Links -->
            @if ($footer->linkedin_url || $footer->twitter_url || $footer->github_url)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Social Media Links</h4>
                    <div class="space-y-2">
                        @if ($footer->linkedin_url)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">LinkedIn</label>
                                <a href="{{ $footer->linkedin_url }}" target="_blank"
                                    class="text-sm text-primary hover:underline">{{ $footer->linkedin_url }}</a>
                            </div>
                        @endif
                        @if ($footer->twitter_url)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Twitter</label>
                                <a href="{{ $footer->twitter_url }}" target="_blank"
                                    class="text-sm text-primary hover:underline">{{ $footer->twitter_url }}</a>
                            </div>
                        @endif
                        @if ($footer->github_url)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">GitHub</label>
                                <a href="{{ $footer->github_url }}" target="_blank"
                                    class="text-sm text-primary hover:underline">{{ $footer->github_url }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Footer Links Columns -->
            @if ($footer->column1_links || $footer->column2_links || $footer->column3_links)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Footer Links</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Column 1 --}}
                        @if ($footer->column1_links && count($footer->column1_links) > 0)
                            <div>
                                <h5 class="text-xs font-semibold text-slate-700 mb-3">Column 1</h5>
                                <ul class="space-y-2">
                                    @foreach ($footer->column1_links as $link)
                                        @if (isset($link['text']) && $link['text'])
                                            <li class="text-sm text-slate-900">
                                                <span class="font-medium">{{ $link['text'] }}</span>
                                                @if (isset($link['url']) && $link['url'])
                                                    <br><a href="{{ $link['url'] }}" target="_blank"
                                                        class="text-xs text-primary hover:underline">{{ $link['url'] }}</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Column 2 --}}
                        @if ($footer->column2_links && count($footer->column2_links) > 0)
                            <div>
                                <h5 class="text-xs font-semibold text-slate-700 mb-3">Column 2</h5>
                                <ul class="space-y-2">
                                    @foreach ($footer->column2_links as $link)
                                        @if (isset($link['text']) && $link['text'])
                                            <li class="text-sm text-slate-900">
                                                <span class="font-medium">{{ $link['text'] }}</span>
                                                @if (isset($link['url']) && $link['url'])
                                                    <br><a href="{{ $link['url'] }}" target="_blank"
                                                        class="text-xs text-primary hover:underline">{{ $link['url'] }}</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Column 3 --}}
                        @if ($footer->column3_links && count($footer->column3_links) > 0)
                            <div>
                                <h5 class="text-xs font-semibold text-slate-700 mb-3">Column 3</h5>
                                <ul class="space-y-2">
                                    @foreach ($footer->column3_links as $link)
                                        @if (isset($link['text']) && $link['text'])
                                            <li class="text-sm text-slate-900">
                                                <span class="font-medium">{{ $link['text'] }}</span>
                                                @if (isset($link['url']) && $link['url'])
                                                    <br><a href="{{ $link['url'] }}" target="_blank"
                                                        class="text-xs text-primary hover:underline">{{ $link['url'] }}</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Copyright & Legal -->
            @if ($footer->copyright_text || $footer->privacy_policy_url || $footer->terms_url)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Copyright & Legal</h4>
                    <div class="space-y-2">
                        @if ($footer->copyright_text)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Copyright Text</label>
                                <p class="text-sm text-slate-900">{{ $footer->copyright_text }}</p>
                            </div>
                        @endif
                        @if ($footer->privacy_policy_url)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Privacy Policy URL</label>
                                <a href="{{ $footer->privacy_policy_url }}" target="_blank"
                                    class="text-sm text-primary hover:underline">{{ $footer->privacy_policy_url }}</a>
                            </div>
                        @endif
                        @if ($footer->terms_url)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Terms of Service URL</label>
                                <a href="{{ $footer->terms_url }}" target="_blank"
                                    class="text-sm text-primary hover:underline">{{ $footer->terms_url }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- SEO -->
            @if ($footer->meta_title || $footer->meta_description)
                <div class="border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">SEO</h4>
                    <div class="space-y-4">
                        @if ($footer->meta_title)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Meta Title</label>
                                <p class="text-sm text-slate-900">{{ $footer->meta_title }}</p>
                            </div>
                        @endif
                        @if ($footer->meta_description)
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Meta Description</label>
                                <p class="text-sm text-slate-900">{{ $footer->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.footer.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Back to List
                </a>
                <a href="{{ route('admin.footer.edit', $footer) }}"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                    Edit Footer
                </a>
            </div>
        </div>
    </div>
@endsection
