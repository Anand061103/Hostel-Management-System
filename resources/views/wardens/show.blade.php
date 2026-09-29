@extends('layouts.admin')

@section('content')

    <div class="p-6">

        <div class="mx-auto max-w-5xl">

            {{-- Back --}}
            <div class="mb-4">
                <a href="{{ route('wardens.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium
                           text-slate-500 transition hover:text-blue-600
                           dark:text-slate-400 dark:hover:text-blue-400">
                    <span>←</span>
                    Back to Wardens
                </a>
            </div>


            {{-- ====================================================== --}}
            {{-- Profile Header --}}
            {{-- ====================================================== --}}

            <div
                class="mb-6 overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="p-6">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-4">

                            {{-- Profile Photo --}}
                            @if ($warden->photo)
                                <img src="{{ asset('storage/' . $warden->photo) }}" alt="{{ $warden->name }}"
                                    class="h-20 w-20 rounded-2xl object-cover ring-4
                                           ring-blue-50
                                           dark:ring-blue-900/20">
                            @else
                                <div
                                    class="flex h-20 w-20 items-center justify-center
                                           rounded-2xl bg-blue-600 text-2xl font-bold
                                           text-white">
                                    {{ strtoupper(substr($warden->name, 0, 1)) }}
                                </div>
                            @endif


                            {{-- Name --}}
                            <div>

                                <div class="flex flex-wrap items-center gap-2">

                                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                                        {{ $warden->name }}
                                    </h1>

                                    <span
                                        class="rounded-full bg-blue-100 px-3 py-1
                                               text-xs font-semibold text-blue-700
                                               dark:bg-blue-900/30 dark:text-blue-400">
                                        Warden
                                    </span>

                                </div>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $warden->email }}
                                </p>

                                @if ($warden->hostel)
                                    <div
                                        class="mt-2 flex items-center gap-2 text-sm
                                               font-medium text-slate-600
                                               dark:text-slate-300">
                                        <span>🏠</span>
                                        <span>{{ $warden->hostel->name }}</span>
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-red-500">
                                        No hostel assigned
                                    </p>
                                @endif

                            </div>

                        </div>


                        {{-- Actions --}}
                        <div class="flex gap-2">

                            <a href="{{ route('wardens.edit', $warden) }}"
                                class="inline-flex items-center gap-2 rounded-xl
                                       bg-blue-600 px-4 py-2.5 text-sm font-semibold
                                       text-white transition hover:bg-blue-500">
                                ✏️
                                Edit
                            </a>

                            <form action="{{ route('wardens.destroy', $warden) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this warden?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl
                                           border border-red-200 bg-red-50
                                           px-4 py-2.5 text-sm font-semibold
                                           text-red-600 transition
                                           hover:bg-red-100
                                           dark:border-red-900/50
                                           dark:bg-red-900/20
                                           dark:text-red-400
                                           dark:hover:bg-red-900/30">
                                    🗑️
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- Personal Information --}}
            {{-- ====================================================== --}}

            <div
                class="mb-6 overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-xl bg-blue-100 text-lg
                                   dark:bg-blue-900/30">
                            👤
                        </div>

                        <div>
                            <h2 class="font-semibold text-slate-800 dark:text-white">
                                Personal Information
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Basic details of the warden.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                    {{-- Mobile --}}
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Mobile Number
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                            {{ $warden->mobile_number ?: 'Not provided' }}
                        </p>
                    </div>


                    {{-- Joining Date --}}
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Joining Date
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                            {{ $warden->joining_date ? $warden->joining_date->format('d M Y') : 'Not provided' }}
                        </p>
                    </div>


                    {{-- Address --}}
                    <div class="md:col-span-2">

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Address
                        </p>

                        <p class="mt-1 text-sm font-semibold leading-6 text-slate-800 dark:text-white">
                            {{ $warden->address ?: 'Not provided' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- Hostel Information --}}
            {{-- ====================================================== --}}

            <div
                class="mb-6 overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-xl bg-purple-100 text-lg
                                   dark:bg-purple-900/30">
                            🏢
                        </div>

                        <div>
                            <h2 class="font-semibold text-slate-800 dark:text-white">
                                Hostel Information
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Hostel currently assigned to this warden.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                    {{-- Hostel Name --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Assigned Hostel
                        </p>

                        <div class="mt-2 flex items-center gap-2">

                            <span class="text-xl">🏠</span>

                            <p class="text-sm font-semibold text-slate-800 dark:text-white">
                                {{ $warden->hostel?->name ?? 'No hostel assigned' }}
                            </p>

                        </div>

                    </div>


                    {{-- Hostel Status --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Hostel Status
                        </p>

                        @if ($warden->hostel)
                            @if ($warden->hostel->status === 'active')
                                <span
                                    class="mt-2 inline-flex rounded-full
                                           bg-green-100 px-3 py-1 text-xs
                                           font-semibold text-green-700
                                           dark:bg-green-900/30 dark:text-green-400">
                                    Active
                                </span>
                            @else
                                <span
                                    class="mt-2 inline-flex rounded-full
                                           bg-red-100 px-3 py-1 text-xs
                                           font-semibold text-red-700
                                           dark:bg-red-900/30 dark:text-red-400">
                                    Inactive
                                </span>
                            @endif
                        @else
                            <span
                                class="mt-2 inline-flex rounded-full
                                       bg-slate-100 px-3 py-1 text-xs
                                       font-semibold text-slate-600
                                       dark:bg-slate-800 dark:text-slate-400">
                                Not Assigned
                            </span>
                        @endif

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- Identity & Bank Information --}}
            {{-- ====================================================== --}}

            <div
                class="mb-6 overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-xl bg-orange-100 text-lg
                                   dark:bg-orange-900/30">
                            🔐
                        </div>

                        <div>
                            <h2 class="font-semibold text-slate-800 dark:text-white">
                                Identity & Bank Information
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Sensitive information is partially masked.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-3">

                    {{-- Aadhaar --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Aadhaar Number
                        </p>

                        <p class="mt-1 text-sm font-semibold tracking-wide text-slate-800 dark:text-white">
                            {{ $warden->aadhaar_number ? implode('-', str_split($warden->aadhaar_number, 4)) : 'Not provided' }}
                        </p>

                    </div>


                    {{-- Bank Account --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Bank Account Number
                        </p>

                        <p class="mt-1 text-sm font-semibold tracking-wide text-slate-800 dark:text-white">
                            {{ $warden->account_number ? implode('-', str_split($warden->account_number, 4)) : 'Not provided' }}
                        </p>

                    </div>


                    {{-- IFSC --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            IFSC Code
                        </p>

                        <p class="mt-1 text-sm font-semibold tracking-wide text-slate-800 dark:text-white">
                            {{ $warden->ifsc_code ?: 'Not provided' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- Account Information --}}
            {{-- ====================================================== --}}

            <div
                class="overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-xl bg-green-100 text-lg
                                   dark:bg-green-900/30">
                            📋
                        </div>

                        <div>
                            <h2 class="font-semibold text-slate-800 dark:text-white">
                                Account Information
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Warden account timestamps.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                    {{-- Created --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Account Created
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                            {{ $warden->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </p>

                    </div>


                    {{-- Updated --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                            Last Updated
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-800 dark:text-white">
                            {{ $warden->updated_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
