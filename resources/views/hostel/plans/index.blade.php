<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Choose Your Plan - HostelHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="min-h-screen bg-slate-950 text-white">


    {{-- =========================================================
        PAGE
    ========================================================== --}}

    <div class="min-h-screen">


        {{-- HEADER --}}
        <header class="border-b border-slate-800 bg-slate-950">

            <div
                class="mx-auto flex max-w-7xl items-center
                       justify-between px-6 py-5
                       lg:px-10">

                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight">
                    <span class="text-white">Hostel</span><span class="text-blue-500">Hub</span>
                </a>


                <div class="text-sm text-slate-500">
                    Hostel Management
                </div>

            </div>

        </header>


        {{-- MAIN --}}
        <main class="mx-auto max-w-7xl px-6 py-16 lg:px-10">


            {{-- HEADING --}}
            <div class="mx-auto max-w-2xl text-center">

                <p class="text-sm font-semibold uppercase
                           tracking-widest text-blue-400">
                    Choose Your Plan
                </p>


                <h1 class="mt-4 text-4xl font-bold
                           tracking-tight sm:text-5xl">
                    Start managing your hostel
                </h1>


                <p class="mt-5 text-base leading-7
                           text-slate-400">
                    Choose a plan that fits your hostel.
                    You can continue to set up your hostel
                    after selecting a plan.
                </p>

            </div>


            {{-- SUCCESS MESSAGE --}}
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


            {{-- CURRENT SELECTED PLAN --}}
            @if (session('selected_hostel_plan'))

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

                            @if (session('selected_hostel_plan') === 'trial')
                                7 Days Free Trial
                            @elseif (session('selected_hostel_plan') === '399')
                                ₹399 / Month
                            @elseif (session('selected_hostel_plan') === '999')
                                ₹999 / Month
                            @endif

                        </span>
                    </span>

                </div>

            @endif


            {{-- PLANS --}}
            <div
                class="mx-auto mt-14 grid max-w-6xl
                       grid-cols-1 gap-6
                       lg:grid-cols-3">


                {{-- =================================================
                    7 DAYS FREE TRIAL
                ================================================== --}}

                <div
                    class="flex flex-col rounded-2xl
                           border border-slate-800
                           bg-slate-900
                           p-7
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


                        <h2 class="mt-6 text-2xl font-bold">
                            7 Days Free
                        </h2>


                        <p class="mt-3 text-sm leading-6
                                   text-slate-400">
                            Try HostelHub for 7 days
                            before choosing a paid plan.
                        </p>


                        <div class="mt-7">

                            <span class="text-4xl font-bold">
                                ₹0
                            </span>

                            <span class="text-sm text-slate-500">
                                / 7 days
                            </span>

                        </div>


                        <div class="mt-8 space-y-4">

                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                7 days access
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Hostel management
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Set up your hostel
                            </div>

                        </div>

                    </div>


                    <form action="{{ route('hostel.plans.select') }}" method="POST" class="mt-8">

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
                    ₹399
                ================================================== --}}

                <div
                    class="relative flex flex-col
                           rounded-2xl
                           border border-blue-500/40
                           bg-slate-900
                           p-7
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
                        SIMPLE
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


                        <h2 class="mt-6 text-2xl font-bold">
                            Hostel Basic
                        </h2>


                        <p class="mt-3 text-sm leading-6
                                   text-slate-400">
                            For owners managing
                            a single hostel.
                        </p>


                        <div class="mt-7">

                            <span class="text-4xl font-bold">
                                ₹399
                            </span>

                            <span class="text-sm text-slate-500">
                                / month
                            </span>

                        </div>


                        <div class="mt-8 space-y-4">

                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Hostel management
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Student management
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Rooms & beds
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-blue-400">✓</span>
                                Fees management
                            </div>

                        </div>

                    </div>


                    <form action="{{ route('hostel.plans.select') }}" method="POST" class="mt-8">

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
                    ₹999
                ================================================== --}}

                <div
                    class="relative flex flex-col
                           rounded-2xl
                           border border-purple-500/40
                           bg-slate-900
                           p-7">

                    <div
                        class="absolute -top-3 left-1/2
                               -translate-x-1/2
                               rounded-full
                               bg-purple-600
                               px-4 py-1
                               text-xs font-semibold
                               text-white">
                        MULTI HOSTEL
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


                        <h2 class="mt-6 text-2xl font-bold">
                            Hostel Pro
                        </h2>


                        <p class="mt-3 text-sm leading-6
                                   text-slate-400">
                            For owners managing
                            multiple hostels.
                        </p>


                        <div class="mt-7">

                            <span class="text-4xl font-bold">
                                ₹999
                            </span>

                            <span class="text-sm text-slate-500">
                                / month
                            </span>

                        </div>


                        <div class="mt-8 space-y-4">

                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Multiple hostel management
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Owner dashboard
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Warden management
                            </div>


                            <div class="flex gap-3 text-sm
                                       text-slate-300">
                                <span class="text-purple-400">✓</span>
                                Advanced management
                            </div>

                        </div>

                    </div>


                    <form action="{{ route('hostel.plans.select') }}" method="POST" class="mt-8">

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


            {{-- FOOTER NOTE --}}
            <div
                class="mx-auto mt-10 max-w-3xl
                       text-center text-xs
                       leading-6 text-slate-600">
                You can continue with your hostel setup
                after selecting a plan.
            </div>

        </main>

    </div>

</body>

</html>
