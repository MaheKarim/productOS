@if ($footer = App\Models\FooterSettings::firstActive())
    <footer id="footer" class="bg-teal-900 text-white py-16 px-8">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="text-2xl font-bold mb-4">{{ $footer->logo_text ?? 'productOS' }}</div>
                    <p class="text-teal-200 text-sm leading-relaxed">
                        {{ $footer->description ?? 'Building growth strategies and the tools to measure them.' }}
                    </p>
                </div>

                @if ($footer->column1_links)
                    <div>
                        <h4 class="font-semibold mb-4">Case Studies</h4>
                        <ul class="space-y-2 text-sm text-teal-200">
                            @foreach ($footer->column1_links as $link)
                                <li>
                                    <a href="{{ $link['url'] ?? '#' }}" class="hover:text-white transition-default">
                                        {{ $link['text'] ?? 'Link' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($footer->column2_links)
                    <div>
                        <h4 class="font-semibold mb-4">Tools</h4>
                        <ul class="space-y-2 text-sm text-teal-200">
                            @foreach ($footer->column2_links as $link)
                                <li>
                                    <a href="{{ $link['url'] ?? '#' }}" class="hover:text-white transition-default">
                                        {{ $link['text'] ?? 'Link' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($footer->column3_links)
                    <div>
                        <h4 class="font-semibold mb-4">Connect</h4>
                        <ul class="space-y-2 text-sm text-teal-200">
                            @if ($footer->linkedin_url)
                                <li>
                                    <a href="{{ $footer->linkedin_url }}" class="hover:text-white transition-default">
                                        LinkedIn
                                    </a>
                                </li>
                            @endif
                            @if ($footer->twitter_url)
                                <li>
                                    <a href="{{ $footer->twitter_url }}" class="hover:text-white transition-default">
                                        Twitter
                                    </a>
                                </li>
                            @endif
                            @if ($footer->email)
                                <li>
                                    <a href="mailto:{{ $footer->email }}" class="hover:text-white transition-default">
                                        Email
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>

            <div class="pt-8 border-t border-white/20 flex items-center justify-between text-sm text-teal-200">
                <div>
                    © {{ date('Y') }} {{ $footer->copyright_text ?? 'PM+ Portfolio. All rights reserved.' }}
                </div>
                <div class="flex items-center space-x-6">
                    @if ($footer->privacy_policy_url)
                        <a href="{{ $footer->privacy_policy_url }}" class="hover:text-white transition-default">
                            Privacy
                        </a>
                    @endif
                    @if ($footer->terms_url)
                        <a href="{{ $footer->terms_url }}" class="hover:text-white transition-default">
                            Terms
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>
@endif
