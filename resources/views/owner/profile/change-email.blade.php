```blade
@extends('layouts.admin')

@section('title', 'Change Email')

@section('content')

    <div class="min-h-screen bg-slate-100 px-6 py-10 dark:bg-slate-950">

        {{-- Center Container --}}
        <div class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-3xl items-center justify-center">

            {{-- Main Card --}}
            <div
                class="w-full max-w-xl rounded-xl border border-slate-200
                    bg-white shadow-sm
                    dark:border-slate-800 dark:bg-slate-900">

                {{-- Header --}}
                <div class="border-b border-slate-200 p-6
                        dark:border-slate-800">

                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                        Change Email Address
                    </h1>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Update the email address you use to sign in to your account.
                    </p>

                </div>


                {{-- Form --}}
                <form action="{{ route('profile.email.update') }}" method="POST" class="space-y-6 p-6">

                    @csrf
                    @method('PUT')


                    {{-- Current Email Information --}}
                    <div
                        class="rounded-lg border border-slate-200
                            bg-slate-50 p-4
                            dark:border-slate-700
                            dark:bg-slate-800/50">

                        <p
                            class="text-xs font-medium uppercase tracking-wide
                                    text-slate-500 dark:text-slate-400">
                            Current Email Address
                        </p>

                        <p
                            class="mt-1 text-sm font-semibold
                                  text-slate-800 dark:text-white">
                            {{ $user->email }}
                        </p>

                    </div>


                    {{-- New Email --}}
                    <div>

                        <label for="email"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                            New Email Address
                        </label>

                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            autocomplete="off" placeholder="Enter your new email address"
                            class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-2.5 text-sm
                               text-slate-800 outline-none transition
                               placeholder:text-slate-400
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-700
                               dark:bg-slate-950
                               dark:text-white">

                        @error('email')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Confirm Email --}}
                    <div>

                        <label for="email_confirmation"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                            Confirm New Email Address
                        </label>

                        <input type="email" id="email_confirmation" name="email_confirmation"
                            value="{{ old('email_confirmation') }}" required autocomplete="off"
                            placeholder="Re-enter your new email address"
                            class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-2.5 text-sm
                               text-slate-800 outline-none transition
                               placeholder:text-slate-400
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-700
                               dark:bg-slate-950
                               dark:text-white">

                        @error('email_confirmation')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Current Password --}}
                    <div>

                        <label for="current_password"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">
                            Current Password
                        </label>

                        <div class="relative">

                            <input type="password" id="current_password" name="current_password" required
                                autocomplete="new-password" placeholder="Enter your current password"
                                class="w-full rounded-lg border border-slate-300
                                   bg-white px-4 py-2.5 pr-12 text-sm
                                   text-slate-800 outline-none transition
                                   placeholder:text-slate-400
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-500/20
                                   dark:border-slate-700
                                   dark:bg-slate-950
                                   dark:text-white">

                            {{-- Eye Button --}}
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2
                                   -translate-y-1/2
                                   text-slate-500 transition
                                   hover:text-slate-700
                                   dark:text-slate-400
                                   dark:hover:text-slate-200"
                                aria-label="Show password">

                                <span id="eyeOpen">
                                    👁️
                                </span>

                                <span id="eyeClosed" class="hidden">
                                    🙈
                                </span>

                            </button>

                        </div>

                        @error('current_password')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Security Notice --}}
                    <div
                        class="rounded-lg border border-blue-200
                            bg-blue-50 p-4
                            dark:border-blue-900/50
                            dark:bg-blue-900/10">

                        <p class="text-sm text-blue-700 dark:text-blue-400">
                            After changing your email address, the new email
                            will need to be verified again.
                        </p>

                    </div>


                    {{-- Actions --}}
                    <div
                        class="flex items-center justify-end gap-3
                            border-t border-slate-200 pt-6
                            dark:border-slate-800">

                        <a href="{{ route('profile') }}"
                            class="rounded-lg border border-slate-300
                               px-5 py-2.5 text-sm font-medium
                               text-slate-700 transition
                               hover:bg-slate-100
                               dark:border-slate-700
                               dark:text-slate-300
                               dark:hover:bg-slate-800">
                            Cancel
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2.5
                               text-sm font-semibold text-white
                               transition hover:bg-blue-700
                               focus:outline-none focus:ring-2
                               focus:ring-blue-500
                               focus:ring-offset-2
                               dark:focus:ring-offset-slate-900">
                            Update Email
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- Password Show / Hide --}}
    <script>
        const passwordInput = document.getElementById('current_password');
        const togglePassword = document.getElementById('togglePassword');

        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');


        togglePassword.addEventListener('click', function() {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');

                togglePassword.setAttribute(
                    'aria-label',
                    'Hide password'
                );

            } else {

                passwordInput.type = 'password';

                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');

                togglePassword.setAttribute(
                    'aria-label',
                    'Show password'
                );

            }

        });
    </script>

@endsection
