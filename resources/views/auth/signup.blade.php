<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up | Hostel Management System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    <div class="min-h-screen flex items-center justify-center p-4">

        <div class="w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl">

            <div class="grid min-h-[600px] md:grid-cols-2">

                {{-- LEFT SIDE --}}
                <div class="hidden md:flex flex-col justify-between bg-slate-900 p-10 text-white">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-xl font-bold">
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

                    <div>

                        <p class="mb-3 text-sm font-medium uppercase tracking-wider text-blue-400">
                            Get Started
                        </p>

                        <h2 class="text-4xl font-bold leading-tight">
                            Create your
                            <span class="text-blue-500">
                                account.
                            </span>
                        </h2>

                        <p class="mt-5 max-w-md leading-7 text-slate-400">
                            Create an account to manage hostel operations
                            from one simple and powerful platform.
                        </p>

                    </div>

                    <div class="text-sm text-slate-500">
                        © {{ date('Y') }} Hostel Management System
                    </div>

                </div>


                {{-- RIGHT SIDE --}}
                <div class="flex items-center justify-center p-6 sm:p-10">

                    <div class="w-full max-w-md">

                        {{-- Mobile Logo --}}
                        <div class="mb-8 text-center md:hidden">

                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-xl font-bold text-white">
                                H
                            </div>

                            <h1 class="text-xl font-bold text-slate-900">
                                Hostel Management
                            </h1>

                        </div>


                        {{-- Heading --}}
                        <div class="mb-7">

                            <h2 class="text-3xl font-bold text-slate-900">
                                Create account
                            </h2>

                            <p class="mt-2 text-sm text-slate-500">
                                Fill in your details to create your account.
                            </p>

                        </div>


                        {{-- Signup Form --}}
                        <form action="#" method="POST">

                            @csrf

                            {{-- Name --}}
                            <div class="mb-5">

                                <label
                                    for="name"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    required
                                >

                            </div>


                            {{-- Email --}}
                            <div class="mb-5">

                                <label
                                    for="email"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    required
                                >

                            </div>


                            {{-- Password --}}
                            <div class="mb-5">

                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Password
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Create a password"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    required
                                >

                            </div>


                            {{-- Confirm Password --}}
                            <div class="mb-6">

                                <label
                                    for="password_confirmation"
                                    class="mb-2 block text-sm font-semibold text-slate-700"
                                >
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Confirm your password"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                                    required
                                >

                            </div>


                            {{-- Signup Button --}}
                            <button
                                type="submit"
                                class="w-full rounded-lg bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition duration-200 hover:bg-blue-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-200"
                            >
                                Create Account
                            </button>

                        </form>


                        {{-- Login Link --}}
                        <p class="mt-7 text-center text-sm text-slate-500">

                            Already have an account?

                            <a
                                href="{{ route('login') }}"
                                class="font-semibold text-blue-600 hover:text-blue-700"
                            >
                                Sign in
                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>