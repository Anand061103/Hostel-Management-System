@extends('layouts.admin')

@section('title', 'Warden Profile')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        {{-- Profile Header --}}
        <div class="mb-8">

            <div
                class="rounded-xl border border-slate-200
                       bg-white p-6 shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                @if ($warden)

                    <div class="flex flex-col gap-6 md:flex-row md:items-center">

                        {{-- Profile Photo --}}
                        <div class="shrink-0">

                            @if ($warden->photo)
                                <img src="{{ asset('storage/' . $warden->photo) }}" alt="{{ $warden->name }}"
                                    class="h-24 w-24 rounded-full object-cover
                                           border-4 border-slate-200
                                           dark:border-slate-700">
                            @else
                                <div
                                    class="flex h-24 w-24 items-center justify-center
                                           rounded-full bg-blue-100 text-4xl
                                           dark:bg-blue-900/30">
                                    👤
                                </div>
                            @endif

                        </div>


                        {{-- Basic Information --}}
                        <div>

                            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                                {{ $warden->name }}
                            </h1>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                {{ $warden->email }}
                            </p>

                            <span
                                class="mt-2 inline-block rounded-full
                                       bg-blue-100 px-3 py-1 text-xs font-medium
                                       text-blue-700
                                       dark:bg-blue-900/30 dark:text-blue-400">
                                Warden
                            </span>

                        </div>

                    </div>


                    {{-- Warden Details --}}
                    <div class="mt-8 border-t border-slate-200 pt-6 dark:border-slate-800">

                        <h2 class="mb-5 text-lg font-semibold text-slate-800 dark:text-white">
                            Warden Details
                        </h2>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Name --}}
                            <div>
                                <p
                                    class="text-xs font-medium uppercase tracking-wide
                                          text-slate-500 dark:text-slate-400">
                                    Full Name
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                                    {{ $warden->name }}
                                </p>
                            </div>


                            {{-- Email --}}
                            <div>
                                <p
                                    class="text-xs font-medium uppercase tracking-wide
                                          text-slate-500 dark:text-slate-400">
                                    Email
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                                    {{ $warden->email }}
                                </p>
                            </div>


                            {{-- Mobile --}}
                            <div>
                                <p
                                    class="text-xs font-medium uppercase tracking-wide
                                          text-slate-500 dark:text-slate-400">
                                    Mobile Number
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                                    {{ $warden->mobile_number ?? 'Not provided' }}
                                </p>
                            </div>


                            {{-- Joining Date --}}
                            <div>
                                <p
                                    class="text-xs font-medium uppercase tracking-wide
                                          text-slate-500 dark:text-slate-400">
                                    Joining Date
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                                    {{ $warden->joining_date ? $warden->joining_date->format('d M Y') : 'Not provided' }}
                                </p>
                            </div>


                            {{-- Address --}}
                            <div class="md:col-span-2">

                                <p
                                    class="text-xs font-medium uppercase tracking-wide
                                          text-slate-500 dark:text-slate-400">
                                    Address
                                </p>

                                <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                                    {{ $warden->address ?? 'Not provided' }}
                                </p>

                            </div>

                        </div>

                    </div>
                @else
                    <div>

                        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                            No Warden Assigned
                        </h1>

                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                            No warden has been assigned to {{ $hostel->name }} yet.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Hostel Information --}}
        <div>

            <h2 class="mb-4 text-xl font-bold text-slate-800 dark:text-white">
                Assigned Hostel
            </h2>

            <div
                class="rounded-xl border border-slate-200
                       bg-white p-6 shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    {{ $hostel->name }}
                </h3>


                {{-- Hostel Address --}}
                @if ($hostel->address)
                    <div class="mt-4">

                        <p
                            class="text-xs font-medium uppercase tracking-wide
                                  text-slate-500 dark:text-slate-400">
                            Address
                        </p>

                        <p class="mt-1 text-sm text-slate-800 dark:text-white">
                            {{ $hostel->address }}
                        </p>

                    </div>
                @endif


                {{-- Hostel Phone --}}
                @if ($hostel->phone)
                    <div class="mt-4">

                        <p
                            class="text-xs font-medium uppercase tracking-wide
                                  text-slate-500 dark:text-slate-400">
                            Phone
                        </p>

                        <p class="mt-1 text-sm text-slate-800 dark:text-white">
                            {{ $hostel->phone }}
                        </p>

                    </div>
                @endif


                {{-- Hostel Email --}}
                @if ($hostel->email)
                    <div class="mt-4">

                        <p
                            class="text-xs font-medium uppercase tracking-wide
                                  text-slate-500 dark:text-slate-400">
                            Email
                        </p>

                        <p class="mt-1 text-sm text-slate-800 dark:text-white">
                            {{ $hostel->email }}
                        </p>

                    </div>
                @endif


                @if ($warden)
                    <p
                        class="mt-6 border-t border-slate-200 pt-5 text-sm
                              text-slate-500 dark:border-slate-800 dark:text-slate-400">
                        This warden is assigned to this hostel.
                    </p>
                @else
                    <p
                        class="mt-6 border-t border-slate-200 pt-5 text-sm
                              text-slate-500 dark:border-slate-800 dark:text-slate-400">
                        This hostel currently has no assigned warden.
                    </p>
                @endif

            </div>

        </div>

    </div>

@endsection
