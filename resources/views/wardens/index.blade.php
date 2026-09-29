@extends('layouts.admin')

@section('content')
    <div class="p-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Wardens
                </h1>

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Manage hostel wardens and their assigned hostels.
                </p>
            </div>

            <a href="{{ route('wardens.create') }}"
                class="inline-flex items-center justify-center
                   rounded-lg bg-blue-600 px-5 py-2.5
                   text-sm font-medium text-white
                   hover:bg-blue-700 transition">

                + Add Warden

            </a>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-lg
                   bg-green-100 px-4 py-3
                   text-sm text-green-700
                   dark:bg-green-900/30
                   dark:text-green-400">

                {{ session('success') }}

            </div>
        @endif
        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

            {{-- Total Wardens --}}
            <div
                class="rounded-xl border border-slate-200
               bg-white p-5 shadow-sm
               dark:border-slate-800
               dark:bg-slate-900">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium
                          text-slate-500 dark:text-slate-400">
                            Total Wardens
                        </p>

                        <p class="mt-2 text-2xl font-bold
                          text-slate-800 dark:text-white">
                            {{ $totalWardens }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center
                       justify-center rounded-lg
                       bg-blue-100 text-xl
                       dark:bg-blue-900/30">

                        👨‍💼

                    </div>

                </div>

            </div>


            {{-- Assigned Wardens --}}
            <div
                class="rounded-xl border border-slate-200
               bg-white p-5 shadow-sm
               dark:border-slate-800
               dark:bg-slate-900">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium
                          text-slate-500 dark:text-slate-400">
                            Assigned Wardens
                        </p>

                        <p class="mt-2 text-2xl font-bold
                          text-slate-800 dark:text-white">
                            {{ $assignedWardens }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center
                       justify-center rounded-lg
                       bg-green-100 text-xl
                       dark:bg-green-900/30">

                        🏠

                    </div>

                </div>

            </div>


            {{-- Unassigned Wardens --}}
            <div
                class="rounded-xl border border-slate-200
               bg-white p-5 shadow-sm
               dark:border-slate-800
               dark:bg-slate-900">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium
                          text-slate-500 dark:text-slate-400">
                            Unassigned Wardens
                        </p>

                        <p class="mt-2 text-2xl font-bold
                          text-slate-800 dark:text-white">
                            {{ $unassignedWardens }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center
                       justify-center rounded-lg
                       bg-orange-100 text-xl
                       dark:bg-orange-900/30">

                        ⚠️

                    </div>

                </div>

            </div>


            {{-- Active Hostels --}}
            <div
                class="rounded-xl border border-slate-200
               bg-white p-5 shadow-sm
               dark:border-slate-800
               dark:bg-slate-900">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium
                          text-slate-500 dark:text-slate-400">
                            Active Hostels
                        </p>

                        <p class="mt-2 text-2xl font-bold
                          text-slate-800 dark:text-white">
                            {{ $activeHostels }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center
                       justify-center rounded-lg
                       bg-purple-100 text-xl
                       dark:bg-purple-900/30">

                        🏢

                    </div>

                </div>

            </div>

        </div>

        {{-- Search & Filter --}}
        <div
            class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/70">

            <form method="GET" action="{{ route('wardens.index') }}" class="flex flex-col gap-3 md:flex-row">

                {{-- Search --}}
                <div class="relative flex-1">

                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        🔍
                    </span>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white dark:placeholder-slate-500">

                </div>

                {{-- Hostel Filter --}}
                <div class="md:w-64">

                    <select name="hostel_id"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white">

                        <option value="">All Hostels</option>

                        @foreach ($hostels as $hostel)
                            <option value="{{ $hostel->id }}" {{ request('hostel_id') == $hostel->id ? 'selected' : '' }}>
                                {{ $hostel->name }}
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- Search Button --}}
                <button type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">
                    Search
                </button>

                {{-- Clear --}}
                @if (request('search') || request('hostel_id'))
                    <a href="{{ route('wardens.index') }}"
                        class="rounded-xl border border-slate-300 px-6 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Clear
                    </a>
                @endif

            </form>

        </div>


        {{-- Wardens Table --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-800
           bg-slate-900/70 shadow-xl shadow-black/10">

            <div class="overflow-x-auto">

                <table class="min-w-full text-left">

                    {{-- Table Header --}}
                    <thead class="border-b border-slate-800 bg-slate-800/60">

                        <tr>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                               tracking-wider text-slate-400">
                                Warden
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                               tracking-wider text-slate-400">
                                Email
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                               tracking-wider text-slate-400">
                                Phone
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                               tracking-wider text-slate-400">
                                Assigned Hostel
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                               tracking-wider text-slate-400">
                                Address
                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-semibold
                               uppercase tracking-wider text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-800">

                        @forelse ($wardens as $warden)
                            <tr
                                class="group transition-all duration-200
                               hover:bg-slate-800/40">

                                {{-- Warden --}}
                                {{-- Warden --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    <a href="{{ route('wardens.show', $warden) }}"
                                        class="group/warden inline-flex items-center gap-4">

                                        {{-- Avatar --}}
                                        @if ($warden->photo)
                                            <img src="{{ asset('storage/' . $warden->photo) }}" alt="{{ $warden->name }}"
                                                class="h-11 w-11 shrink-0 rounded-full
                                                    object-cover ring-2 ring-slate-700
                                                    transition duration-200
                                                    group-hover/warden:ring-blue-500/70
                                                    group-hover/warden:scale-105">
                                        @else
                                            <div
                                                class="flex h-11 w-11 shrink-0
                                                        items-center justify-center
                                                        rounded-full bg-blue-600
                                                        text-sm font-bold text-white
                                                        ring-2 ring-blue-500/20
                                                        transition duration-200
                                                        group-hover/warden:ring-blue-500/70
                                                        group-hover/warden:scale-105">

                                                {{ strtoupper(substr($warden->name, 0, 1)) }}

                                            </div>
                                        @endif


                                        {{-- Name + Phone --}}
                                        <div>

                                            <div
                                                class="font-semibold text-slate-100
                                                    transition duration-200
                                                    group-hover/warden:text-blue-400">

                                                {{ $warden->name }}

                                            </div>

                                            <div class="mt-1 text-xs text-slate-500">

                                                {{ $warden->mobile_number ?? 'No phone number' }}

                                            </div>

                                        </div>

                                    </a>

                                </td>


                                {{-- Email --}}
                                <td class="px-6 py-5">

                                    <div class="text-sm font-medium text-slate-300">

                                        {{ $warden->email }}

                                    </div>

                                </td>


                                {{-- Phone --}}
                                <td class="px-6 py-5">

                                    <div class="text-sm font-medium text-slate-300">

                                        {{ $warden->mobile_number ?? 'Not provided' }}

                                    </div>

                                </td>


                                {{-- Assigned Hostel --}}
                                <td class="px-6 py-5">

                                    @if ($warden->hostel)
                                        <div class="flex items-center gap-2">

                                            <span
                                                class="flex h-8 w-8 shrink-0
                                               items-center justify-center
                                               rounded-lg
                                               bg-emerald-500/10 text-base">

                                                🏠

                                            </span>

                                            <div>

                                                <div
                                                    class="text-sm font-semibold
                                                   text-slate-200">

                                                    {{ $warden->hostel->name }}

                                                </div>

                                                <div
                                                    class="mt-0.5 text-xs
                                                   text-emerald-400">

                                                    Assigned

                                                </div>

                                            </div>

                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-2
                                           rounded-full bg-amber-500/10
                                           px-3 py-1.5 text-xs font-medium
                                           text-amber-400">

                                            <span
                                                class="h-1.5 w-1.5 rounded-full
                                               bg-amber-400">
                                            </span>

                                            Unassigned

                                        </span>
                                    @endif

                                </td>


                                {{-- Address --}}
                                <td class="px-6 py-5">

                                    @if ($warden->address)
                                        <div class="max-w-[220px] truncate text-sm
                                           text-slate-300"
                                            title="{{ $warden->address }}">

                                            {{ $warden->address }}

                                        </div>
                                    @else
                                        <span class="text-sm text-slate-500">
                                            Not provided
                                        </span>
                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-end gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('wardens.show', $warden) }}" title="View Warden"
                                            class="flex h-9 w-9 items-center
                                           justify-center rounded-lg
                                           border border-slate-700
                                           bg-slate-800 text-slate-400
                                           transition
                                           hover:border-blue-500/40
                                           hover:bg-blue-500/10
                                           hover:text-blue-400">

                                            👁️

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('wardens.edit', $warden) }}" title="Edit Warden"
                                            class="flex h-9 w-9 items-center
                                           justify-center rounded-lg
                                           border border-slate-700
                                           bg-slate-800 text-slate-400
                                           transition
                                           hover:border-amber-500/40
                                           hover:bg-amber-500/10
                                           hover:text-amber-400">

                                            ✏️

                                        </a>


                                        {{-- Delete --}}
                                        <form action="{{ route('wardens.destroy', $warden) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm(
                                        'Are you sure you want to delete this warden?'
                                    )">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Delete Warden"
                                                class="flex h-9 w-9 items-center
                                               justify-center rounded-lg
                                               border border-slate-700
                                               bg-slate-800 text-slate-400
                                               transition
                                               hover:border-red-500/40
                                               hover:bg-red-500/10
                                               hover:text-red-400">

                                                🗑️

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16">

                                    <div
                                        class="flex flex-col items-center
                                       justify-center text-center">

                                        <div
                                            class="mb-4 flex h-16 w-16 items-center
                                           justify-center rounded-2xl
                                           bg-slate-800 text-3xl">

                                            👤

                                        </div>

                                        <h3
                                            class="text-base font-semibold
                                           text-slate-200">

                                            No Wardens Found

                                        </h3>

                                        <p
                                            class="mt-1 max-w-sm text-sm
                                           text-slate-500">

                                            There are no wardens available at the
                                            moment.

                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <script>
        function toggleWardenMenu(id) {
            const menu = document.getElementById('warden-menu-' + id);

            // Close all other menus
            document.querySelectorAll('[id^="warden-menu-"]').forEach(item => {
                if (item !== menu) {
                    item.classList.add('hidden');
                }
            });

            menu.classList.toggle('hidden');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('[id^="warden-menu-"]').forEach(item => {
                    item.classList.add('hidden');
                });
            }
        });
    </script>
@endsection
