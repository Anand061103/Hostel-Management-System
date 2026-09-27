@extends('layouts.admin')

@section('title', 'Change Password')

@section('content')

    <div class="min-h-screen bg-slate-100 px-6 py-10 dark:bg-slate-950">

        <div class="mx-auto flex min-h-[calc(100vh-5rem)]
                max-w-3xl items-center justify-center">

            <div
                class="w-full max-w-xl rounded-xl
                    border border-slate-200
                    bg-white shadow-sm
                    dark:border-slate-800
                    dark:bg-slate-900">


                {{-- Header --}}
                <div class="border-b border-slate-200 p-6
                        dark:border-slate-800">

                    <h1 class="text-2xl font-bold
                           text-slate-800 dark:text-white">

                        Change Password

                    </h1>

                    <p class="mt-1 text-sm
                          text-slate-500 dark:text-slate-400">

                        Update the password you use to sign in
                        to your account.

                    </p>

                </div>


                {{-- Form --}}
                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6 p-6">

                    @csrf
                    @method('PUT')


                    {{-- Current Password --}}
                    <div>

                        <label for="current_password"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                            Current Password
                        </label>


                        <div class="relative">

                            <input type="password" id="current_password" name="current_password" required
                                autocomplete="current-password" placeholder="Enter your current password"
                                class="w-full rounded-lg
                                   border border-slate-300
                                   bg-white px-4 py-2.5 pr-12
                                   text-sm text-slate-800
                                   outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">


                            <button type="button" onclick="togglePassword('current_password', 'currentEye')"
                                class="absolute right-3 top-1/2
                                   -translate-y-1/2
                                   text-slate-500
                                   hover:text-slate-700
                                   dark:text-slate-400
                                   dark:hover:text-slate-200">

                                <span id="currentEye">
                                    👁️
                                </span>

                            </button>

                        </div>


                        @error('current_password')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- New Password --}}
                    <div>

                        <label for="password"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                            New Password
                        </label>


                        <div class="relative">

                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                placeholder="Enter your new password"
                                class="w-full rounded-lg
                                   border border-slate-300
                                   bg-white px-4 py-2.5 pr-12
                                   text-sm text-slate-800
                                   outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">


                            <button type="button" onclick="togglePassword('password', 'newEye')"
                                class="absolute right-3 top-1/2
                                   -translate-y-1/2
                                   text-slate-500
                                   hover:text-slate-700
                                   dark:text-slate-400
                                   dark:hover:text-slate-200">

                                <span id="newEye">
                                    👁️
                                </span>

                            </button>

                        </div>


                        @error('password')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror


                        <p class="mt-2 text-xs
                              text-slate-500 dark:text-slate-400">

                            Password must be at least 8 characters.

                        </p>

                    </div>


                    {{-- Confirm Password --}}
                    <div>

                        <label for="password_confirmation"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                            Confirm New Password
                        </label>


                        <div class="relative">

                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Re-enter your new password"
                                class="w-full rounded-lg
                                   border border-slate-300
                                   bg-white px-4 py-2.5 pr-12
                                   text-sm text-slate-800
                                   outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">


                            <button type="button"
                                onclick="togglePassword(
                                'password_confirmation',
                                'confirmEye'
                            )"
                                class="absolute right-3 top-1/2
                                   -translate-y-1/2
                                   text-slate-500
                                   hover:text-slate-700
                                   dark:text-slate-400
                                   dark:hover:text-slate-200">

                                <span id="confirmEye">
                                    👁️
                                </span>

                            </button>

                        </div>

                    </div>


                    {{-- Security Notice --}}
                    <div
                        class="rounded-lg border
                            border-blue-200
                            bg-blue-50 p-4
                            dark:border-blue-900/50
                            dark:bg-blue-900/10">

                        <p
                            class="text-sm
                              text-blue-700
                              dark:text-blue-400">

                            After changing your password, use the new
                            password the next time you sign in.

                        </p>

                    </div>


                    {{-- Buttons --}}
                    <div
                        class="flex items-center justify-end gap-3
                            border-t border-slate-200 pt-6
                            dark:border-slate-800">

                        <a href="{{ route('profile') }}"
                            class="rounded-lg border
                               border-slate-300
                               px-5 py-2.5
                               text-sm font-medium
                               text-slate-700
                               transition hover:bg-slate-100
                               dark:border-slate-700
                               dark:text-slate-300
                               dark:hover:bg-slate-800">
                            Cancel
                        </a>


                        <button type="submit"
                            class="rounded-lg bg-blue-600
                               px-5 py-2.5
                               text-sm font-semibold
                               text-white transition
                               hover:bg-blue-700
                               focus:outline-none
                               focus:ring-2
                               focus:ring-blue-500
                               focus:ring-offset-2
                               dark:focus:ring-offset-slate-900">
                            Update Password
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>
        function togglePassword(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);

            if (input.type === 'password') {

                input.type = 'text';

                eye.textContent = '🙈';

            } else {

                input.type = 'password';

                eye.textContent = '👁️';

            }
        }
    </script>

@endsection
