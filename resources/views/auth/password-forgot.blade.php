@extends('layouts.admin')

@section('title', 'Password Recovery')

@section('content')

    <div class="min-h-screen bg-slate-100 px-6 py-10 dark:bg-slate-950">

        <div class="mx-auto max-w-xl">

            {{-- Header --}}
            <div class="mb-8 text-center">

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Password Recovery
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Enter your registered email address to receive a password reset link.
                </p>

            </div>


            {{-- Card --}}
            <div
                class="rounded-xl border border-slate-200
                   bg-white shadow-sm
                   dark:border-slate-800 dark:bg-slate-900">

                <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                        Forgot Your Password?
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        We will send a secure password reset link to your email.
                    </p>

                </div>


                <form method="POST" action="{{ route('password.email') }}" class="p-6">

                    @csrf


                    {{-- Success Message --}}
                    @if (session('status'))
                        <div
                            class="mb-5 rounded-lg border border-green-200
                               bg-green-50 px-4 py-3 text-sm
                               text-green-700
                               dark:border-green-900/50
                               dark:bg-green-900/20
                               dark:text-green-400">

                            {{ session('status') }}

                        </div>
                    @endif


                    {{-- Email --}}
                    <div>

                        <label for="email"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">

                            Email Address

                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            placeholder="Enter your registered email" required autofocus autocomplete="email"
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800
                               outline-none transition
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-700
                               dark:bg-slate-950
                               dark:text-white
                               dark:placeholder-slate-500">

                        @error('email')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Button --}}
                    <div class="mt-6 flex items-center justify-between">

                        <a href="{{ route('profile') }}"
                            class="rounded-lg border border-slate-300
                               px-4 py-2.5 text-sm font-medium
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
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:ring-offset-2
                               dark:focus:ring-offset-slate-900">

                            Send Reset Link

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
