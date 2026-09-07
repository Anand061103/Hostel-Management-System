@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
            Dashboard Content
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Overview of your hostel management system
        </p>
    </div>


    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

    <x-stat-card
        title="Total Students"
        value="1,248"
        subtitle="+12 this month"
        icon="👨‍🎓"
    />

    <x-stat-card
        title="Total Rooms"
        value="120"
        subtitle="85% occupied"
        icon="🏠"
    />

    <x-stat-card
        title="Total Beds"
        value="480"
        subtitle="32 available"
        icon="🛏️"
    />

    <x-stat-card
        title="Fees Collected"
        value="₹2.4L"
        subtitle="+8.5% this month"
        icon="💰"
    />

</div>

{{-- Occupancy Overview --}}
{{-- Overview Section --}}
<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

    {{-- Occupancy Overview --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Occupancy Overview
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Current room occupancy
            </p>
        </div>

        <div class="grid grid-cols-3 gap-4">

            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Total Rooms
                </p>

                <p class="mt-1 text-xl font-bold text-slate-800 dark:text-white">
                    120
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Occupied
                </p>

                <p class="mt-1 text-xl font-bold text-blue-600">
                    102
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Available
                </p>

                <p class="mt-1 text-xl font-bold text-emerald-600">
                    18
                </p>
            </div>

        </div>

        <div class="mt-5">

            <div class="mb-2 flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Occupancy Rate
                </span>

                <span class="text-xs font-semibold text-slate-800 dark:text-white">
                    85%
                </span>
            </div>

            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                <div class="h-full w-[85%] rounded-full bg-blue-600"></div>
            </div>

        </div>

    </div>


    {{-- Fee Collection Status --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Fee Collection Status
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Current fee collection overview
            </p>
        </div>

        <div class="grid grid-cols-3 gap-4">

            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Total Fees
                </p>

                <p class="mt-1 text-xl font-bold text-slate-800 dark:text-white">
                    ₹5.0L
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Collected
                </p>

                <p class="mt-1 text-xl font-bold text-emerald-600">
                    ₹4.2L
                </p>
            </div>

            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Pending
                </p>

                <p class="mt-1 text-xl font-bold text-red-500">
                    ₹80K
                </p>
            </div>

        </div>

        <div class="mt-5">

            <div class="mb-2 flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Collection Rate
                </span>

                <span class="text-xs font-semibold text-slate-800 dark:text-white">
                    84%
                </span>
            </div>

            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                <div class="h-full w-[84%] rounded-full bg-emerald-500"></div>
            </div>

        </div>

    </div>

</div>

{{-- Dashboard Activity & Today's Work --}}
<div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

    {{-- Recent Activities --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-800">

            <div>
                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Recent Activities
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Latest hostel activities
                </p>
            </div>

            <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                8 New
            </span>

        </div>


        {{-- Activities --}}
        <div class="max-h-80 overflow-y-auto">

            {{-- Activity 1 --}}
            <div class="flex items-start gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-lg dark:bg-blue-900/30">
                    👤
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        New student added
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Rahul Sharma was added to the hostel.
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        10 minutes ago
                    </p>
                </div>

            </div>


            {{-- Activity 2 --}}
            <div class="flex items-start gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-lg dark:bg-emerald-900/30">
                    💰
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Fee payment received
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Aman Verma paid ₹8,500 fees.
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        25 minutes ago
                    </p>
                </div>

            </div>


            {{-- Activity 3 --}}
            <div class="flex items-start gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-lg dark:bg-amber-900/30">
                    🔔
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        New notice posted
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Hostel maintenance notice was published.
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        1 hour ago
                    </p>
                </div>

            </div>


            {{-- Activity 4 --}}
            <div class="flex items-start gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-100 text-lg dark:bg-purple-900/30">
                    🏠
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Room allocated
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Room A-204 was allocated to Priya Singh.
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        2 hours ago
                    </p>
                </div>

            </div>


            {{-- Activity 5 --}}
            <div class="flex items-start gap-4 px-5 py-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-lg dark:bg-red-900/30">
                    ⚠️
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        New complaint received
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Fan not working in room B-102.
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        3 hours ago
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Today's Work --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-800">

            <div>
                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Today's Work
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Tasks that need attention today
                </p>
            </div>

            <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-600 dark:bg-red-900/30 dark:text-red-400">
                5 Pending
            </span>

        </div>


        {{-- Today's Tasks --}}
        <div class="max-h-80 overflow-y-auto">

            {{-- Task 1 --}}
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-lg dark:bg-amber-900/30">
                    💰
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Rahul Sharma
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Monthly fee payment due today
                    </p>
                </div>

                <span class="shrink-0 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-600 dark:bg-red-900/30 dark:text-red-400">
                    Fee Due
                </span>

            </div>


            {{-- Task 2 --}}
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-lg dark:bg-blue-900/30">
                    📅
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Priya Singh
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        One month stay completed today
                    </p>
                </div>

                <span class="shrink-0 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                    Due
                </span>

            </div>


            {{-- Task 3 --}}
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-lg dark:bg-red-900/30">
                    🚪
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Rohit Yadav
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Checkout scheduled for today
                    </p>
                </div>

                <span class="shrink-0 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-600 dark:bg-red-900/30 dark:text-red-400">
                    Checkout
                </span>

            </div>


            {{-- Task 4 --}}
            <div class="flex items-center gap-4 border-b border-slate-100 px-5 py-4 dark:border-slate-800">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-100 text-lg dark:bg-purple-900/30">
                    🛏️
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Aman Verma
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Bed allocation needs confirmation
                    </p>
                </div>

                <span class="shrink-0 rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                    Action
                </span>

            </div>


            {{-- Task 5 --}}
            <div class="flex items-center gap-4 px-5 py-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-lg dark:bg-emerald-900/30">
                    📋
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">
                        Neha Patel
                    </p>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Documents verification pending
                    </p>
                </div>

                <span class="shrink-0 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    Pending
                </span>

            </div>

        </div>

    </div>

</div>


</div>
@endsection