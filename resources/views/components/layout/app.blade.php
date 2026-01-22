<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 antialiased scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ProductOS - Analytics-Driven Product Management' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&family=Space+Grotesk:wght@300..700&display=swap"
        rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-full flex-col font-sans text-zinc-900 selection:bg-blue-100 selection:text-blue-900">
    <div
        class="fixed inset-0 z-[-1] bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:24px_24px] opacity-40">
    </div>

    <!-- Header/Nav -->
    <x-nav />

    <!-- Main Content -->
    <main class="flex-auto relative w-full">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />
</body>

</html>
