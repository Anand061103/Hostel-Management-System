@extends('layouts.admin')

@section('title', 'Beds')

@section('content')

    <div class="p-6">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Beds
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Manage hostel beds and their assignments
                </p>
            </div>


            <a href="{{ route('beds.create') }}"
                class="inline-flex items-center justify-center rounded-lg
                  bg-blue-600 px-4 py-2 text-sm font-semibold text-white
                  hover:bg-blue-700">

                + Add Bed

            </a>

        </div>



        {{-- ===================================================== --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ===================================================== --}}

        @if (session('success'))
            <div
                class="mb-4 rounded-lg border border-emerald-200
                    bg-emerald-50 px-4 py-3 text-sm text-emerald-700
                    dark:border-emerald-900 dark:bg-emerald-900/20
                    dark:text-emerald-400">

                {{ session('success') }}

            </div>
        @endif



        {{-- ===================================================== --}}
        {{-- ERROR MESSAGE --}}
        {{-- ===================================================== --}}

        @if (session('error'))
            <div
                class="mb-4 rounded-lg border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-700
                    dark:border-red-900 dark:bg-red-900/20
                    dark:text-red-400">

                {{ session('error') }}

            </div>
        @endif



        {{-- ===================================================== --}}
        {{-- SUMMARY CARDS --}}
        {{-- ===================================================== --}}

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2
                lg:grid-cols-4">


            {{-- Total Beds --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500
                      dark:text-slate-400">

                    Total Beds

                </p>

                <p class="mt-2 text-2xl font-bold text-slate-800
                      dark:text-white">

                    {{ $totalBeds }}

                </p>

            </div>



            {{-- Available Beds --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500
                      dark:text-slate-400">

                    Available Beds

                </p>

                <p class="mt-2 text-2xl font-bold text-emerald-600
                      dark:text-emerald-400">

                    {{ $availableBeds }}

                </p>

            </div>



            {{-- Occupied Beds --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500
                      dark:text-slate-400">

                    Occupied Beds

                </p>

                <p class="mt-2 text-2xl font-bold text-blue-600
                      dark:text-blue-400">

                    {{ $occupiedBeds }}

                </p>

            </div>



            {{-- Maintenance Beds --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500
                      dark:text-slate-400">

                    Maintenance

                </p>

                <p class="mt-2 text-2xl font-bold text-amber-600
                      dark:text-amber-400">

                    {{ $maintenanceBeds }}

                </p>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- SEARCH + FILTER --}}
        {{-- ===================================================== --}}

        <div
            class="mb-6 rounded-xl border border-slate-200
                bg-white p-5 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

            <form method="GET" action="{{ route('beds.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-3">


                {{-- Search --}}
                <div class="md:col-span-2">

                    <label for="search"
                        class="mb-2 block text-sm font-medium
                              text-slate-700 dark:text-slate-300">

                        Search

                    </label>

                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Search bed, room or student..."
                        class="w-full rounded-lg border border-slate-300
                           bg-white px-4 py-2.5 text-sm text-slate-800
                           outline-none
                           focus:border-blue-500
                           focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600
                           dark:bg-slate-900
                           dark:text-white
                           dark:placeholder-slate-500">

                </div>



                {{-- Status --}}
                <div>

                    <label for="status"
                        class="mb-2 block text-sm font-medium
                              text-slate-700 dark:text-slate-300">

                        Status

                    </label>

                    <select id="status" name="status"
                        class="w-full rounded-lg border border-slate-300
                           bg-white px-4 py-2.5 text-sm text-slate-800
                           outline-none
                           focus:border-blue-500
                           focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600
                           dark:bg-slate-900
                           dark:text-white">

                        <option value="">
                            All Status
                        </option>

                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>
                            Available
                        </option>

                        <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>
                            Occupied
                        </option>

                        <option value="maintenance" {{ request('status') === 'maintenance' ? 'selected' : '' }}>
                            Maintenance
                        </option>

                    </select>

                </div>



                {{-- Buttons --}}
                <div class="flex items-end gap-3 md:col-span-3">

                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5
                           text-sm font-semibold text-white
                           hover:bg-blue-700">

                        Search

                    </button>


                    <a href="{{ route('beds.index') }}"
                        class="rounded-lg border border-slate-300
                          px-5 py-2.5 text-sm font-medium
                          text-slate-700 hover:bg-slate-50
                          dark:border-slate-600
                          dark:text-slate-300
                          dark:hover:bg-slate-700">

                        Reset

                    </a>

                </div>

            </form>

        </div>



        {{-- ===================================================== --}}
        {{-- BEDS TABLE --}}
        {{-- ===================================================== --}}

        <div
            class="overflow-hidden rounded-xl border border-slate-200
                bg-white shadow-sm
                dark:border-slate-800 dark:bg-slate-900">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px] text-left text-sm">

                    {{-- Table Header --}}
                    <thead class="bg-slate-50 dark:bg-slate-800">

                        <tr>

                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                Bed

                            </th>


                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                Room

                            </th>


                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                Floor

                            </th>


                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                Student

                            </th>


                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                Status

                            </th>


                            <th
                                class="px-6 py-4 text-right text-xs
                                   font-semibold uppercase
                                   tracking-wider text-slate-500">

                                Action

                            </th>

                        </tr>

                    </thead>



                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-200
                             dark:divide-slate-800">


                        @forelse($beds as $bed)
                            <tr class="hover:bg-slate-50
                                   dark:hover:bg-slate-800/50">


                                {{-- Bed --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 shrink-0
                                                items-center justify-center
                                                rounded-lg bg-blue-100
                                                font-semibold text-blue-600
                                                dark:bg-blue-900/30
                                                dark:text-blue-400">

                                            {{ strtoupper(substr($bed->bed_number, 0, 1)) }}

                                        </div>


                                        <div>

                                            <p
                                                class="font-semibold
                                                  text-slate-800
                                                  dark:text-white">

                                                Bed {{ $bed->bed_number }}

                                            </p>

                                            <p
                                                class="text-xs text-slate-500
                                                  dark:text-slate-400">

                                                ID: {{ $bed->id }}

                                            </p>

                                        </div>

                                    </div>

                                </td>



                                {{-- Room --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="font-medium
                                             text-slate-700
                                             dark:text-slate-300">

                                        Room {{ $bed->room->room_number }}

                                    </span>

                                </td>



                                {{-- Floor --}}
                                <td
                                    class="px-6 py-4
                                       text-slate-600
                                       dark:text-slate-300">

                                    Floor {{ $bed->room->floor }}

                                </td>



                                {{-- Student --}}
                                <td class="px-6 py-4">

                                    @if ($bed->student)
                                        <div>

                                            <p
                                                class="font-medium
                                                  text-slate-800
                                                  dark:text-white">

                                                {{ $bed->student->full_name }}

                                            </p>

                                            <p
                                                class="text-xs text-slate-500
                                                  dark:text-slate-400">

                                                Student ID:
                                                {{ $bed->student->id }}

                                            </p>

                                        </div>
                                    @else
                                        <span class="text-slate-400">
                                            —
                                        </span>
                                    @endif

                                </td>



                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($bed->status === 'available')
                                        <span
                                            class="rounded-full
                                                 bg-emerald-100 px-3 py-1
                                                 text-xs font-medium
                                                 text-emerald-700
                                                 dark:bg-emerald-900/30
                                                 dark:text-emerald-400">

                                            Available

                                        </span>
                                    @elseif($bed->status === 'occupied')
                                        <span
                                            class="rounded-full
                                                 bg-blue-100 px-3 py-1
                                                 text-xs font-medium
                                                 text-blue-700
                                                 dark:bg-blue-900/30
                                                 dark:text-blue-400">

                                            Occupied

                                        </span>
                                    @else
                                        <span
                                            class="rounded-full
                                                 bg-amber-100 px-3 py-1
                                                 text-xs font-medium
                                                 text-amber-700
                                                 dark:bg-amber-900/30
                                                 dark:text-amber-400">

                                            Maintenance

                                        </span>
                                    @endif

                                </td>



                                {{-- Action --}}
                                <td class="px-6 py-4 text-right">

                                    <div
                                        class="flex items-center
                                            justify-end gap-3">


                                        {{-- View --}}
                                        <a href="{{ route('beds.show', $bed) }}"
                                            class="text-blue-600
                                              hover:text-blue-800
                                              dark:text-blue-400
                                              dark:hover:text-blue-300">

                                            View

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('beds.edit', $bed) }}"
                                            class="text-slate-600
                                              hover:text-slate-800
                                              dark:text-slate-400
                                              dark:hover:text-white">

                                            Edit

                                        </a>
                                        @if ($bed->status !== 'occupied' && $bed->student_id === null)
                                            <form action="{{ route('beds.destroy', $bed) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this bed?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800
                                                    dark:text-red-400
                                                    dark:hover:text-red-300">

                                                    Delete

                                                </button>

                                            </form>
                                        @endif

                                        {{-- Assign --}}
                                        @if ($bed->status === 'available')
                                            <a href="{{ route('beds.assign', $bed) }}"
                                                class="inline-flex items-center rounded-lg
                                                bg-emerald-600 px-4 py-2.5
                                                text-sm font-semibold text-white
                                                hover:bg-emerald-700">

                                                Assign

                                            </a>
                                        @endif

                                    </div>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-12 text-center">

                                    <div class="text-4xl">
                                        🛏️
                                    </div>

                                    <p
                                        class="mt-3 text-lg font-semibold
                                          text-slate-600
                                          dark:text-slate-300">

                                        No beds found

                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">

                                        Add a bed to get started.

                                    </p>

                                </td>

                            </tr>
                        @endforelse


                    </tbody>

                </table>

            </div>



            {{-- ================================================= --}}
            {{-- PAGINATION --}}
            {{-- ================================================= --}}

            @if ($beds->hasPages())
                <div
                    class="flex justify-center border-t
                        border-slate-200 px-6 py-4
                        dark:border-slate-800">

                    {{ $beds->links('pagination::tailwind') }}

                </div>
            @endif

        </div>

    </div>

@endsection
