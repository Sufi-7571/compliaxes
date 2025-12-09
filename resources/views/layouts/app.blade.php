<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CompliAxe - Web Accessibility Solutions For ADA & WCAG Compliance' }}</title>
    {{-- Icon --}}
    <link rel="icon" href="{{ asset('images/web-icon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <x-navigation />

    <!-- Main Content -->
    <main class="pt-16">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer />
</body>

</html>
