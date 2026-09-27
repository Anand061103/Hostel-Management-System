@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                My Profile
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Manage your personal information and account details.
            </p>
        </div>


        {{-- Profile Overview --}}
        <div
            class="mb-6 overflow-hidden rounded-2xl border border-slate-200
                   bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="p-6 sm:p-8">

                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                    {{-- User Information --}}
                    <div class="flex items-center gap-5">

                        {{-- Profile Photo / Avatar --}}
                        <div
                            class="flex h-20 w-20 shrink-0 items-center justify-center
                                   overflow-hidden rounded-full bg-blue-100
                                   text-3xl font-bold text-blue-600
                                   dark:bg-blue-900/30 dark:text-blue-400">

                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                    class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif

                        </div>


                        {{-- Name / Email / Role --}}
                        <div>

                            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                                {{ $user->name }}
                            </h2>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                {{ $user->email }}
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-2">

                                <span
                                    class="rounded-full bg-blue-100 px-3 py-1
                                           text-xs font-semibold text-blue-700
                                           dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ ucfirst($user->role) }}
                                </span>

                                @if ($user->email_verified_at)
                                    <span
                                        class="rounded-full bg-emerald-100 px-3 py-1
                                               text-xs font-semibold text-emerald-700
                                               dark:bg-emerald-900/30 dark:text-emerald-400">
                                        Email Verified
                                    </span>
                                @else
                                    <span
                                        class="rounded-full bg-amber-100 px-3 py-1
                                               text-xs font-semibold text-amber-700
                                               dark:bg-amber-900/30 dark:text-amber-400">
                                        Email Not Verified
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- Edit Button --}}
                    <div>
                        <a href="{{ route('profile.edit') }}"
                            class="rounded-lg bg-blue-600 px-5 py-2.5
                                    text-sm font-semibold text-white
                                    transition hover:bg-blue-700
                                    focus:outline-none focus:ring-2
                                    focus:ring-blue-500 focus:ring-offset-2
                                    dark:focus:ring-offset-slate-900">

                            Edit Profile

                        </a>
                    </div>

                </div>

            </div>

        </div>


        {{-- Personal Information --}}
        <div
            class="mb-6 rounded-2xl border border-slate-200
                   bg-white shadow-sm dark:border-slate-800
                   dark:bg-slate-900">

            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Personal Information
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Your basic personal information.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                {{-- Full Name --}}
                <div>

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Full Name
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->name ?: 'Not added' }}
                    </p>

                </div>


                {{-- Email --}}
                <div>

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Email Address
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->email }}
                    </p>

                </div>


                {{-- Mobile --}}
                <div>

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Mobile Number
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->mobile_number ?: 'Not added' }}
                    </p>

                </div>


                {{-- Address --}}
                <div>

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Address
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->address ?: 'Not added' }}
                    </p>

                </div>


                {{-- Joining Date --}}
                <div>

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Joining Date
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->joining_date ? $user->joining_date->format('d M Y') : 'Not added' }}
                    </p>

                </div>


                {{-- Account Created --}}
                <div>

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Account Created
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->created_at->format('d M Y') }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Account Information --}}
        <div
            class="mb-6 rounded-2xl border border-slate-200
                   bg-white shadow-sm dark:border-slate-800
                   dark:bg-slate-900">

            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Information about your Hostel Management account.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-3">

                {{-- Role --}}
                <div class="rounded-xl border border-slate-200 p-4
                           dark:border-slate-800">

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Account Role
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ ucfirst($user->role) }}
                    </p>

                </div>


                {{-- Email Status --}}
                <div class="rounded-xl border border-slate-200 p-4
                           dark:border-slate-800">

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Email Status
                    </p>

                    <p
                        class="mt-2 text-sm font-semibold
                              {{ $user->email_verified_at ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">

                        {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}

                    </p>

                </div>


                {{-- Member Since --}}
                <div class="rounded-xl border border-slate-200 p-4
                           dark:border-slate-800">

                    <p
                        class="text-xs font-medium uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">
                        Member Since
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $user->created_at->format('d M Y') }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Account Security --}}
        <div
            class="rounded-2xl border border-slate-200
                   bg-white shadow-sm dark:border-slate-800
                   dark:bg-slate-900">

            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Account Security
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Manage your login credentials and account security.
                </p>

            </div>


            <div class="divide-y divide-slate-200 dark:divide-slate-800">

                {{-- Change Email --}}
                <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white">
                            Email Address
                        </h3>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ $user->email }}
                        </p>

                    </div>

                    <a href="{{ route('profile.email.edit') }}"
                        class="inline-block rounded-lg border border-slate-300 px-4 py-2
                                text-sm font-medium text-slate-700
                                transition hover:bg-slate-100
                                dark:border-slate-700 dark:text-slate-300
                                dark:hover:bg-slate-800">

                        Change Email

                    </a>

                </div>


                {{-- Change Password --}}
                <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white">
                            Password
                        </h3>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Keep your account secure by using a strong password.
                        </p>

                    </div>

                    <a href="{{ route('profile.password.edit') }}"
                        class="rounded-lg border border-slate-300 px-4 py-2
                                text-sm font-medium text-slate-700
                                transition hover:bg-slate-100
                                dark:border-slate-700 dark:text-slate-300
                                dark:hover:bg-slate-800">

                        Change Password

                    </a>

                </div>


                {{-- Password Recovery --}}
                <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white">
                            Password Recovery
                        </h3>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Forgot your password? Use secure account recovery.
                        </p>

                    </div>

                    <a href="{{ route('password.request') }}"
                        class="rounded-lg border border-slate-300
                            px-4 py-2 text-sm font-medium
                            text-slate-700
                            transition hover:bg-slate-100
                            dark:border-slate-700
                            dark:text-slate-300
                            dark:hover:bg-slate-800">

                        Password Recovery

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
