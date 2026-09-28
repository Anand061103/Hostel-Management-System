@extends('layouts.admin')

@section('content')

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Reset Password
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Create a new password for your account.
                </p>
            </div>

            {{-- Card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">

                <div class="p-6">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div
                            class="mb-5 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        {{-- Token --}}
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>

                            <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required
                                readonly
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                                   bg-gray-100 dark:bg-gray-800
                                   text-gray-900 dark:text-white
                                   focus:outline-none">
                        </div>

                        {{-- New Password --}}
                        <div class="mb-5">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                New Password
                            </label>

                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                placeholder="Enter new password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                                   bg-white dark:bg-gray-800
                                   text-gray-900 dark:text-white
                                   placeholder-gray-400
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   focus:outline-none">
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-6">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirm New Password
                            </label>

                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Confirm new password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600
                                   bg-white dark:bg-gray-800
                                   text-gray-900 dark:text-white
                                   placeholder-gray-400
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   focus:outline-none">
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full py-3 px-4 rounded-lg bg-blue-600 hover:bg-blue-700
                               text-white font-semibold transition">
                            Reset Password
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

@endsection
