@extends('layouts.admin')

@section('title', 'Switch Hostel')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Switch Hostel
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Select a hostel to continue managing it.
            </p>

        </div>


        @if ($hostels->count())

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                @foreach ($hostels as $hostel)
                    <div
                        class="rounded-xl border border-slate-200
                               bg-white p-6 shadow-sm
                               dark:border-slate-800 dark:bg-slate-900">

                        <div class="flex items-center gap-4">

                            <div
                                class="flex h-12 w-12 items-center
                                       justify-center rounded-xl
                                       bg-blue-100 text-2xl
                                       dark:bg-blue-900/30">

                                🏠

                            </div>

                            <div>

                                <h2
                                    class="text-lg font-semibold
                                           text-slate-800 dark:text-white">

                                    {{ $hostel->name }}

                                </h2>

                                <p class="text-xs font-medium text-green-500">
                                    ● Active
                                </p>

                            </div>

                        </div>


                        @if ($hostel->address)
                            <p class="mt-5 text-sm text-slate-500 dark:text-slate-400">
                                📍 {{ $hostel->address }}
                            </p>
                        @endif


                        <div
                            class="mt-6 border-t border-slate-200
                                   pt-4 dark:border-slate-800">

                            <a href="{{ route('owner.hostels.enter', $hostel) }}"
                                class="block w-full rounded-lg
                                       bg-blue-600 px-4 py-2.5
                                       text-center text-sm font-medium
                                       text-white transition
                                       hover:bg-blue-700">

                                Switch to Hostel →

                            </a>

                        </div>

                    </div>
                @endforeach

            </div>
        @else
            <div
                class="rounded-xl border border-slate-200
                       bg-white p-10 text-center
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="mb-4 text-5xl">
                    🏠
                </div>

                <h2 class="text-xl font-semibold text-slate-800 dark:text-white">
                    No Active Hostels
                </h2>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Create an active hostel to start managing it.
                </p>

            </div>

        @endif

    </div>

@endsection
