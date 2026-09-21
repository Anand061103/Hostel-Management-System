@extends('layouts.admin')

@section('content')
    <div class="p-6">

        <div class="max-w-3xl mx-auto">

            {{-- Header --}}
            <div class="mb-6">

                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Add Warden
                </h1>

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Create a warden account and assign a hostel.
                </p>

            </div>


            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="mb-6 rounded-lg
                            bg-green-100 text-green-700
                            dark:bg-green-900/30 dark:text-green-400
                            px-4 py-3">

                    {{ session('success') }}

                </div>
            @endif


            {{-- Form Card --}}
            <div
                class="bg-white dark:bg-slate-900
                        border border-slate-200 dark:border-slate-800
                        rounded-xl shadow-sm p-6">

                <form action="{{ route('wardens.store') }}" method="POST">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- Name --}}
                        <div class="md:col-span-2">

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Warden Name
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
                                placeholder="Enter warden name">

                            @error('name')
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

                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="off"
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
                                placeholder="Enter warden email">

                            @error('email')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Hostel --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Assign Hostel
                            </label>

                            <select name="hostel_id" required
                                class="w-full rounded-lg
                                       border border-slate-300
                                       bg-white text-slate-900
                                       dark:border-slate-700
                                       dark:bg-slate-800
                                       dark:text-white
                                       focus:border-blue-500
                                       focus:ring-blue-500">

                                <option value="">
                                    Select Hostel
                                </option>

                                @foreach ($hostels as $hostel)
                                    <option value="{{ $hostel->id }}"
                                        {{ old('hostel_id') == $hostel->id ? 'selected' : '' }}>
                                        {{ $hostel->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('hostel_id')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Password --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Password
                            </label>

                            <input type="password" name="password" required
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
                                placeholder="Enter password">

                            @error('password')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Confirm Password --}}
                        <div>

                            <label
                                class="block text-sm font-medium
                                       text-slate-700 dark:text-slate-300 mb-2">
                                Confirm Password
                            </label>

                            <input type="password" name="password_confirmation" required
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
                                placeholder="Confirm password">

                        </div>

                    </div>


                    {{-- Button --}}
                    <div class="flex justify-end mt-6">

                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg
                                   bg-blue-600 text-white
                                   hover:bg-blue-700 transition">
                            Create Warden
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
