@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        {{-- Header --}}
        <div class="mb-6">

            <a href="{{ route('profile') }}"
                class="text-sm font-medium text-blue-600 hover:text-blue-700
                   dark:text-blue-400">

                ← Back to Profile

            </a>

            <h1 class="mt-3 text-2xl font-bold text-slate-800 dark:text-white">
                Edit Profile
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Update your personal profile information.
            </p>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div
                class="mb-6 rounded-lg border border-red-200
                   bg-red-50 px-4 py-3
                   text-sm text-red-700
                   dark:border-red-900/50
                   dark:bg-red-900/20
                   dark:text-red-400">

                <ul class="list-disc space-y-1 pl-5">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Form --}}
        <div
            class="rounded-xl border border-slate-200
               bg-white p-6 shadow-sm
               dark:border-slate-800
               dark:bg-slate-900">

            <form action="{{ route('warden.profile.update') }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')


                {{-- Profile Photo --}}
                <div class="mb-8">

                    <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white">
                        Profile Photo
                    </h2>

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                        @if ($warden->photo)
                            <img src="{{ asset('storage/' . $warden->photo) }}" alt="{{ $warden->name }}"
                                class="h-24 w-24 rounded-full
                                   border-4 border-slate-200
                                   object-cover
                                   dark:border-slate-700">
                        @else
                            <div
                                class="flex h-24 w-24 items-center
                                   justify-center rounded-full
                                   bg-blue-100 text-4xl
                                   dark:bg-blue-900/30">

                                👤

                            </div>
                        @endif


                        <div>

                            <label for="photo"
                                class="mb-2 block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">

                                Change Photo

                            </label>

                            <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full text-sm
                                   text-slate-600
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


                {{-- Personal Information --}}
                <div class="border-t border-slate-200 pt-8 dark:border-slate-800">

                    <h2 class="mb-5 text-lg font-semibold text-slate-800 dark:text-white">
                        Personal Information
                    </h2>


                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                        {{-- Name --}}
                        <div>

                            <label for="name"
                                class="mb-2 block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">

                                Full Name

                            </label>

                            <input type="text" id="name" name="name" value="{{ old('name', $warden->name) }}"
                                required
                                class="w-full rounded-lg border
                                   border-slate-300
                                   bg-white px-4 py-2.5
                                   text-sm text-slate-900
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-800
                                   dark:text-white">

                        </div>


                        {{-- Email --}}
                        <div>

                            <label for="email"
                                class="mb-2 block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">

                                Email

                            </label>

                            <input type="email" id="email" name="email" value="{{ old('email', $warden->email) }}"
                                required
                                class="w-full rounded-lg border
                                   border-slate-300
                                   bg-white px-4 py-2.5
                                   text-sm text-slate-900
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-800
                                   dark:text-white">

                        </div>


                        {{-- Mobile --}}
                        <div>

                            <label for="mobile_number"
                                class="mb-2 block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">

                                Mobile Number

                            </label>

                            <input type="text" id="mobile_number" name="mobile_number"
                                value="{{ old('mobile_number', $warden->mobile_number) }}"
                                class="w-full rounded-lg border
                                   border-slate-300
                                   bg-white px-4 py-2.5
                                   text-sm text-slate-900
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-800
                                   dark:text-white">

                        </div>


                        {{-- Joining Date --}}
                        <div>

                            <label
                                class="mb-2 block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">

                                Joining Date

                            </label>

                            <div
                                class="w-full rounded-lg border
                                   border-slate-200
                                   bg-slate-100 px-4 py-2.5
                                   text-sm text-slate-600
                                   dark:border-slate-700
                                   dark:bg-slate-800
                                   dark:text-slate-400">

                                {{ $warden->joining_date ? $warden->joining_date->format('d M Y') : 'Not provided' }}

                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="md:col-span-2">

                            <label for="address"
                                class="mb-2 block text-sm font-medium
                                   text-slate-700 dark:text-slate-300">

                                Address

                            </label>

                            <textarea id="address" name="address" rows="4"
                                class="w-full rounded-lg border
                                   border-slate-300
                                   bg-white px-4 py-3
                                   text-sm text-slate-900
                                   outline-none
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-800
                                   dark:text-white">{{ old('address', $warden->address) }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- Assigned Hostel --}}
                <div class="mt-8 border-t border-slate-200 pt-8 dark:border-slate-800">

                    <h2 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white">
                        Assigned Hostel
                    </h2>

                    <div
                        class="rounded-lg border border-slate-200
                           bg-slate-50 p-4
                           dark:border-slate-700
                           dark:bg-slate-800">

                        <p class="font-semibold text-slate-800 dark:text-white">
                            {{ $hostel->name }}
                        </p>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Hostel assignment can only be changed by the administrator.
                        </p>

                    </div>

                </div>


                {{-- Buttons --}}
                <div
                    class="mt-8 flex flex-col-reverse gap-3
                       border-t border-slate-200 pt-6
                       sm:flex-row sm:justify-end
                       dark:border-slate-800">

                    <a href="{{ route('profile') }}"
                        class="inline-flex items-center
                           justify-center rounded-lg
                           border border-slate-300
                           px-5 py-2.5 text-sm font-semibold
                           text-slate-700
                           hover:bg-slate-50
                           dark:border-slate-700
                           dark:text-slate-300
                           dark:hover:bg-slate-800">

                        Cancel

                    </a>

                    <button type="submit"
                        class="inline-flex items-center
                           justify-center rounded-lg
                           bg-blue-600 px-5 py-2.5
                           text-sm font-semibold text-white
                           hover:bg-blue-700">

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
