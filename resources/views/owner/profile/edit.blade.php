@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Edit Profile
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Update your personal information and profile details.
            </p>
        </div>


        {{-- Profile Form --}}
        <div
            class="rounded-2xl border border-slate-200
                   bg-white shadow-sm
                   dark:border-slate-800 dark:bg-slate-900">

            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5
                       dark:border-slate-800">

                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Personal Information
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Keep your profile information up to date.
                </p>

            </div>


            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                {{-- Profile Photo --}}
                <div class="mb-8">

                    <label
                        class="block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                        Profile Photo
                    </label>

                    <div class="mt-4 flex items-center gap-5">

                        {{-- Current Avatar --}}
                        <div
                            class="flex h-20 w-20 shrink-0 items-center
                                   justify-center overflow-hidden rounded-full
                                   bg-blue-100 text-2xl font-bold text-blue-600
                                   dark:bg-blue-900/30 dark:text-blue-400">

                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                    class="h-full w-full object-cover">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif

                        </div>


                        <div>

                            <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm
                                       text-slate-500
                                       file:mr-4 file:rounded-lg
                                       file:border-0
                                       file:bg-blue-50
                                       file:px-4 file:py-2
                                       file:text-sm
                                       file:font-semibold
                                       file:text-blue-700
                                       hover:file:bg-blue-100
                                       dark:text-slate-400
                                       dark:file:bg-blue-900/30
                                       dark:file:text-blue-400">

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                JPG, JPEG, PNG or WEBP. Maximum 2MB.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Form Grid --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                    {{-- Full Name --}}
                    <div>

                        <label for="name"
                            class="block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">
                            Full Name
                        </label>

                        <input type="text" id="name" name="name" value="{{ $user->name }}"
                            placeholder="Enter your full name"
                            class="mt-2 block w-full rounded-lg
                                   border border-slate-300
                                   bg-white px-4 py-2.5 text-sm
                                   text-slate-800 outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">

                    </div>


                    {{-- Mobile Number --}}
                    <div>

                        <label for="mobile_number"
                            class="block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">
                            Mobile Number
                        </label>

                        <input type="text" id="mobile_number" name="mobile_number" value="{{ $user->mobile_number }}"
                            placeholder="Enter mobile number"
                            class="mt-2 block w-full rounded-lg
                                   border border-slate-300
                                   bg-white px-4 py-2.5 text-sm
                                   text-slate-800 outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">

                    </div>


                    {{-- Joining Date --}}
                    <div>

                        <label for="joining_date"
                            class="block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">
                            Joining Date
                        </label>

                        <input type="date" id="joining_date" name="joining_date"
                            value="{{ $user->joining_date?->format('Y-m-d') }}"
                            class="mt-2 block w-full rounded-lg
                                   border border-slate-300
                                   bg-white px-4 py-2.5 text-sm
                                   text-slate-800 outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">

                    </div>


                    {{-- Email --}}
                    <div>

                        <label
                            class="block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">
                            Email Address
                        </label>

                        <div
                            class="mt-2 rounded-lg border
                                   border-slate-200 bg-slate-50
                                   px-4 py-2.5 text-sm
                                   text-slate-600
                                   dark:border-slate-800
                                   dark:bg-slate-950
                                   dark:text-slate-400">

                            {{ $user->email }}

                        </div>

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Email address can be changed from Account Security.
                        </p>

                    </div>

                </div>


                {{-- Address --}}
                <div class="mt-6">

                    <label for="address"
                        class="block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                        Address
                    </label>

                    <textarea id="address" name="address" rows="4" placeholder="Enter your complete address"
                        class="mt-2 block w-full rounded-lg
                               border border-slate-300
                               bg-white px-4 py-2.5 text-sm
                               text-slate-800 outline-none
                               transition
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-700
                               dark:bg-slate-950
                               dark:text-white">{{ $user->address }}</textarea>

                </div>


                {{-- Account Role --}}
                <div class="mt-6">

                    <label
                        class="block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                        Account Role
                    </label>

                    <div
                        class="mt-2 rounded-lg border
                               border-slate-200 bg-slate-50
                               px-4 py-2.5 text-sm
                               text-slate-600
                               dark:border-slate-800
                               dark:bg-slate-950
                               dark:text-slate-400">

                        {{ ucfirst($user->role) }}

                    </div>

                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        Account role cannot be changed from your profile.
                    </p>

                </div>


                {{-- Actions --}}
                <div
                    class="mt-8 flex flex-col-reverse gap-3
                           border-t border-slate-200 pt-6
                           sm:flex-row sm:justify-end
                           dark:border-slate-800">

                    <a href="{{ route('profile') }}"
                        class="rounded-lg border border-slate-300
                               px-5 py-2.5 text-center text-sm
                               font-medium text-slate-700
                               transition hover:bg-slate-100
                               dark:border-slate-700
                               dark:text-slate-300
                               dark:hover:bg-slate-800">

                        Cancel

                    </a>


                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5
                               text-sm font-semibold text-white
                               transition hover:bg-blue-700">

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
