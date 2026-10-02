<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account - HostelHub</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen overflow-hidden bg-slate-950">

    <div class="flex h-screen w-full">

        {{-- =====================================================
            LEFT SIDE
        ====================================================== --}}
        <div
            class="hidden lg:flex lg:w-[42%] xl:w-[40%] h-screen shrink-0
                   bg-slate-950 text-white
                   border-r border-slate-800
                   flex-col justify-between
                   px-12 py-12">

            {{-- TOP --}}
            <div>

                <a href="{{ route('home') }}" class="inline-block text-2xl font-bold tracking-tight">
                    <span class="text-white">Hostel</span><span class="text-blue-500">Hub</span>
                </a>


                {{-- HERO --}}
                <div class="mt-24">

                    <p class="text-sm font-semibold uppercase tracking-wider text-blue-400">
                        Get Started
                    </p>


                    <h1
                        class="mt-5 text-5xl xl:text-6xl font-bold
                               leading-[1.08] tracking-tight">
                        Manage your
                        <br>

                        property

                        <span class="block text-blue-500">
                            smarter.
                        </span>
                    </h1>


                    <p
                        class="mt-7 max-w-md
                               text-base xl:text-lg
                               leading-8 text-slate-400">
                        Create your owner account and manage
                        your hostel or apartment from one
                        powerful platform.
                    </p>


                    {{-- SMALL FEATURE POINTS --}}
                    <div class="mt-12 space-y-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg bg-blue-500/10
                                       text-blue-400">
                                ✓
                            </div>

                            <span class="text-sm text-slate-400">
                                Manage everything from one place
                            </span>

                        </div>


                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg bg-blue-500/10
                                       text-blue-400">
                                ✓
                            </div>

                            <span class="text-sm text-slate-400">
                                Built for modern property owners
                            </span>

                        </div>


                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-8 w-8 items-center justify-center
                                       rounded-lg bg-blue-500/10
                                       text-blue-400">
                                ✓
                            </div>

                            <span class="text-sm text-slate-400">
                                Hostel & apartment management
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="text-sm text-slate-600">
                © {{ date('Y') }} HostelHub. All rights reserved.
            </div>

        </div>


        {{-- =====================================================
            RIGHT SIDE
        ====================================================== --}}
        <div
            class="h-screen w-full lg:w-[58%] xl:w-[60%]
                   overflow-y-auto
                   bg-slate-900">

            {{-- FORM CONTAINER --}}
            <div
                class="min-h-full
                       px-5 py-10
                       sm:px-8
                       lg:px-12
                       xl:px-20">

                <div class="mx-auto max-w-2xl">

                    {{-- MOBILE LOGO --}}
                    <div class="mb-10 lg:hidden">

                        <a href="{{ route('home') }}" class="text-2xl font-bold">
                            <span class="text-white">Hostel</span><span class="text-blue-500">Hub</span>
                        </a>

                    </div>


                    {{-- HEADER --}}
                    <div class="mb-10">

                        <h2 class="text-3xl font-bold tracking-tight text-white">
                            Create your account
                        </h2>

                        <p class="mt-2 text-slate-400">
                            Enter your details to get started.
                        </p>

                    </div>


                    {{-- ERRORS --}}
                    @if ($errors->any())

                        <div
                            class="mb-8 rounded-xl
                                   border border-red-500/30
                                   bg-red-500/10
                                   p-4">

                            <p class="font-semibold text-red-400">
                                Please fix the following errors:
                            </p>

                            <ul class="mt-2 list-disc pl-5
                                       text-sm text-red-300">

                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- =================================================
                        FORM
                    ================================================== --}}
                    <form action="{{ route('signup.store') }}" method="POST">

                        @csrf


                        {{-- PERSONAL INFORMATION --}}
                        <div
                            class="mb-10 rounded-2xl
                                   border border-slate-800
                                   bg-slate-950/40
                                   p-6 sm:p-7">

                            <div class="mb-6">

                                <h3 class="text-lg font-bold text-white">
                                    Personal Information
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Tell us a little about yourself.
                                </p>

                            </div>


                            {{-- NAME --}}
                            <div class="mb-5">

                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-300">
                                    Full Name
                                </label>

                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- EMAIL --}}
                            <div class="mb-5">

                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-300">
                                    Email Address
                                </label>

                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- MOBILE --}}
                            <div>

                                <label for="mobile_number" class="mb-2 block text-sm font-semibold text-slate-300">
                                    Mobile Number
                                </label>

                                <input type="text" id="mobile_number" name="mobile_number"
                                    value="{{ old('mobile_number') }}" placeholder="Enter mobile number"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>

                        </div>


                        {{-- MANAGEMENT TYPE --}}
                        <div
                            class="mb-10 rounded-2xl
                                   border border-slate-800
                                   bg-slate-950/40
                                   p-6 sm:p-7">

                            <div class="mb-6">

                                <h3 class="text-lg font-bold text-white">
                                    What do you want to manage?
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Choose the type of property you want
                                    to manage.
                                </p>

                            </div>


                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                {{-- HOSTEL --}}
                                <label class="cursor-pointer">

                                    <input type="radio" name="management_type" value="hostel" class="peer sr-only"
                                        {{ old('management_type') === 'hostel' ? 'checked' : '' }} required>

                                    <div
                                        class="rounded-xl
                                               border-2 border-slate-700
                                               bg-slate-900
                                               p-5
                                               transition
                                               hover:border-slate-600
                                               peer-checked:border-blue-500
                                               peer-checked:bg-blue-500/10">

                                        <div class="text-3xl">
                                            🏠
                                        </div>

                                        <h4 class="mt-3 font-bold text-white">
                                            Hostel
                                        </h4>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Manage students, rooms,
                                            beds and fees.
                                        </p>

                                    </div>

                                </label>


                                {{-- APARTMENT --}}
                                <label class="cursor-pointer">

                                    <input type="radio" name="management_type" value="apartment" class="peer sr-only"
                                        {{ old('management_type') === 'apartment' ? 'checked' : '' }} required>

                                    <div
                                        class="rounded-xl
                                               border-2 border-slate-700
                                               bg-slate-900
                                               p-5
                                               transition
                                               hover:border-purple-500
                                               peer-checked:border-purple-500
                                               peer-checked:bg-purple-500/10">

                                        <div class="text-3xl">
                                            🏢
                                        </div>

                                        <h4 class="mt-3 font-bold text-white">
                                            Apartment
                                        </h4>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Manage apartments,
                                            residents and maintenance.
                                        </p>

                                    </div>

                                </label>

                            </div>

                        </div>


                        {{-- BANK DETAILS --}}
                        <div
                            class="mb-10 rounded-2xl
                                   border border-slate-800
                                   bg-slate-950/40
                                   p-6 sm:p-7">

                            <div class="mb-6">

                                <h3 class="text-lg font-bold text-white">
                                    Bank Details
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Enter your bank details for your
                                    account setup.
                                </p>

                            </div>


                            {{-- PAN --}}
                            <div class="mb-5">

                                <label for="pan_number" class="mb-2 block text-sm font-semibold text-slate-300">
                                    PAN Number
                                </label>

                                <input type="text" id="pan_number" name="pan_number"
                                    value="{{ old('pan_number') }}" maxlength="10" placeholder="ABCDE1234F"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           uppercase
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- ACCOUNT HOLDER --}}
                            <div class="mb-5">

                                <label for="bank_account_holder_name"
                                    class="mb-2 block text-sm font-semibold text-slate-300">
                                    Bank Account Holder Name
                                </label>

                                <input type="text" id="bank_account_holder_name" name="bank_account_holder_name"
                                    value="{{ old('bank_account_holder_name') }}"
                                    placeholder="Name as per bank account"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- ACCOUNT NUMBER --}}
                            <div class="mb-5">

                                <label for="bank_account_number"
                                    class="mb-2 block text-sm font-semibold text-slate-300">
                                    Bank Account Number
                                </label>

                                <input type="text" id="bank_account_number" name="bank_account_number"
                                    value="{{ old('bank_account_number') }}" placeholder="Enter bank account number"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- CONFIRM ACCOUNT NUMBER --}}
                            <div class="mb-5">

                                <label for="bank_account_number_confirmation"
                                    class="mb-2 block text-sm font-semibold text-slate-300">
                                    Confirm Bank Account Number
                                </label>

                                <input type="text" id="bank_account_number_confirmation"
                                    name="bank_account_number_confirmation" placeholder="Re-enter bank account number"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- IFSC --}}
                            <div>

                                <label for="ifsc_code" class="mb-2 block text-sm font-semibold text-slate-300">
                                    IFSC Code
                                </label>

                                <input type="text" id="ifsc_code" name="ifsc_code"
                                    value="{{ old('ifsc_code') }}" maxlength="11" placeholder="SBIN0001234"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           uppercase
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>

                        </div>


                        {{-- SECURITY --}}
                        <div
                            class="mb-10 rounded-2xl
                                   border border-slate-800
                                   bg-slate-950/40
                                   p-6 sm:p-7">

                            <div class="mb-6">

                                <h3 class="text-lg font-bold text-white">
                                    Security
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Create a secure password for your
                                    account.
                                </p>

                            </div>


                            {{-- PASSWORD --}}
                            <div class="mb-5">

                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-300">
                                    Password
                                </label>

                                <input type="password" id="password" name="password"
                                    placeholder="Minimum 8 characters"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>


                            {{-- CONFIRM PASSWORD --}}
                            <div>

                                <label for="password_confirmation"
                                    class="mb-2 block text-sm font-semibold text-slate-300">
                                    Confirm Password
                                </label>

                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Re-enter your password"
                                    class="w-full rounded-xl
                                           border border-slate-700
                                           bg-slate-900
                                           px-4 py-3
                                           text-sm text-white
                                           placeholder-slate-600
                                           outline-none
                                           transition
                                           focus:border-blue-500
                                           focus:ring-4
                                           focus:ring-blue-500/10"
                                    required>

                            </div>

                        </div>


                        {{-- SUBMIT --}}
                        <button type="submit"
                            class="w-full rounded-xl
                                bg-blue-600
                                px-5 py-4
                                text-sm font-semibold
                                text-white
                                transition
                                hover:bg-blue-500
                                focus:outline-none
                                focus:ring-4
                                focus:ring-blue-500/20">
                            Continue to Plans →
                        </button>


                        {{-- LOGIN --}}
                        <p class="mt-6 pb-10 text-center text-sm text-slate-500">
                            Already have an account?

                            <a href="{{ route('login') }}"
                                class="font-semibold text-blue-400
                                       transition hover:text-blue-300">
                                Login
                            </a>

                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
