@extends('layouts.admin')

@section('content')

    <div class="p-6">

        <div class="mx-auto max-w-4xl">

            {{-- Header --}}
            <div class="mb-6">

                <div class="mb-3">
                    <a href="{{ route('wardens.show', $warden) }}"
                        class="inline-flex items-center gap-2 text-sm font-medium
                               text-slate-500 transition hover:text-blue-600
                               dark:text-slate-400 dark:hover:text-blue-400">
                        <span>←</span>
                        Back to Warden
                    </a>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                            Edit Warden
                        </h1>

                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Update {{ $warden->name }}'s information.
                        </p>
                    </div>

                    <div
                        class="hidden rounded-lg bg-blue-50 px-3 py-2 text-xs
                               font-medium text-blue-700 sm:block
                               dark:bg-blue-900/20 dark:text-blue-400">
                        Warden Account
                    </div>

                </div>

            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())
                <div
                    class="mb-6 rounded-xl border border-red-200
                           bg-red-50 px-4 py-3
                           dark:border-red-900/50
                           dark:bg-red-900/20">

                    <div class="flex items-start gap-3">

                        <span class="text-red-500">⚠️</span>

                        <div>

                            <p class="text-sm font-semibold text-red-700 dark:text-red-400">
                                Please fix the following errors:
                            </p>

                            <ul class="mt-1 list-inside list-disc text-sm text-red-600 dark:text-red-400">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                </div>
            @endif


            {{-- Form Card --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200
                       bg-white shadow-sm
                       dark:border-slate-800 dark:bg-slate-900">

                <form action="{{ route('wardens.update', $warden) }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">

                    @csrf
                    @method('PUT')


                    {{-- ================================================= --}}
                    {{-- Personal Information --}}
                    {{-- ================================================= --}}

                    <div class="border-b border-slate-200 dark:border-slate-800">

                        <div class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center justify-center
                                           rounded-xl bg-blue-100 text-lg
                                           dark:bg-blue-900/30">
                                    👤
                                </div>

                                <div>
                                    <h2 class="text-base font-semibold text-slate-800 dark:text-white">
                                        Personal Information
                                    </h2>

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Update the warden's personal details.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="px-6 pb-6">

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                {{-- Name --}}
                                <div>

                                    <label for="name"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Warden Name
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input id="name" type="text" name="name"
                                        value="{{ old('name', $warden->name) }}" required
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                    @error('name')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Email --}}
                                <div>

                                    <label for="email"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Email Address
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input id="email" type="email" name="email"
                                        value="{{ old('email', $warden->email) }}" required
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                    @error('email')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Mobile --}}
                                <div>

                                    <label for="mobile_number"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Mobile Number
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input id="mobile_number" type="tel" name="mobile_number"
                                        value="{{ old('mobile_number', $warden->mobile_number) }}" required
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                    @error('mobile_number')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Joining Date --}}
                                <div>

                                    <label for="joining_date"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Joining Date
                                    </label>

                                    <input id="joining_date" type="date" name="joining_date"
                                        value="{{ old('joining_date', optional($warden->joining_date)->format('Y-m-d')) }}"
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                    @error('joining_date')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Address --}}
                                <div class="md:col-span-2">

                                    <label for="address"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Address
                                    </label>

                                    <textarea id="address" name="address" rows="3"
                                        class="w-full resize-none rounded-xl border
                                               border-slate-300 bg-white px-4 py-3
                                               text-sm text-slate-900 outline-none
                                               transition focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">{{ old('address', $warden->address) }}</textarea>

                                    @error('address')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Current / New Photo --}}
                                <div class="md:col-span-2">

                                    <label for="photo"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Warden Photo
                                    </label>

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                                        @if ($warden->photo)
                                            <img src="{{ asset('storage/' . $warden->photo) }}" alt="{{ $warden->name }}"
                                                class="h-16 w-16 rounded-xl object-cover">
                                        @else
                                            <div
                                                class="flex h-16 w-16 items-center justify-center
                                                       rounded-xl bg-blue-600 font-bold
                                                       text-white">
                                                {{ strtoupper(substr($warden->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <input id="photo" type="file" name="photo"
                                            accept="image/jpeg,image/png,image/webp"
                                            class="block w-full rounded-xl border
                                                   border-slate-300 bg-white
                                                   text-sm text-slate-600
                                                   file:mr-4 file:rounded-lg
                                                   file:border-0 file:bg-blue-600
                                                   file:px-4 file:py-2.5
                                                   file:text-sm file:font-semibold
                                                   file:text-white
                                                   hover:file:bg-blue-500
                                                   dark:border-slate-700
                                                   dark:bg-slate-800
                                                   dark:text-slate-300">

                                    </div>

                                    <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Leave empty to keep the current photo. JPG, PNG or WEBP, maximum 2MB.
                                    </p>

                                    @error('photo')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- Hostel & Identity --}}
                    {{-- ================================================= --}}

                    <div class="border-b border-slate-200 dark:border-slate-800">

                        <div class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center justify-center
                                           rounded-xl bg-purple-100 text-lg
                                           dark:bg-purple-900/30">
                                    🏢
                                </div>

                                <div>
                                    <h2 class="text-base font-semibold text-slate-800 dark:text-white">
                                        Hostel & Identity
                                    </h2>

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Update hostel assignment and identity details.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="px-6 pb-6">

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                {{-- Hostel --}}
                                <div>

                                    <label for="hostel_id"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Assign Hostel
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select id="hostel_id" name="hostel_id" required
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                        <option value="">
                                            Select Hostel
                                        </option>

                                        @foreach ($hostels as $hostel)
                                            <option value="{{ $hostel->id }}"
                                                {{ old('hostel_id', $warden->hostel_id) == $hostel->id ? 'selected' : '' }}>
                                                {{ $hostel->name }}

                                                @if ($warden->hostel_id == $hostel->id)
                                                    — Current
                                                @endif

                                            </option>
                                        @endforeach

                                    </select>

                                    @error('hostel_id')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Aadhaar --}}
                                <div>

                                    <label for="aadhaar_number"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Aadhaar Number
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input id="aadhaar_number" type="text" name="aadhaar_number"
                                        value="{{ old('aadhaar_number', $warden->aadhaar_number) }}" required
                                        inputmode="numeric" maxlength="20" autocomplete="off"
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                    @error('aadhaar_number')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Account Number --}}
                                <div>

                                    <label for="account_number"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Bank Account Number
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input id="account_number" type="text" name="account_number"
                                        value="{{ old('account_number', $warden->account_number) }}" required
                                        inputmode="numeric" maxlength="30" autocomplete="off"
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white">

                                    @error('account_number')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>
                                <div>

                                    <label for="ifsc_code"
                                        class="mb-2 block text-sm font-semibold
               text-slate-700 dark:text-slate-300">
                                        IFSC Code
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input id="ifsc_code" type="text" name="ifsc_code"
                                        value="{{ old('ifsc_code', $warden->ifsc_code ?? '') }}" required maxlength="20"
                                        autocomplete="off" placeholder="Enter IFSC code"
                                        class="w-full rounded-xl border border-slate-300
                                                bg-white px-4 py-3 text-sm text-slate-900
                                                placeholder-slate-400 outline-none transition
                                                focus:border-blue-500
                                                focus:ring-2 focus:ring-blue-500/20
                                                dark:border-slate-700
                                                dark:bg-slate-800
                                                dark:text-white
                                                dark:placeholder-slate-500">

                                    @error('ifsc_code')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- Login Credentials --}}
                    {{-- ================================================= --}}

                    <div>

                        <div class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-10 w-10 items-center justify-center
                                           rounded-xl bg-green-100 text-lg
                                           dark:bg-green-900/30">
                                    🔐
                                </div>

                                <div>
                                    <h2 class="text-base font-semibold text-slate-800 dark:text-white">
                                        Login Credentials
                                    </h2>

                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Leave password empty to keep the current password.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="px-6 pb-6">

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                {{-- Password --}}
                                <div>

                                    <label for="password"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        New Password
                                    </label>

                                    <input id="password" type="password" name="password" autocomplete="new-password"
                                        placeholder="Enter new password"
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               placeholder-slate-400 outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white
                                               dark:placeholder-slate-500">

                                    <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">
                                        Minimum 8 characters.
                                    </p>

                                    @error('password')
                                        <p class="mt-1.5 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Confirm Password --}}
                                <div>

                                    <label for="password_confirmation"
                                        class="mb-2 block text-sm font-semibold
                                               text-slate-700 dark:text-slate-300">
                                        Confirm New Password
                                    </label>

                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        autocomplete="new-password" placeholder="Confirm new password"
                                        class="w-full rounded-xl border border-slate-300
                                               bg-white px-4 py-3 text-sm text-slate-900
                                               placeholder-slate-400 outline-none transition
                                               focus:border-blue-500
                                               focus:ring-2 focus:ring-blue-500/20
                                               dark:border-slate-700
                                               dark:bg-slate-800
                                               dark:text-white
                                               dark:placeholder-slate-500">

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div
                        class="flex flex-col-reverse gap-3 border-t
                               border-slate-200 bg-slate-50 px-6 py-4
                               sm:flex-row sm:items-center sm:justify-end
                               dark:border-slate-800 dark:bg-slate-950/50">

                        <a href="{{ route('wardens.show', $warden) }}"
                            class="inline-flex items-center justify-center
                                   rounded-xl border border-slate-300
                                   bg-white px-5 py-2.5 text-sm font-semibold
                                   text-slate-700 transition hover:bg-slate-100
                                   dark:border-slate-700
                                   dark:bg-slate-900
                                   dark:text-slate-300
                                   dark:hover:bg-slate-800">
                            Cancel
                        </a>

                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2
                                   rounded-xl bg-blue-600 px-6 py-2.5
                                   text-sm font-semibold text-white
                                   shadow-sm transition hover:bg-blue-500
                                   focus:outline-none
                                   focus:ring-2 focus:ring-blue-500/30">
                            ✓
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
