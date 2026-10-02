<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HostelHub — Hostel & Apartment Management</title>

    <meta name="description" content="Manage hostels and apartments from one powerful platform.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-white antialiased">

    {{-- ============================================================
        NAVBAR
    ============================================================ --}}
    <header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-slate-950/80 backdrop-blur-xl">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 shadow-lg shadow-blue-600/30">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10.5L12 3l9 7.5M5 9.5V21h14V9.5M9 21v-6h6v6" />
                    </svg>
                </div>

                <span class="text-xl font-bold tracking-tight">
                    Hostel<span class="text-blue-500">Hub</span>
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-8 md:flex">
                <a href="#features" class="text-sm text-slate-300 transition hover:text-white">
                    Features
                </a>

                <a href="#how-it-works" class="text-sm text-slate-300 transition hover:text-white">
                    How It Works
                </a>

                <a href="#solutions" class="text-sm text-slate-300 transition hover:text-white">
                    Solutions
                </a>

                <a href="#pricing" class="text-sm text-slate-300 transition hover:text-white">
                    Pricing
                </a>
            </nav>

            {{-- Auth --}}
            <div class="flex items-center gap-3">

                <a href="{{ route('login') }}"
                    class="hidden rounded-lg px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white sm:block">
                    Login
                </a>

                <a href="{{ route('signup') }}"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold shadow-lg shadow-blue-600/20 transition hover:bg-blue-500">
                    Get Started
                </a>

            </div>

        </div>
    </header>


    {{-- ============================================================
        HERO
    ============================================================ --}}
    <main>

        <section class="relative overflow-hidden pt-32">

            {{-- Background glow --}}
            <div class="pointer-events-none absolute inset-0">

                <div
                    class="absolute left-1/2 top-0 h-[500px] w-[700px] -translate-x-1/2 rounded-full bg-blue-600/20 blur-[120px]">
                </div>

                <div class="absolute right-0 top-80 h-[300px] w-[300px] rounded-full bg-indigo-600/10 blur-[100px]">
                </div>

            </div>

            <div class="relative mx-auto max-w-7xl px-6 py-24 lg:px-8 lg:py-32">

                <div class="mx-auto max-w-4xl text-center">

                    {{-- Badge --}}
                    <div
                        class="mb-8 inline-flex items-center gap-2 rounded-full border border-blue-500/20 bg-blue-500/10 px-4 py-2 text-sm text-blue-300">

                        <span class="h-2 w-2 rounded-full bg-blue-400"></span>

                        Smart Property Management Platform

                    </div>

                    {{-- Heading --}}
                    <h1 class="text-5xl font-bold tracking-tight sm:text-6xl lg:text-7xl">

                        Manage your

                        <span
                            class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            property
                        </span>

                        smarter.

                    </h1>

                    {{-- Description --}}
                    <p class="mx-auto mt-7 max-w-2xl text-lg leading-8 text-slate-400 sm:text-xl">

                        A modern management platform for hostels and apartments.
                        Manage residents, rooms, beds, payments and operations
                        from one simple dashboard.

                    </p>

                    {{-- CTA --}}
                    <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">

                        <a href="{{ route('signup') }}"
                            class="w-full rounded-xl bg-blue-600 px-7 py-3.5 text-center font-semibold shadow-xl shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-500 sm:w-auto">
                            Get Started Free
                        </a>

                        <a href="#how-it-works"
                            class="w-full rounded-xl border border-white/10 bg-white/5 px-7 py-3.5 text-center font-semibold text-slate-200 transition hover:bg-white/10 sm:w-auto">
                            See How It Works
                        </a>

                    </div>

                    <p class="mt-5 text-sm text-slate-500">
                        Simple setup · Powerful management · One platform
                    </p>

                </div>


                {{-- Dashboard Preview --}}
                <div class="relative mx-auto mt-20 max-w-6xl">

                    <div class="rounded-2xl border border-white/10 bg-slate-900 p-2 shadow-2xl shadow-black/50">

                        <div class="overflow-hidden rounded-xl border border-white/10 bg-slate-950">

                            {{-- Fake browser bar --}}
                            <div class="flex h-12 items-center gap-2 border-b border-white/10 px-5">

                                <span class="h-3 w-3 rounded-full bg-red-400/70"></span>
                                <span class="h-3 w-3 rounded-full bg-yellow-400/70"></span>
                                <span class="h-3 w-3 rounded-full bg-green-400/70"></span>

                                <div class="ml-4 h-7 flex-1 rounded-md bg-white/5"></div>

                            </div>

                            {{-- Dashboard --}}
                            <div class="grid min-h-[420px] grid-cols-12">

                                {{-- Sidebar --}}
                                <div class="col-span-3 hidden border-r border-white/10 bg-slate-900 p-5 sm:block">

                                    <div class="mb-8 h-8 w-28 rounded bg-white/10"></div>

                                    <div class="space-y-3">

                                        <div class="h-9 rounded-lg bg-blue-600/20"></div>

                                        <div class="h-9 rounded-lg bg-white/5"></div>

                                        <div class="h-9 rounded-lg bg-white/5"></div>

                                        <div class="h-9 rounded-lg bg-white/5"></div>

                                        <div class="h-9 rounded-lg bg-white/5"></div>

                                    </div>

                                </div>

                                {{-- Content --}}
                                <div class="col-span-12 p-6 sm:col-span-9">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <div class="h-7 w-48 rounded bg-white/10"></div>
                                            <div class="mt-2 h-4 w-32 rounded bg-white/5"></div>
                                        </div>

                                        <div class="h-9 w-24 rounded-lg bg-blue-600/30"></div>

                                    </div>

                                    {{-- Cards --}}
                                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-5">
                                            <div class="h-3 w-20 rounded bg-white/10"></div>
                                            <div class="mt-4 h-8 w-16 rounded bg-blue-500/30"></div>
                                        </div>

                                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-5">
                                            <div class="h-3 w-20 rounded bg-white/10"></div>
                                            <div class="mt-4 h-8 w-16 rounded bg-emerald-500/30"></div>
                                        </div>

                                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-5">
                                            <div class="h-3 w-20 rounded bg-white/10"></div>
                                            <div class="mt-4 h-8 w-16 rounded bg-purple-500/30"></div>
                                        </div>

                                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-5">
                                            <div class="h-3 w-20 rounded bg-white/10"></div>
                                            <div class="mt-4 h-8 w-16 rounded bg-orange-500/30"></div>
                                        </div>

                                    </div>

                                    {{-- Large chart --}}
                                    <div class="mt-5 rounded-xl border border-white/10 bg-white/[0.03] p-6">

                                        <div class="h-4 w-40 rounded bg-white/10"></div>

                                        <div class="mt-8 flex h-40 items-end gap-3">

                                            <div class="h-[35%] flex-1 rounded-t bg-blue-500/30"></div>
                                            <div class="h-[55%] flex-1 rounded-t bg-blue-500/30"></div>
                                            <div class="h-[45%] flex-1 rounded-t bg-blue-500/30"></div>
                                            <div class="h-[70%] flex-1 rounded-t bg-blue-500/30"></div>
                                            <div class="h-[60%] flex-1 rounded-t bg-blue-500/30"></div>
                                            <div class="h-[85%] flex-1 rounded-t bg-blue-500/30"></div>
                                            <div class="h-[75%] flex-1 rounded-t bg-blue-500/30"></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ============================================================
            SOLUTIONS
        ============================================================ --}}
        <section id="solutions" class="border-y border-white/5 bg-slate-900/40">

            <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8">

                <div class="mx-auto max-w-2xl text-center">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        One platform
                    </p>

                    <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                        Built for the way you manage property
                    </h2>

                    <p class="mt-4 text-slate-400">
                        Choose the management system that fits your business.
                    </p>

                </div>


                <div class="mt-14 grid gap-8 md:grid-cols-2">

                    {{-- Hostel --}}
                    <div
                        class="group rounded-2xl border border-white/10 bg-slate-900 p-8 transition hover:-translate-y-1 hover:border-blue-500/40">

                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-500/10 text-blue-400">

                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 21V7l8-4 8 4v14M4 21h16M8 10h2m-2 4h2m4-4h2m-2 4h2M9 21v-4h6v4" />
                            </svg>

                        </div>

                        <h3 class="mt-6 text-2xl font-bold">
                            Hostel Management
                        </h3>

                        <p class="mt-3 leading-7 text-slate-400">
                            Manage students, rooms, beds, fees, security deposits,
                            wardens, complaints and daily hostel operations.
                        </p>

                        <ul class="mt-6 space-y-3 text-sm text-slate-300">

                            <li class="flex gap-3">
                                <span class="text-blue-400">✓</span>
                                Student management
                            </li>

                            <li class="flex gap-3">
                                <span class="text-blue-400">✓</span>
                                Room & bed management
                            </li>

                            <li class="flex gap-3">
                                <span class="text-blue-400">✓</span>
                                Fee & payment tracking
                            </li>

                            <li class="flex gap-3">
                                <span class="text-blue-400">✓</span>
                                Warden management
                            </li>

                        </ul>

                    </div>


                    {{-- Apartment --}}
                    <div
                        class="group rounded-2xl border border-white/10 bg-slate-900 p-8 transition hover:-translate-y-1 hover:border-purple-500/40">

                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-500/10 text-purple-400">

                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4 21V4h16v17M8 8h2m4 0h2M8 12h2m4 0h2M8 16h2m4 0h2M10 21v-3h4v3" />
                            </svg>

                        </div>

                        <h3 class="mt-6 text-2xl font-bold">
                            Apartment Management
                        </h3>

                        <p class="mt-3 leading-7 text-slate-400">
                            Manage apartments, residents, units, maintenance,
                            payments and property operations from one place.
                        </p>

                        <ul class="mt-6 space-y-3 text-sm text-slate-300">

                            <li class="flex gap-3">
                                <span class="text-purple-400">✓</span>
                                Apartment management
                            </li>

                            <li class="flex gap-3">
                                <span class="text-purple-400">✓</span>
                                Resident management
                            </li>

                            <li class="flex gap-3">
                                <span class="text-purple-400">✓</span>
                                Maintenance tracking
                            </li>

                            <li class="flex gap-3">
                                <span class="text-purple-400">✓</span>
                                Payment management
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </section>


        {{-- ============================================================
            FEATURES
        ============================================================ --}}
        <section id="features">

            <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8">

                <div class="max-w-2xl">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        Features
                    </p>

                    <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                        Everything you need to manage your property
                    </h2>

                    <p class="mt-4 text-slate-400">
                        Keep your operations organized without juggling multiple systems.
                    </p>

                </div>


                <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    @php
                        $features = [
                            [
                                'title' => 'Centralized Dashboard',
                                'description' => 'See important property information from one place.',
                                'icon' => '▦',
                            ],
                            [
                                'title' => 'Resident Management',
                                'description' => 'Keep resident and student information organized.',
                                'icon' => '◎',
                            ],
                            [
                                'title' => 'Room & Unit Management',
                                'description' => 'Track rooms, beds, units and occupancy.',
                                'icon' => '⌂',
                            ],
                            [
                                'title' => 'Payment Tracking',
                                'description' => 'Track fees, payments and outstanding balances.',
                                'icon' => '₹',
                            ],
                            [
                                'title' => 'Multiple Properties',
                                'description' => 'Manage multiple properties from one owner account.',
                                'icon' => '◇',
                            ],
                            [
                                'title' => 'Role Based Access',
                                'description' => 'Give team members access according to their responsibilities.',
                                'icon' => '✓',
                            ],
                        ];
                    @endphp


                    @foreach ($features as $feature)
                        <div
                            class="rounded-2xl border border-white/10 bg-white/[0.03] p-7 transition hover:bg-white/[0.05]">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-lg text-blue-400">
                                {{ $feature['icon'] }}
                            </div>

                            <h3 class="mt-5 text-lg font-semibold">
                                {{ $feature['title'] }}
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                {{ $feature['description'] }}
                            </p>

                        </div>
                    @endforeach

                </div>

            </div>

        </section>


        {{-- ============================================================
            HOW IT WORKS
        ============================================================ --}}
        <section id="how-it-works" class="border-y border-white/5 bg-slate-900/40">

            <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8">

                <div class="mx-auto max-w-2xl text-center">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        Simple setup
                    </p>

                    <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                        Get started in a few steps
                    </h2>

                </div>


                <div class="mt-16 grid gap-10 md:grid-cols-4">

                    @php
                        $steps = [
                            [
                                'number' => '01',
                                'title' => 'Create Account',
                                'text' => 'Create your owner account and enter your basic details.',
                            ],
                            [
                                'number' => '02',
                                'title' => 'Choose Property',
                                'text' => 'Select whether you want to manage a hostel or apartment.',
                            ],
                            [
                                'number' => '03',
                                'title' => 'Choose Plan',
                                'text' => 'Select the plan that matches your management requirements.',
                            ],
                            [
                                'number' => '04',
                                'title' => 'Start Managing',
                                'text' => 'Complete setup and start managing your property.',
                            ],
                        ];
                    @endphp


                    @foreach ($steps as $step)
                        <div class="relative text-center">

                            <div
                                class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-blue-500/30 bg-blue-500/10 font-bold text-blue-400">
                                {{ $step['number'] }}
                            </div>

                            <h3 class="mt-5 font-semibold">
                                {{ $step['title'] }}
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                {{ $step['text'] }}
                            </p>

                        </div>
                    @endforeach

                </div>

            </div>

        </section>


        {{-- ============================================================
            PRICING
        ============================================================ --}}
        <section id="pricing">

            <div class="mx-auto max-w-7xl px-6 py-24 lg:px-8">

                <div class="mx-auto max-w-2xl text-center">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        Pricing
                    </p>

                    <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                        Plans that grow with your business
                    </h2>

                    <p class="mt-4 text-slate-400">
                        Choose a plan based on how you manage your properties.
                    </p>

                </div>


                <div class="mx-auto mt-14 max-w-4xl">

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Single --}}
                        <div class="rounded-2xl border border-white/10 bg-slate-900 p-8">

                            <h3 class="text-xl font-semibold">
                                Single Property
                            </h3>

                            <p class="mt-2 text-sm text-slate-400">
                                For owners managing one property.
                            </p>

                            <div class="mt-6">

                                <span class="text-4xl font-bold">
                                    ₹399
                                </span>

                                <span class="text-slate-500">
                                    / month
                                </span>

                            </div>

                            <a href="{{ route('signup') }}"
                                class="mt-8 block rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-center font-semibold transition hover:bg-white/10">
                                Get Started
                            </a>

                        </div>


                        {{-- Multiple --}}
                        <div class="relative rounded-2xl border border-blue-500/40 bg-blue-500/[0.06] p-8">

                            <div
                                class="absolute right-5 top-5 rounded-full bg-blue-500/10 px-3 py-1 text-xs font-semibold text-blue-300">
                                Multiple Properties
                            </div>

                            <h3 class="text-xl font-semibold">
                                Multi Property
                            </h3>

                            <p class="mt-2 text-sm text-slate-400">
                                For owners managing multiple properties.
                            </p>

                            <div class="mt-6">

                                <span class="text-4xl font-bold">
                                    ₹999
                                </span>

                                <span class="text-slate-500">
                                    / month
                                </span>

                            </div>

                            <a href="{{ route('signup') }}"
                                class="mt-8 block rounded-xl bg-blue-600 px-5 py-3 text-center font-semibold transition hover:bg-blue-500">
                                Get Started
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- ============================================================
            FINAL CTA
        ============================================================ --}}
        <section class="relative overflow-hidden border-t border-white/5">

            <div class="absolute inset-0 bg-blue-600/5"></div>

            <div class="relative mx-auto max-w-4xl px-6 py-24 text-center">

                <h2 class="text-3xl font-bold sm:text-5xl">
                    Ready to simplify your property management?
                </h2>

                <p class="mx-auto mt-5 max-w-2xl text-slate-400">
                    Create your account and start building a more organized
                    property management workflow.
                </p>

                <a href="{{ route('signup') }}"
                    class="mt-8 inline-flex rounded-xl bg-blue-600 px-8 py-3.5 font-semibold shadow-xl shadow-blue-600/20 transition hover:bg-blue-500">
                    Create Your Account
                </a>

            </div>

        </section>

    </main>


    {{-- ============================================================
        FOOTER
    ============================================================ --}}
    <footer class="border-t border-white/10 bg-slate-950">

        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

            <div class="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">

                <div>

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10.5L12 3l9 7.5M5 9.5V21h14V9.5M9 21v-6h6v6" />
                            </svg>

                        </div>

                        <span class="font-bold">
                            Hostel<span class="text-blue-500">Hub</span>
                        </span>

                    </div>

                    <p class="mt-3 text-sm text-slate-500">
                        Smart management for hostels and apartments.
                    </p>

                </div>


                <div class="flex flex-wrap gap-6 text-sm text-slate-400">

                    <a href="#features" class="transition hover:text-white">
                        Features
                    </a>

                    <a href="#solutions" class="transition hover:text-white">
                        Solutions
                    </a>

                    <a href="#pricing" class="transition hover:text-white">
                        Pricing
                    </a>

                    <a href="{{ route('login') }}" class="transition hover:text-white">
                        Login
                    </a>

                </div>

            </div>


            <div class="mt-10 border-t border-white/5 pt-6 text-sm text-slate-600">

                © {{ date('Y') }} HostelHub. All rights reserved.

            </div>

        </div>

    </footer>

</body>

</html>
