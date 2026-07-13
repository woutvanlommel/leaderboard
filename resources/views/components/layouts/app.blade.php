{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Welkom op onze website.' }}">

    <meta property="og:title" content="{{ $title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Welkom op onze website.' }}">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/IDUNA-favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Iduna" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen bg-background text-secondary-500">
        <x-navbar />

        <main>
            {{ $slot }}
        </main>

        <x-footer />
    </div>
</body>

</html>