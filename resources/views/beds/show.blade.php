@extends('layouts.admin')

@section('title', 'Bed Details')

@section('content')

    <div class="p-6">
        <div class="mb-5">

            <a href="{{ route('beds.index') }}"
                class="inline-flex items-center rounded-lg
              border border-slate-300 px-4 py-2
              text-sm font-medium text-slate-700
              hover:bg-slate-50
              dark:border-slate-600
              dark:text-slate-300
              dark:hover:bg-slate-800">

                ← Back to Beds

            </a>

        </div>
        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="mb-6 flex items-start justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Bed Details
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Complete bed and assignment information
                </p>
            </div>


            {{-- Status --}}
            @if ($bed->status === 'available')
                <span
                    class="rounded-full bg-emerald-100 px-4 py-2
                         text-xs font-semibold text-emerald-700
                         dark:bg-emerald-900/30
                         dark:text-emerald-400">

                    Available

                </span>
            @elseif($bed->status === 'occupied')
                <span
                    class="rounded-full bg-blue-100 px-4 py-2
                         text-xs font-semibold text-blue-700
                         dark:bg-blue-900/30
                         dark:text-blue-400">

                    Occupied

                </span>
            @else
                <span
                    class="rounded-full bg-amber-100 px-4 py-2
                         text-xs font-semibold text-amber-700
                         dark:bg-amber-900/30
                         dark:text-amber-400">

                    Maintenance

                </span>
            @endif

        </div>



        {{-- ===================================================== --}}
        {{-- BED / ROOM CARD --}}
        {{-- ===================================================== --}}

        <div
            class="mb-6 rounded-xl border border-slate-200
                bg-white p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

            <p
                class="mb-4 text-xs font-semibold uppercase
                  tracking-wider text-slate-500
                  dark:text-slate-400">

                Bed Information

            </p>


            <div class="flex items-center gap-4">

                {{-- Bed Icon --}}
                <div
                    class="flex h-14 w-14 shrink-0 items-center
                        justify-center rounded-xl bg-blue-100
                        text-lg font-bold text-blue-600
                        dark:bg-blue-900/30
                        dark:text-blue-400">

                    {{ strtoupper(substr($bed->bed_number, 0, 1)) }}

                </div>


                <div>

                    <h2 class="text-xl font-bold text-slate-800
                           dark:text-white">

                        Bed {{ $bed->bed_number }}

                    </h2>

                    <p class="mt-1 text-sm text-slate-500
                          dark:text-slate-400">

                        Bed ID: {{ $bed->id }}

                    </p>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- ROOM INFORMATION --}}
        {{-- ===================================================== --}}

        <div
            class="mb-6 rounded-xl border border-slate-200
                bg-white p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

            <h2 class="text-lg font-bold text-slate-800
                   dark:text-white">

                Room Information

            </h2>

            <p class="mt-1 text-sm text-slate-500
                  dark:text-slate-400">

                Room where this bed is located

            </p>


            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">


                {{-- Room --}}
                <div>

                    <p class="text-sm text-slate-500
                          dark:text-slate-400">

                        Room Number

                    </p>

                    <p class="mt-1 font-semibold text-slate-800
                          dark:text-white">

                        Room {{ $bed->room->room_number }}

                    </p>

                </div>


                {{-- Floor --}}
                <div>

                    <p class="text-sm text-slate-500
                          dark:text-slate-400">

                        Floor

                    </p>

                    <p class="mt-1 font-semibold text-slate-800
                          dark:text-white">

                        Floor {{ $bed->room->floor }}

                    </p>

                </div>


                {{-- Room Type --}}
                <div>

                    <p class="text-sm text-slate-500
                          dark:text-slate-400">

                        Room Type

                    </p>

                    <p class="mt-1 font-semibold text-slate-800
                          dark:text-white">

                        {{ $bed->room->room_type }}

                    </p>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- CURRENT STUDENT --}}
        {{-- ===================================================== --}}

        @if ($bed->currentAssignment && $bed->currentAssignment->student)

            <div
                class="mb-6 rounded-xl border border-slate-200
                    bg-white p-6 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <div class="mb-5">

                    <h2 class="text-lg font-bold text-slate-800
                           dark:text-white">

                        Current Student

                    </h2>

                    <p class="mt-1 text-sm text-slate-500
                          dark:text-slate-400">

                        Student currently assigned to this bed

                    </p>

                </div>


                <div class="flex items-center justify-between gap-4">


                    <div class="flex items-center gap-4">

                        {{-- Avatar --}}
                        <div
                            class="flex h-12 w-12 shrink-0
                                items-center justify-center
                                rounded-full bg-blue-100
                                font-semibold text-blue-600
                                dark:bg-blue-900/30
                                dark:text-blue-400">

                            {{ strtoupper(substr($bed->currentAssignment->student->full_name, 0, 1)) }}

                        </div>


                        <div>

                            <p class="font-semibold text-slate-800
                                  dark:text-white">

                                {{ $bed->currentAssignment->student->full_name }}

                            </p>

                            <p class="mt-1 text-xs text-slate-500
                                  dark:text-slate-400">

                                Student ID: {{ $bed->currentAssignment->student->id }}

                            </p>

                        </div>

                    </div>


                    <a href="{{ route('students.show', $bed->currentAssignment->student) }}"
                        class="text-sm font-medium text-blue-600
                          hover:text-blue-800
                          dark:text-blue-400
                          dark:hover:text-blue-300">

                        View Student

                    </a>

                </div>

            </div>
        @else
            {{-- No Student --}}
            <div
                class="mb-6 rounded-xl border border-slate-200
                    bg-white p-6 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <div class="flex items-center justify-between gap-4">

                    <div>

                        <h2 class="text-lg font-bold text-slate-800
                               dark:text-white">

                            No Student Assigned

                        </h2>

                        <p class="mt-1 text-sm text-slate-500
                              dark:text-slate-400">

                            This bed is currently available for assignment.

                        </p>

                    </div>


                    @if ($bed->status === 'available')
                        <a href="{{ route('beds.assign', $bed) }}"
                            class="inline-flex items-center rounded-lg
                                bg-emerald-600 px-4 py-2.5
                                text-sm font-semibold text-white
                                hover:bg-emerald-700">

                            Assign Student

                        </a>
                    @endif

                </div>

            </div>

        @endif



        {{-- ===================================================== --}}
        {{-- ASSIGNMENT HISTORY --}}
        {{-- ===================================================== --}}

        <div
            class="overflow-hidden rounded-xl border
                border-slate-200 bg-white shadow-sm
                dark:border-slate-800 dark:bg-slate-900">


            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5
                    dark:border-slate-800">

                <h2 class="text-lg font-bold text-slate-800
                       dark:text-white">

                    Assignment History

                </h2>

                <p class="mt-1 text-sm text-slate-500
                      dark:text-slate-400">

                    Previous and current student assignments

                </p>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full min-w-[700px] text-left text-sm">

                    <thead class="bg-slate-50 dark:bg-slate-800">

                        <tr>

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

                                Start Date

                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                End Date

                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold
                                   uppercase tracking-wider
                                   text-slate-500">

                                Status

                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-200
                             dark:divide-slate-800">

                        @forelse($bed->assignments->sortByDesc('start_date') as $assignment)
                            <tr class="hover:bg-slate-50
                                   dark:hover:bg-slate-800/50">


                                {{-- Student --}}
                                <td class="px-6 py-4">

                                    <p
                                        class="font-semibold
                                          text-slate-800
                                          dark:text-white">

                                        {{ $assignment->student->full_name }}

                                    </p>

                                    <p
                                        class="mt-1 text-xs
                                          text-slate-500
                                          dark:text-slate-400">

                                        ID: {{ $assignment->student->id }}

                                    </p>

                                </td>


                                {{-- Start --}}
                                <td
                                    class="px-6 py-4 text-slate-600
                                       dark:text-slate-300">

                                    {{ $assignment->start_date->format('d M Y') }}

                                </td>


                                {{-- End --}}
                                <td
                                    class="px-6 py-4 text-slate-600
                                       dark:text-slate-300">

                                    @if ($assignment->end_date)
                                        {{ $assignment->end_date->format('d M Y') }}
                                    @else
                                        —
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if (!$assignment->end_date || $assignment->end_date >= now()->startOfDay())
                                        <span
                                            class="rounded-full
                                                 bg-emerald-100 px-3 py-1
                                                 text-xs font-medium
                                                 text-emerald-700
                                                 dark:bg-emerald-900/30
                                                 dark:text-emerald-400">

                                            Active

                                        </span>
                                    @else
                                        <span
                                            class="rounded-full
                                                 bg-slate-100 px-3 py-1
                                                 text-xs font-medium
                                                 text-slate-600
                                                 dark:bg-slate-700
                                                 dark:text-slate-300">

                                            Completed

                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-12 text-center">

                                    <div class="text-4xl">
                                        🛏️
                                    </div>

                                    <p
                                        class="mt-3 text-lg font-semibold
                                          text-slate-600
                                          dark:text-slate-300">

                                        No assignment history

                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">

                                        This bed has never been assigned.

                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- BACK BUTTON --}}
        {{-- ===================================================== --}}



    </div>

@endsection
