<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Hostel Management')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-white">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Area --}}
        <div class="flex min-w-0 flex-1 flex-col">

            {{-- Navbar --}}
            @include('components.navbar')

            {{-- Page Content --}}
            <main class="flex-1">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>