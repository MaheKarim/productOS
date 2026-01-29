<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home') - Portfolio</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0D9488',
                        'primary-dark': '#115E59',
                        accent: '#2DD4BF',
                        surface: '#F8FAFC',
                        teal: {
                            50: '#F0FDFA',
                            100: '#CCFBF1',
                            200: '#99F6E4',
                            300: '#5EEAD4',
                            400: '#2DD4BF',
                            500: '#14B8A6',
                            600: '#0D9488',
                            700: '#0F766E',
                            800: '#115E59',
                            900: '#134E4A',
                            950: '#042F2E',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Inter', 'system-ui', 'sans-serif'], // Enhanced typography
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        }
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                        'glass-hover': '0 8px 32px 0 rgba(31, 38, 135, 0.15)',
                        'glow': '0 0 20px rgba(45, 212, 191, 0.5)',
                    }
                }
            }
        }
    </script>
    <script>
        window.FontAwesomeConfig = {
            autoReplaceSvg: 'nest'
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        html {
            scroll-behavior: smooth;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #0D9488 0%, #2DD4BF 100%);
        }

        .gradient-mesh {
            background-color: #ffffff;
            background-image: radial-gradient(at 40% 20%, hsla(168, 100%, 75%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(189, 100%, 56%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 50%, hsla(168, 100%, 93%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 50%, hsla(190, 100%, 76%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, hsla(190, 100%, 76%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 100%, hsla(168, 100%, 75%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 0%, hsla(190, 100%, 76%, 1) 0px, transparent 50%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-dark {
            background: rgba(13, 148, 136, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .shadow-level-1 {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .shadow-level-2 {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .shadow-level-3 {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .transition-default {
            transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .transition-medium {
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .transition-slow {
            transition: all 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
        }
    </style>
</head>

<body class="font-sans bg-white text-slate-700">
    <x-announcement-bar />
    <x-nav />

    <main>
        @yield('content')
    </main>

    @include('frontend.sections.footer')

    {{-- Support Section (appears after footer on all pages) --}}
    @include('frontend.sections.support-section')

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('section > div > div').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 500ms ease-out, transform 500ms ease-out';
            observer.observe(el);
        });
    </script>

    @stack('scripts')
</body>

</html>
