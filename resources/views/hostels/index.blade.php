@extends('layouts.admin')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Hostels
                </h1>

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Manage all your hostels from one place.
                </p>
            </div>

            <a href="{{ route('hostels.create') }}"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white
                       hover:bg-blue-700 transition">
                + Add Hostel
            </a>

        </div>


        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-lg bg-green-100 text-green-700
                        dark:bg-green-900/30 dark:text-green-400 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif


        {{-- Hostel Cards --}}
        @if ($hostels->count())
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach ($hostels as $hostel)
                    <div
                        class="bg-white dark:bg-slate-900
                               border border-slate-200 dark:border-slate-800
                               rounded-xl shadow-sm
                               p-6">

                        {{-- Hostel Header --}}
                        <div class="flex items-start justify-between">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-11 h-11 rounded-lg
                                           bg-blue-100 dark:bg-blue-900/30
                                           flex items-center justify-center
                                           text-xl">
                                    🏠
                                </div>

                                <div>
                                    <h2
                                        class="font-semibold text-lg
                                               text-slate-800 dark:text-white">
                                        {{ $hostel->name }}
                                    </h2>

                                    <span
                                        class="text-xs
                                               {{ $hostel->status === 'active' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        ● {{ ucfirst($hostel->status) }}
                                    </span>
                                </div>

                            </div>

                        </div>


                        {{-- Address --}}
                        @if ($hostel->address)
                            <div class="mt-5 flex gap-2">

                                <span>📍</span>

                                <p
                                    class="text-sm text-slate-600
                                          dark:text-slate-400">
                                    {{ $hostel->address }}
                                </p>

                            </div>
                        @endif


                        {{-- Contact --}}
                        <div class="mt-4 space-y-2">

                            @if ($hostel->phone)
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    📞 {{ $hostel->phone }}
                                </p>
                            @endif

                            @if ($hostel->email)
                                <p class="text-sm text-slate-600 dark:text-slate-400">
                                    ✉️ {{ $hostel->email }}
                                </p>
                            @endif

                        </div>


                        {{-- Manage Button --}}
                        <div
                            class="border-t border-slate-200 dark:border-slate-800
                                   mt-5 pt-4">

                            <a href="{{ route('hostels.show', $hostel) }}"
                                class="block text-center w-full
                                       px-4 py-2.5 rounded-lg
                                       bg-blue-600 text-white
                                       hover:bg-blue-700 transition">
                                Manage Hostel →
                            </a>

                        </div>

                    </div>
                @endforeach

            </div>
        @else
            {{-- Empty State --}}
            <div
                class="bg-white dark:bg-slate-900
                       border border-slate-200 dark:border-slate-800
                       rounded-xl p-12 text-center">

                <div class="text-5xl mb-4">
                    🏠
                </div>

                <h2 class="text-xl font-semibold
                           text-slate-800 dark:text-white">
                    No Hostels Found
                </h2>

                <p class="text-sm text-slate-500
                          dark:text-slate-400 mt-2">
                    Create your first hostel to start managing it.
                </p>

                <a href="{{ route('hostels.create') }}"
                    class="inline-block mt-5 px-5 py-2.5
                           rounded-lg bg-blue-600 text-white
                           hover:bg-blue-700">
                    Add First Hostel
                </a>

            </div>
        @endif

    </div>

@endsection
