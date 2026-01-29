{{-- Support Section (Sleek Compact Bar - Post-Footer) --}}
@php
    $support = \App\Models\SupportSection::firstActive();
@endphp

@if ($support)
    <section id="support-section" class="bg-slate-900 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="flex flex-col md:flex-row items-center justify-between h-auto md:h-16 py-4 md:py-0 gap-4 md:gap-0">
                {{-- Left: Headline + Avatar --}}
                <div class="flex items-center gap-4">
                    @if ($support->image_url)
                        <img src="{{ $support->image_url }}" alt="Creator"
                            class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-700 flex-shrink-0">
                    @else
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="text-center md:text-left">
                        <p class="text-white font-semibold text-sm">
                            {{ $support->headline }}
                        </p>
                        @if ($support->show_progress_bar)
                            <div class="flex items-center gap-2 mt-0.5">
                                <div class="w-24 h-1.5 bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full transition-all duration-500"
                                        style="width: {{ $support->progress_percentage }}%"></div>
                                </div>
                                <span class="text-xs text-slate-400">{{ $support->progress_percentage }}%</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right: CTA + Social Links --}}
                <div class="flex items-center gap-3">
                    {{-- Social Links --}}
                    @if ($support->twitter_url)
                        <a href="{{ $support->twitter_url }}" target="_blank" rel="noopener noreferrer"
                            class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-sky-500 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                    @endif

                    @if ($support->linkedin_url)
                        <a href="{{ $support->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                            class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    @endif

                    {{-- Divider --}}
                    <div class="w-px h-6 bg-slate-700 hidden md:block"></div>

                    {{-- Buy Me A Coffee Button --}}
                    @if ($support->buymeacoffee_url)
                        <a href="{{ $support->buymeacoffee_url }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-400 to-orange-500 text-slate-900 font-bold text-sm rounded-lg hover:from-amber-500 hover:to-orange-600 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.216 6.415l-.132-.666c-.119-.598-.388-1.163-1.001-1.379-.197-.069-.42-.098-.57-.241-.152-.143-.196-.366-.231-.572-.065-.378-.125-.756-.192-1.133-.057-.325-.102-.69-.25-.987-.195-.4-.597-.634-.996-.788a5.723 5.723 0 00-.626-.194c-1-.263-2.05-.36-3.077-.416a25.834 25.834 0 00-3.7.062c-.915.083-1.88.184-2.75.5-.318.116-.646.256-.888.501-.297.302-.393.77-.177 1.146.154.267.415.456.692.58.36.162.737.284 1.123.366 1.075.238 2.189.331 3.287.37 1.218.05 2.437.01 3.65-.118.299-.033.598-.073.896-.119.352-.054.578-.513.474-.834-.124-.383-.457-.531-.834-.473-.466.074-.96.108-1.382.146-1.177.08-2.358.082-3.536.006a22.228 22.228 0 01-1.157-.107c-.086-.01-.18-.025-.258-.036-.243-.036-.484-.08-.724-.13-.111-.027-.111-.185 0-.212h.005c.277-.06.557-.108.838-.147h.002c.131-.009.263-.032.394-.048a25.076 25.076 0 013.426-.12c.674.019 1.347.067 2.017.144l.228.031c.267.04.533.088.798.145.392.085.895.113 1.07.542.055.137.08.288.111.431l.319 1.484a.237.237 0 01-.199.284h-.003c-.037.006-.075.01-.112.015a36.704 36.704 0 01-4.743.295 37.059 37.059 0 01-4.699-.304c-.14-.017-.293-.042-.417-.06-.326-.048-.649-.108-.973-.161-.393-.065-.768-.032-1.123.161-.29.16-.527.404-.675.701-.154.316-.199.66-.267 1-.069.34-.176.707-.135 1.056.087.753.613 1.365 1.37 1.502a39.69 39.69 0 0011.343.376.483.483 0 01.535.53l-.071.697-1.018 9.907c-.041.41-.047.832-.125 1.237-.122.637-.553 1.028-1.182 1.171-.577.131-1.165.2-1.756.205-.656.004-1.31-.025-1.966-.022-.699.004-1.556-.06-2.095-.58-.475-.458-.54-1.174-.605-1.793l-.731-7.013-.322-3.094c-.037-.351-.286-.695-.678-.678-.336.015-.718.3-.678.679l.228 2.185.949 9.112c.147 1.344 1.174 2.068 2.446 2.272.742.12 1.503.144 2.257.156.966.016 1.942.053 2.892-.122 1.408-.258 2.465-1.198 2.616-2.657.34-3.332.663-6.66.972-9.993l.091-.879a.484.484 0 01.651-.407c.514.194 1.077.272 1.62.226.769-.066 1.325-.563 1.495-1.345.163-.754.122-1.527-.086-2.264z" />
                            </svg>
                            <span class="hidden sm:inline">Buy Me a Coffee</span>
                            <span class="sm:hidden">Support</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
