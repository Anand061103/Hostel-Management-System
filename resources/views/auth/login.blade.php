<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Hostel Management System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex items-center justify-center p-4">

        <div class="w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl">

            <div class="grid min-h-[600px] md:grid-cols-2">

                {{-- LEFT SIDE --}}
                <div class="hidden md:flex flex-col justify-between bg-slate-900 p-10 text-white">

                    <div>

                        {{-- Logo --}}
                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-xl font-bold"
                            >
                                H
                            </div>

                            <div>
                                <h1 class="text-lg font-bold">
                                    Hostel Management
                                </h1>

                                <p class="text-xs text-slate-400">
                                    Management System
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Center Content --}}
                    <div>

                        <p class="mb-3 text-sm font-medium uppercase tracking-wider text-blue-400">
                            Welcome Back
                        </p>

                        <h2 class="text-4xl font-bold leading-tight">
                            Manage your hostel
                            <span class="text-blue-500">
                                smarter.
                            </span>
                        </h2>

                        <p class="mt-5 max-w-md leading-7 text-slate-400">
                            Manage students, rooms, fees and hostel
                            operations from one simple and powerful
                            platform.
                        </p>

                    </div>


                    {{-- Footer --}}
                    <div class="text-sm text-slate-500">
                        © {{ date('Y') }} Hostel Management System
                    </div>

                </div>


                {{-- RIGHT SIDE --}}
                <div class="flex items-center justify-center p-6 sm:p-10">

                    <div class="w-full max-w-md">

                        {{-- Mobile Logo --}}
                        <div class="mb-8 text-center md:hidden">

                            <div
                                class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-xl font-bold text-white"
                            >
                                H
                            </div>

                            <h1 class="text-xl font-bold text-slate-900">
                                Hostel Management
                            </h1>

                        </div>


                        {{-- Heading --}}
                        <div class="mb-8">

                            <h2 class="text-3xl font-bold text-slate-900">
                                Sign in
                            </h2>

                            <p class="mt-2 text-sm text-slate-500">
                                Enter your credentials to access your account.
                            </p>

                        </div>


                        {{-- Error Message --}}
                        @if ($errors->any())

                            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">

                                <div class="flex gap-3">

                                    <div class="text-red-500">
                                        !
                                    </div>

                                    <div>
                                        <p class="text-sm font-semibold text-red-700">
                                            Login failed
                                        </p>

                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $errors->first() }}
                                        </p>
                                    </div>

                                </div>

                            </div>

                        @endif


                        {{-- Login Form --}}
                        <form action="#" method="POST">

                            @csrf


                            {{-- Email --}}
                            <div class="mb-5">

                                <label
                                    for="email"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Email Address
                                </label>

                                <div class="relative">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="Enter your email"
                                        class="w-full rounded-lg border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                        required
                                    >

                                </div>

                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Password --}}
                            <div class="mb-5">

                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Password
                                </label>

                                <div class="relative">

                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <rect
                                                width="16"
                                                height="12"
                                                x="4"
                                                y="10"
                                                rx="2"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                d="M8 10V7a4 4 0 018 0v3M12 15v2"
                                            />
                                        </svg>
                                    </div>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Enter your password"
                                        class="w-full rounded-lg border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                        required
                                    >

                                </div>

                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Remember + Forgot --}}
                            <div class="mb-7 flex items-center justify-between">

                                <label class="flex cursor-pointer items-center gap-2">

                                    <input
                                        type="checkbox"
                                        name="remember"
                                        class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                    >

                                    <span class="text-sm text-slate-600">
                                        Remember me
                                    </span>

                                </label>

                                <a
                                    href="#"
                                    class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                                >
                                    Forgot password?
                                </a>

                            </div>


                            {{-- Login Button --}}
                            <button
                                type="submit"
                                class="w-full rounded-lg bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition duration-200 hover:bg-blue-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-200"
                            >
                                Sign In
                            </button>

                        </form>


                        {{-- Bottom --}}
                        <p class="mt-8 text-center text-xs text-slate-400">
                            Secure access to Hostel Management System
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>