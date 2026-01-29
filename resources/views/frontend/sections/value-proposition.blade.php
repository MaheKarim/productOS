{{-- Value Proposition & Quick Access Hub --}}
<section id="value-proposition" class="relative pt-28 pb-24 overflow-hidden min-h-[85vh] flex items-center">
    {{-- Premium Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>

    {{-- Three.js Canvas for Floating 3D Elements --}}
    <canvas id="hero-threejs-canvas" class="absolute inset-0 w-full h-full z-[1] pointer-events-none"></canvas>

    {{-- Animated Orbs --}}
    <div class="absolute inset-0 overflow-hidden z-[2]">
        <div class="absolute top-20 left-10 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-cyan-500/10 rounded-full blur-3xl">
        </div>
    </div>

    {{-- Grid Pattern --}}
    <div
        class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px] z-[3]">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        {{-- Header Content --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-cyan-200 rounded-full text-sm font-semibold mb-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Product Manager OS
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Empower Your<br>
                <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400 bg-clip-text text-transparent">
                    Product Management Journey
                </span>
            </h1>

            <p class="text-lg md:text-xl text-blue-100/80 mb-10 leading-relaxed max-w-3xl mx-auto">
                Save time, gain insights, and streamline your workflows with free tools, summaries, and resources
                designed specifically for Product Managers.
            </p>
        </div>

        {{-- Feature Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12" data-aos="fade-up" data-aos-delay="200">
            {{-- YouTube Summarizer --}}
            <a href="{{ route('yt-summarize.index') }}"
                class="group bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 hover:border-cyan-400/40 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">YouTube Summarizer</h3>
                <p class="text-blue-100/60 text-sm leading-relaxed">Get concise summaries and key takeaways from any
                    YouTube video.</p>
            </a>

            {{-- Book Summarizer --}}
            <a href="{{ route('books.index') }}"
                class="group bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 hover:border-cyan-400/40 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">Book Summarizer</h3>
                <p class="text-blue-100/60 text-sm leading-relaxed">Chapter-wise summaries of essential PM and business
                    books.</p>
            </a>

            {{-- PM Calculators --}}
            <a href="{{ route('tools.index') }}"
                class="group bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 hover:border-cyan-400/40 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">PM Calculators</h3>
                <p class="text-blue-100/60 text-sm leading-relaxed">ROI, prioritization, sprint planning, and more
                    essential tools.</p>
            </a>

            {{-- PM Directory --}}
            <a href="{{ route('directory.index') }}"
                class="group bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/15 hover:border-cyan-400/40 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">PM Directory</h3>
                <p class="text-blue-100/60 text-sm leading-relaxed">Curated tools, frameworks, communities, and
                    resources.</p>
            </a>
        </div>

        {{-- Primary CTA --}}
        <div class="text-center" data-aos="fade-up" data-aos-delay="400">
            <a href="#features-hub"
                class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all hover:shadow-lg hover:shadow-blue-500/25 hover:-translate-y-1 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                Explore All Tools
            </a>
        </div>

        {{-- Stats Row --}}
        <div class="flex flex-wrap justify-center gap-8 md:gap-16 mt-16 pt-8 border-t border-white/10"
            x-data="{ shown: false }" x-intersect="shown = true">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white" x-show="shown" x-transition>20+</div>
                <div class="text-sm text-blue-200/60 mt-1">Free PM Tools</div>
            </div>
            <div class="hidden md:block w-px h-12 bg-white/10"></div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white" x-show="shown" x-transition>10k+</div>
                <div class="text-sm text-blue-200/60 mt-1">Summaries Generated</div>
            </div>
            <div class="hidden md:block w-px h-12 bg-white/10"></div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent"
                    x-show="shown" x-transition>5k+</div>
                <div class="text-sm text-blue-200/60 mt-1">Active PMs</div>
            </div>
        </div>
    </div>

    {{-- Bottom Wave --}}
    <div class="absolute bottom-0 left-0 right-0 z-[5]">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path
                d="M0 80L60 74.7C120 69 240 59 360 53.3C480 48 600 48 720 53.3C840 59 960 69 1080 69.3C1200 69 1320 59 1380 53.3L1440 48V80H1380C1320 80 1200 80 1080 80C960 80 840 80 720 80C600 80 480 80 360 80C240 80 120 80 60 80H0Z"
                fill="white" />
        </svg>
    </div>
</section>

{{-- Three.js Script for Floating 3D Polygeometry Objects --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    (function() {
        // Check for reduced motion preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const canvas = document.getElementById('hero-threejs-canvas');
        if (!canvas) return;

        // Scene Setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 20; // Closer camera for larger shapes

        const renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            alpha: true,
            antialias: true
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        // Floating Objects Array
        const floatingObjects = [];

        // Colors matching the design system - brighter for visibility
        const colors = {
            cyan: 0x22d3ee,
            blue: 0x60a5fa,
            purple: 0xc084fc,
            emerald: 0x34d399,
            rose: 0xfb7185,
            amber: 0xfbbf24
        };

        // Create wireframe material with higher opacity
        function createGlowMaterial(color, opacity = 0.8) {
            return new THREE.MeshBasicMaterial({
                color: color,
                wireframe: true,
                transparent: true,
                opacity: opacity
            });
        }

        // 1. Rocket (Cone + Cylinder) - Top Left
        function createRocket() {
            const group = new THREE.Group();

            // Rocket body (cone)
            const coneGeometry = new THREE.ConeGeometry(0.8, 2.5, 6);
            const coneMaterial = createGlowMaterial(colors.rose, 0.7);
            const cone = new THREE.Mesh(coneGeometry, coneMaterial);
            cone.position.y = 0.5;
            group.add(cone);

            // Rocket base (cylinder)
            const cylGeometry = new THREE.CylinderGeometry(0.6, 0.8, 1, 6);
            const cylMaterial = createGlowMaterial(colors.amber, 0.5);
            const cylinder = new THREE.Mesh(cylGeometry, cylMaterial);
            cylinder.position.y = -1;
            group.add(cylinder);

            // Fins (small tetrahedrons)
            const finGeometry = new THREE.TetrahedronGeometry(0.4);
            const finMaterial = createGlowMaterial(colors.rose, 0.4);
            for (let i = 0; i < 3; i++) {
                const fin = new THREE.Mesh(finGeometry, finMaterial);
                fin.position.y = -1.5;
                fin.position.x = Math.cos((i * 2 * Math.PI) / 3) * 0.7;
                fin.position.z = Math.sin((i * 2 * Math.PI) / 3) * 0.7;
                group.add(fin);
            }

            group.position.set(-10, 5, -3);
            group.rotation.z = -0.3;
            return group;
        }

        // 2. Book (Box) - Top Right
        function createBook() {
            const group = new THREE.Group();

            // Book cover (box)
            const bookGeometry = new THREE.BoxGeometry(2.5, 0.4, 3);
            const bookMaterial = createGlowMaterial(colors.emerald, 0.7);
            const book = new THREE.Mesh(bookGeometry, bookMaterial);
            group.add(book);

            // Pages (smaller boxes)
            const pagesGeometry = new THREE.BoxGeometry(2.3, 0.3, 2.8);
            const pagesMaterial = createGlowMaterial(colors.cyan, 0.4);
            const pages = new THREE.Mesh(pagesGeometry, pagesMaterial);
            pages.position.y = 0.1;
            group.add(pages);

            group.position.set(9, 4, -4);
            group.rotation.x = 0.2;
            group.rotation.z = 0.1;
            return group;
        }

        // 3. Orb/Ball (Icosahedron for low-poly look) - Bottom Left
        function createOrb() {
            const geometry = new THREE.IcosahedronGeometry(2, 1);
            const material = createGlowMaterial(colors.blue, 0.6);
            const orb = new THREE.Mesh(geometry, material);

            orb.position.set(-8, -3, -5);
            return orb;
        }

        // 4. AI Brain (Dodecahedron) - Bottom Right
        function createAIBrain() {
            const group = new THREE.Group();

            // Main brain shape
            const brainGeometry = new THREE.DodecahedronGeometry(1.8, 0);
            const brainMaterial = createGlowMaterial(colors.purple, 0.7);
            const brain = new THREE.Mesh(brainGeometry, brainMaterial);
            group.add(brain);

            // Inner core (smaller octahedron)
            const coreGeometry = new THREE.OctahedronGeometry(0.8, 0);
            const coreMaterial = createGlowMaterial(colors.cyan, 0.5);
            const core = new THREE.Mesh(coreGeometry, coreMaterial);
            group.add(core);

            // Orbiting particles (small tetrahedrons)
            for (let i = 0; i < 4; i++) {
                const particleGeometry = new THREE.TetrahedronGeometry(0.3);
                const particleMaterial = createGlowMaterial(colors.amber, 0.6);
                const particle = new THREE.Mesh(particleGeometry, particleMaterial);
                particle.position.x = Math.cos((i * Math.PI) / 2) * 2.5;
                particle.position.z = Math.sin((i * Math.PI) / 2) * 2.5;
                particle.userData.orbitAngle = (i * Math.PI) / 2;
                particle.userData.orbitRadius = 2.5;
                particle.userData.isOrbiting = true;
                group.add(particle);
            }

            group.position.set(8, -2, -3);
            return group;
        }

        // 5. Extra floating polyhedrons for depth
        function createFloatingTetrahedron(x, y, z, color, scale = 1) {
            const geometry = new THREE.TetrahedronGeometry(0.6 * scale, 0);
            const material = createGlowMaterial(color, 0.4);
            const mesh = new THREE.Mesh(geometry, material);
            mesh.position.set(x, y, z);
            return mesh;
        }

        function createFloatingOctahedron(x, y, z, color, scale = 1) {
            const geometry = new THREE.OctahedronGeometry(0.5 * scale, 0);
            const material = createGlowMaterial(color, 0.35);
            const mesh = new THREE.Mesh(geometry, material);
            mesh.position.set(x, y, z);
            return mesh;
        }

        // Add main objects
        const rocket = createRocket();
        scene.add(rocket);
        floatingObjects.push({
            mesh: rocket,
            floatSpeed: 0.5,
            floatOffset: 0,
            rotateSpeed: 0.3
        });

        const book = createBook();
        scene.add(book);
        floatingObjects.push({
            mesh: book,
            floatSpeed: 0.4,
            floatOffset: 1,
            rotateSpeed: 0.2
        });

        const orb = createOrb();
        scene.add(orb);
        floatingObjects.push({
            mesh: orb,
            floatSpeed: 0.6,
            floatOffset: 2,
            rotateSpeed: 0.4
        });

        const aiBrain = createAIBrain();
        scene.add(aiBrain);
        floatingObjects.push({
            mesh: aiBrain,
            floatSpeed: 0.35,
            floatOffset: 0.5,
            rotateSpeed: 0.25
        });

        // Add scattered small polyhedrons - positioned for visibility
        const smallShapes = [
            createFloatingTetrahedron(-12, 1, -8, colors.cyan, 1.5),
            createFloatingTetrahedron(12, -1, -7, colors.purple, 1.2),
            createFloatingOctahedron(-6, -5, -9, colors.blue, 1.8),
            createFloatingOctahedron(5, 6, -6, colors.emerald, 1.3),
            createFloatingTetrahedron(0, 7, -10, colors.rose, 1.4),
            createFloatingOctahedron(-3, 3, -7, colors.amber, 1.2),
            createFloatingTetrahedron(7, -6, -8, colors.cyan, 1.5),
        ];

        smallShapes.forEach((shape, i) => {
            scene.add(shape);
            floatingObjects.push({
                mesh: shape,
                floatSpeed: 0.3 + Math.random() * 0.4,
                floatOffset: i * 0.7,
                rotateSpeed: 0.2 + Math.random() * 0.3
            });
        });

        // Animation
        let time = 0;

        function animate() {
            requestAnimationFrame(animate);

            if (prefersReducedMotion) {
                renderer.render(scene, camera);
                return;
            }

            time += 0.01;

            floatingObjects.forEach(obj => {
                // Floating motion
                obj.mesh.position.y += Math.sin(time * obj.floatSpeed + obj.floatOffset) * 0.003;

                // Rotation
                obj.mesh.rotation.x += 0.002 * obj.rotateSpeed;
                obj.mesh.rotation.y += 0.003 * obj.rotateSpeed;

                // Handle orbiting particles in AI brain
                obj.mesh.children.forEach(child => {
                    if (child.userData.isOrbiting) {
                        child.userData.orbitAngle += 0.01;
                        child.position.x = Math.cos(child.userData.orbitAngle) * child.userData
                            .orbitRadius;
                        child.position.z = Math.sin(child.userData.orbitAngle) * child.userData
                            .orbitRadius;
                    }
                });
            });

            renderer.render(scene, camera);
        }

        animate();

        // Handle resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    })();
</script>
