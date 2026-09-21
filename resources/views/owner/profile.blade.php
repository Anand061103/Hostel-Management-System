@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        {{-- Profile Header --}}
        <div class="mb-8">

            <div
                class="rounded-xl border border-slate-200
                       bg-white p-6 shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-16 w-16 items-center justify-center
                               rounded-full bg-blue-100 text-3xl
                               dark:bg-blue-900/30">
                        👤
                    </div>

                    <div>

                        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                            {{ $user->name }}
                        </h1>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ $user->email }}
                        </p>

                        <span
                            class="mt-2 inline-block rounded-full
                                   bg-blue-100 px-3 py-1 text-xs font-medium
                                   text-blue-700
                                   dark:bg-blue-900/30 dark:text-blue-400">
                            {{ ucfirst($user->role) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- My Hostels --}}
        <div>

            <div class="mb-5 flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                        {{ $user->role === 'superadmin' ? 'My Hostels' : 'My Hostel' }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        {{ $user->role === 'superadmin'
                            ? 'Select a hostel to manage its complete operations.'
                            : 'Manage your assigned hostel.' }}
                    </p>

                </div>

                @if ($user->role === 'superadmin')
                    <a href="{{ route('hostels.create') }}"
                        class="rounded-lg bg-blue-600 px-4 py-2.5
                   text-sm font-medium text-white
                   transition hover:bg-blue-700">

                        + Add Hostel

                    </a>
                @endif

            </div>


            @if ($hostels->count())

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                    @foreach ($hostels as $hostel)
                        <div
                            class="rounded-xl border border-slate-200
                                   bg-white p-6 shadow-sm
                                   dark:border-slate-800 dark:bg-slate-900">

                            {{-- Hostel Header --}}
                            <div class="flex items-center gap-4">

                                <div
                                    class="flex h-12 w-12 items-center
                                           justify-center rounded-xl
                                           bg-blue-100 text-2xl
                                           dark:bg-blue-900/30">
                                    🏠
                                </div>

                                <div>

                                    <h3
                                        class="text-lg font-semibold
                                               text-slate-800 dark:text-white">
                                        {{ $hostel->name }}
                                    </h3>

                                    <span
                                        class="text-xs font-medium
                                               text-green-600
                                               dark:text-green-400">
                                        ● Active
                                    </span>

                                </div>

                            </div>


                            {{-- Address --}}
                            @if ($hostel->address)
                                <div class="mt-5 flex gap-2">

                                    <span>📍</span>

                                    <p
                                        class="text-sm text-slate-500
                                               dark:text-slate-400">
                                        {{ $hostel->address }}
                                    </p>

                                </div>
                            @endif


                            {{-- Manage --}}
                            <div
                                class="mt-6 border-t border-slate-200
                                       pt-4 dark:border-slate-800">

                                <a href="{{ route('owner.hostels.enter', $hostel) }}"
                                    class="block w-full rounded-lg
                                           bg-blue-600 px-4 py-2.5
                                           text-center text-white
                                           transition hover:bg-blue-700">

                                    Manage Hostel →

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

                    <h3 class="text-xl font-semibold
                               text-slate-800 dark:text-white">
                        No Hostels Found
                    </h3>

                    <p class="mt-2 text-sm text-slate-500
                               dark:text-slate-400">
                        Add a hostel to start managing it.
                    </p>

                </div>

            @endif

        </div>

    </div>

@endsection
