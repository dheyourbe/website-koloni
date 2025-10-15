<!DOCTYPE html>
<html class="scroll-smooth scroll-pt-20">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}" />
    <title>{{ $title ?? config('app.name', 'KoloniCoffee') }}</title>
</head>

<body class="america overflow-x-hidden">
    <x-navigation />

    <main>
        {{ $header ?? '' }}
        {{ $slot }}
    </main>

    @include('components.footer')

    <!-- Include Alpine.js for dropdown functionality -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>