@extends('layouts.admin')

@section('content')
    <div class="p-6">

        <div class="max-w-3xl mx-auto">

            {{-- Page Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Add Hostel
                </h1>

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Add a new hostel to your management system.
                </p>
            </div>


            {{-- Form Card --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-xl shadow-sm
                        border border-slate-200 dark:border-slate-800 p-6">

                <form action="{{ route('hostels.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Hostel Name --}}
                        <div class="md:col-span-2">

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Hostel Name
                            </label>

                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-lg
                                       border border-slate-300
                                       bg-white text-slate-900
                                       placeholder-slate-400
                                       dark:border-slate-700
                                       dark:bg-slate-800
                                       dark:text-white
                                       dark:placeholder-slate-500
                                       focus:border-blue-500
                                       focus:ring-blue-500"
                                placeholder="Enter hostel name">

                            @error('name')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Address --}}
                        <div class="md:col-span-2">

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Address
                            </label>

                            <textarea name="address" rows="3"
                                class="w-full rounded-lg
                                       border border-slate-300
                                       bg-white text-slate-900
                                       placeholder-slate-400
                                       dark:border-slate-700
                                       dark:bg-slate-800
                                       dark:text-white
                                       dark:placeholder-slate-500
                                       focus:border-blue-500
                                       focus:ring-blue-500"
                                placeholder="Enter hostel address">{{ old('address') }}</textarea>

                            @error('address')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Phone --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Phone
                            </label>

                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full rounded-lg
                                       border border-slate-300
                                       bg-white text-slate-900
                                       placeholder-slate-400
                                       dark:border-slate-700
                                       dark:bg-slate-800
                                       dark:text-white
                                       dark:placeholder-slate-500
                                       focus:border-blue-500
                                       focus:ring-blue-500"
                                placeholder="Enter phone number">

                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-lg
                                       border border-slate-300
                                       bg-white text-slate-900
                                       placeholder-slate-400
                                       dark:border-slate-700
                                       dark:bg-slate-800
                                       dark:text-white
                                       dark:placeholder-slate-500
                                       focus:border-blue-500
                                       focus:ring-blue-500"
                                placeholder="Enter email">

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- Warden Details --}}
                    <div class="mt-8 border-t border-slate-200 pt-8 dark:border-slate-800">

                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                                Warden Details
                            </h2>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Assign a warden to this hostel during hostel creation.
                            </p>
                        </div>


                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            {{-- Warden Name --}}
                            <div>
                                <label for="warden_name"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Warden Name *

                                </label>

                                <input type="text" id="warden_name" name="warden_name" value="{{ old('warden_name') }}"
                                    required
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">

                                @error('warden_name')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Warden Email --}}
                            <div>
                                <label for="warden_email"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Warden Email *

                                </label>

                                <input type="email" id="warden_email" name="warden_email"
                                    value="{{ old('warden_email') }}" required
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">

                                @error('warden_email')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Password --}}
                            <div>
                                <label for="warden_password"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Password *

                                </label>

                                <input type="password" id="warden_password" name="warden_password" required
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">

                                @error('warden_password')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Confirm Password --}}
                            <div>
                                <label for="warden_password_confirmation"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Confirm Password *

                                </label>

                                <input type="password" id="warden_password_confirmation" name="warden_password_confirmation"
                                    required
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">

                                @error('warden_password_confirmation')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Mobile --}}
                            <div>
                                <label for="warden_mobile_number"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Mobile Number *

                                </label>

                                <input type="text" id="warden_mobile_number" name="warden_mobile_number"
                                    value="{{ old('warden_mobile_number') }}" required
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">

                                @error('warden_mobile_number')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Joining Date --}}
                            <div>
                                <label for="warden_joining_date"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Joining Date

                                </label>

                                <input type="date" id="warden_joining_date" name="warden_joining_date"
                                    value="{{ old('warden_joining_date') }}"
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">

                                @error('warden_joining_date')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Address --}}
                            <div class="md:col-span-2">

                                <label for="warden_address"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Address

                                </label>

                                <textarea id="warden_address" name="warden_address" rows="3"
                                    class="w-full rounded-lg border border-slate-300
                       bg-white px-4 py-2.5 text-sm
                       text-slate-900 outline-none
                       focus:border-blue-500 focus:ring-2
                       focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800
                       dark:text-white">{{ old('warden_address') }}</textarea>

                                @error('warden_address')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Photo --}}
                            <div class="md:col-span-2">

                                <label for="warden_photo"
                                    class="mb-2 block text-sm font-medium
                       text-slate-700 dark:text-slate-300">

                                    Warden Photo

                                </label>

                                <input type="file" id="warden_photo" name="warden_photo"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="block w-full text-sm text-slate-600
                       dark:text-slate-300">

                                @error('warden_photo')
                                    <p class="mt-1 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>
                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 mt-6">

                        <a href="{{ route('hostels.index') }}"
                            class="px-5 py-2.5 rounded-lg
                                   bg-slate-200 text-slate-700
                                   hover:bg-slate-300
                                   dark:bg-slate-800
                                   dark:text-slate-200
                                   dark:hover:bg-slate-700">
                            Cancel
                        </a>

                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg
                                   bg-blue-600 text-white
                                   hover:bg-blue-700">
                            Create Hostel
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
