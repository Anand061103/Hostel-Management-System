<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Choose Your Plan - ApartmentHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-slate-950 text-white">

    {{-- =========================================================
        PAGE
    ========================================================== --}}

    <div class="min-h-screen">


        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <header class="border-b border-slate-800 bg-slate-950">

            <div
                class="mx-auto flex max-w-7xl items-center
                       justify-between px-6 py-5
                       lg:px-10">

                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">

                    <span class="text-white">Apartment</span><span class="text-blue-500">Hub</span>

                </a>


                <div class="text-sm text-slate-500">

                    Apartment Management

                </div>

            </div>

        </header>



        {{-- =========================================================
            MAIN
        ========================================================== --}}

        <main class="mx-auto max-w-7xl px-6 py-14 lg:px-8">


            {{-- =====================================================
                HEADING
            ====================================================== --}}

            <div class="mx-auto max-w-2xl text-center">

                <p class="text-sm font-semibold uppercase
                          tracking-widest text-blue-400">

                    Choose Your Plan

                </p>


                <h1 class="mt-4 text-4xl font-bold
                           tracking-tight sm:text-5xl">

                    Start managing your apartment

                </h1>


                <p class="mt-4 text-base leading-7
                          text-slate-400">

                    Choose a plan that fits your apartment property.
                    You can continue to set up your property after selecting a plan.

                </p>

            </div>



            {{-- =====================================================
                SUCCESS MESSAGE
            ====================================================== --}}

            @if (session('success'))
                <div
                    class="mx-auto mt-8 max-w-2xl rounded-xl
                           border border-green-500/20
                           bg-green-500/10
                           px-5 py-4
                           text-center text-sm
                           text-green-400">

                    {{ session('success') }}

                </div>
            @endif



            {{-- =====================================================
                CURRENT SELECTED PLAN
            ====================================================== --}}

            @if (session('selected_apartment_plan'))

                <div class="mx-auto mt-5 max-w-2xl text-center">

                    <span
                        class="inline-flex items-center
                               rounded-full
                               border border-blue-500/20
                               bg-blue-500/10
                               px-4 py-2
                               text-sm text-blue-400">

                        Selected:

                        <span class="ml-1 font-semibold">

                            @if (session('selected_apartment_plan') === 'trial')
                                7 Days Free Trial
                            @elseif (session('selected_apartment_plan') === '399')
                                ₹399 / Month
                            @elseif (session('selected_apartment_plan') === '999')
                                ₹999 / Month
                            @endif

                        </span>

                    </span>

                </div>

            @endif



            {{-- =====================================================
                PLANS
            ====================================================== --}}

            <div
                class="mx-auto mt-12 grid max-w-7xl
                       grid-cols-1 gap-6
                       lg:grid-cols-3">


                {{-- =================================================
                    7 DAYS FREE TRIAL
                ================================================== --}}

                <div
                    class="flex flex-col rounded-2xl
                           border border-slate-800
                           bg-slate-900
                           p-6
                           transition
                           hover:border-slate-700">

                    <div class="flex-1">

                        <div
                            class="inline-flex rounded-lg
                                   bg-slate-800
                                   px-3 py-1
                                   text-xs font-semibold
                                   text-slate-300">

                            FREE TRIAL

                        </div>


                        <h2 class="mt-5 text-2xl font-bold">

                            7 Days Free

                        </h2>


                        <p class="mt-2 text-sm leading-5
                                  text-slate-400">

                            Try ApartmentHub for 7 days
                            before choosing a paid plan.

                        </p>


                        <div class="mt-5">

                            <span class="text-4xl font-bold">

                                ₹0

                            </span>

                            <span class="text-sm text-slate-500">

                                / 7 days

                            </span>

                        </div>


                        <div class="mt-6 space-y-3">

                            <div class="flex gap-3 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                7 days access

                            </div>


                            <div class="flex gap-3 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                Apartment management

                            </div>


                            <div class="flex gap-3 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                Set up your property

                            </div>

                        </div>

                    </div>


                    <form action="{{ route('apartment.plans.select') }}" method="POST" class="mt-6">

                        @csrf

                        <input type="hidden" name="plan" value="trial">


                        <button type="submit"
                            class="w-full rounded-xl
                                   border border-slate-700
                                   bg-slate-800
                                   px-5 py-3.5
                                   text-sm font-semibold
                                   text-white
                                   transition
                                   hover:bg-slate-700">

                            Start Free Trial

                        </button>

                    </form>

                </div>



                {{-- =================================================
                    ₹399 SINGLE PROPERTY
                ================================================== --}}

                <div
                    class="relative flex flex-col
                           rounded-2xl
                           border border-blue-500/40
                           bg-slate-900
                           p-6
                           shadow-xl
                           shadow-blue-950/20">


                    {{-- BADGE --}}

                    <div
                        class="absolute -top-3 left-1/2
                               -translate-x-1/2
                               rounded-full
                               bg-blue-600
                               px-4 py-1
                               text-xs font-semibold
                               text-white">

                        SINGLE PROPERTY

                    </div>


                    <div class="flex-1">

                        <div
                            class="inline-flex rounded-lg
                                   bg-blue-500/10
                                   px-3 py-1
                                   text-xs font-semibold
                                   text-blue-400">

                            MONTHLY

                        </div>


                        <h2 class="mt-5 text-2xl font-bold">

                            Single Property

                        </h2>


                        <p class="mt-2 text-sm leading-5
                                  text-slate-400">

                            For owners managing a single
                            apartment property.

                        </p>


                        <div class="mt-5">

                            <span class="text-4xl font-bold">

                                ₹399

                            </span>

                            <span class="text-sm text-slate-500">

                                / month

                            </span>

                        </div>


                        {{-- FEATURES - TWO COLUMNS --}}

                        <div class="mt-6 grid grid-cols-2
                                   gap-x-5 gap-y-3">

                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                <span>Apartment management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                <span>Building / block management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                <span>Flats & units</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                <span>Resident management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                <span>Maintenance management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-blue-400">✓</span>

                                <span>Complaints & notices</span>

                            </div>

                        </div>

                    </div>


                    <form action="{{ route('apartment.plans.select') }}" method="POST" class="mt-6">

                        @csrf

                        <input type="hidden" name="plan" value="399">


                        <button type="submit"
                            class="w-full rounded-xl
                                   bg-blue-600
                                   px-5 py-3.5
                                   text-sm font-semibold
                                   text-white
                                   transition
                                   hover:bg-blue-500">

                            Choose ₹399 Plan

                        </button>

                    </form>

                </div>



                {{-- =================================================
                    ₹999 MULTI PROPERTY
                ================================================== --}}

                <div
                    class="relative flex flex-col
                           rounded-2xl
                           border border-purple-500/40
                           bg-slate-900
                           p-6">


                    {{-- BADGE --}}

                    <div
                        class="absolute -top-3 left-1/2
                               -translate-x-1/2
                               rounded-full
                               bg-purple-600
                               px-4 py-1
                               text-xs font-semibold
                               text-white">

                        MULTI PROPERTY

                    </div>


                    <div class="flex-1">

                        <div
                            class="inline-flex rounded-lg
                                   bg-purple-500/10
                                   px-3 py-1
                                   text-xs font-semibold
                                   text-purple-400">

                            MONTHLY

                        </div>


                        <h2 class="mt-5 text-2xl font-bold">

                            Multi-Property

                        </h2>


                        <p class="mt-2 text-sm leading-5
                                  text-slate-400">

                            For owners managing multiple
                            apartment properties.

                        </p>


                        <div class="mt-5">

                            <span class="text-4xl font-bold">

                                ₹999

                            </span>

                            <span class="text-sm text-slate-500">

                                / month

                            </span>

                        </div>


                        {{-- FEATURES - TWO COLUMNS --}}

                        <div class="mt-6 grid grid-cols-2
                                   gap-x-5 gap-y-3">

                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Multiple property management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Owner dashboard</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Building / block management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Flats & units</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Resident management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Maintenance management</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Complaints & notices</span>

                            </div>


                            <div class="flex gap-2 text-sm text-slate-300">

                                <span class="text-purple-400">✓</span>

                                <span>Property-wise reports</span>

                            </div>

                        </div>

                    </div>


                    <form action="{{ route('apartment.plans.select') }}" method="POST" class="mt-6">

                        @csrf

                        <input type="hidden" name="plan" value="999">


                        <button type="submit"
                            class="w-full rounded-xl
                                   bg-purple-600
                                   px-5 py-3.5
                                   text-sm font-semibold
                                   text-white
                                   transition
                                   hover:bg-purple-500">

                            Choose ₹999 Plan

                        </button>

                    </form>

                </div>


            </div>



            {{-- =====================================================
                FOOTER NOTE
            ====================================================== --}}

            <div
                class="mx-auto mt-8 max-w-3xl
                       text-center text-xs
                       leading-6 text-slate-600">

                You can continue with your apartment setup
                after selecting a plan.

            </div>


        </main>

    </div>

</body>

</html>
