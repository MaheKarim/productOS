<section id="portfolio" class="py-32 px-8 bg-white relative overflow-hidden">
    <div class="max-w-[1200px] mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div class="max-w-2xl" data-aos="fade-right">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-teal-50 text-teal-600 text-xs font-bold mb-4 border border-teal-100 uppercase tracking-widest">
                    Case Studies
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4 tracking-tight">
                    Proven <span class="text-teal-600 italic">Results</span>
                </h2>
                <p class="text-xl text-slate-500 leading-relaxed">
                    Deep dives into complex product challenges and the strategies used to solve them.
                </p>
            </div>
            <div data-aos="fade-left">
                <a href="#contact"
                    class="inline-flex items-center text-slate-900 font-bold hover:text-teal-600 transition-colors cursor-pointer text-lg group">
                    View all projects <i
                        class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <div class="space-y-12">
            @foreach ($projects as $project)
                <div x-data="{ expanded: false }"
                    class="group relative bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden hover:shadow-2xl hover:border-teal-500/20 transition-all duration-500">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                        {{-- Image Side --}}
                        <div class="lg:col-span-5 relative h-64 lg:h-auto overflow-hidden">
                            @if ($project->image)
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                    <i class="fa-regular fa-image text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>

                            @if ($project->category)
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-xs font-bold text-white border border-white/30 uppercase tracking-widest">
                                        {{ $project->category }}
                                    </span>
                                </div>
                            @endif

                            {{-- Metric Overlay --}}
                            @if ($project->metric_value)
                                <div class="absolute bottom-6 left-6">
                                    <div class="text-4xl font-black text-white tracking-tight mb-1">
                                        {{ $project->metric_value }}</div>
                                    <div class="text-sm font-medium text-white/90">{{ $project->metric_label }}</div>
                                </div>
                            @endif
                        </div>

                        {{-- Content Side --}}
                        <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col justify-between">
                            <div>
                                <h3
                                    class="text-3xl font-bold text-slate-900 mb-4 group-hover:text-teal-600 transition-colors">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                                    {{ $project->description }}
                                </p>

                                {{-- Stats Grid --}}
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                                    @if ($project->duration)
                                        <div>
                                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                                Timeline</div>
                                            <div class="font-semibold text-slate-900">{{ $project->duration }}</div>
                                        </div>
                                    @endif
                                    @if ($project->users)
                                        <div>
                                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                                Impact</div>
                                            <div class="font-semibold text-slate-900">{{ $project->users }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-8 border-t border-slate-100">
                                <button @click="expanded = !expanded"
                                    class="text-sm font-bold text-slate-900 flex items-center space-x-2 hover:text-teal-600 transition-colors focus:outline-none">
                                    <span x-text="expanded ? 'Hide Details' : 'Read Case Study'">Read Case Study</span>
                                    <i class="fa-solid fa-chevron-down transition-transform duration-300"
                                        :class="{ 'rotate-180': expanded }"></i>
                                </button>

                                @if ($project->external_link)
                                    <a href="{{ $project->external_link }}"
                                        class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-teal-500 hover:border-teal-500 hover:text-white transition-all">
                                        <i class="fa-solid fa-external-link-alt text-sm"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Expandable Content --}}
                    <div x-show="expanded" x-collapse style="display: none;">
                        <div class="p-8 lg:p-12 bg-slate-50 border-t border-slate-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 mb-4">The Challenge</h4>
                                    <p class="text-slate-600 leading-relaxed text-sm mb-6">
                                        Detailed breakdown of the problem statement, user friction points, and business
                                        constraints that initiated this project.
                                    </p>

                                    <h4 class="text-lg font-bold text-slate-900 mb-4">My Role</h4>
                                    <ul class="space-y-2 text-sm text-slate-600">
                                        <li class="flex items-start space-x-2">
                                            <i class="fa-solid fa-check text-teal-500 mt-1"></i>
                                            <span>Led discovery and user research</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <i class="fa-solid fa-check text-teal-500 mt-1"></i>
                                            <span>Defined roadmap and KPIs</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <i class="fa-solid fa-check text-teal-500 mt-1"></i>
                                            <span>Collaborated with Engineering and Design</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 mb-4">The Solution</h4>
                                    <p class="text-slate-600 leading-relaxed text-sm mb-6">
                                        How we approached the solution, including key features, architectural decisions,
                                        and the iteration process.
                                    </p>

                                    <div class="bg-white p-6 rounded-xl border border-slate-200">
                                        <h4 class="text-sm font-bold text-slate-900 mb-3">Key Results</h4>
                                        <div class="space-y-3">
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="text-slate-500">Conversion Rate</span>
                                                <span class="font-bold text-green-600">+15%</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-green-500 w-[15%]"></div>
                                            </div>

                                            <div class="flex justify-between items-center text-sm pt-2">
                                                <span class="text-slate-500">User Retention</span>
                                                <span class="font-bold text-blue-600">+22%</span>
                                            </div>
                                            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-blue-500 w-[22%]"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
