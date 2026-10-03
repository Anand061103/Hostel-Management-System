<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apartment Onboarding</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

    <div class="min-h-screen flex">

        {{-- LEFT SIDE --}}
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-950 via-blue-950 to-slate-900 p-12 items-center">

            <div class="max-w-lg">

                <div class="mb-8">
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full
                        bg-blue-500/10 border border-blue-500/20
                        text-blue-400 text-sm font-medium">

                        ApartmentHub

                    </span>
                </div>


                <h1 class="text-5xl font-bold leading-tight mb-6">

                    Let's set up your

                    <span class="text-blue-500">
                        Apartment
                    </span>

                </h1>


                <p class="text-slate-400 text-lg leading-relaxed mb-10">

                    Just a few details about your property and you're ready to
                    start managing everything from one powerful dashboard.

                </p>


                <div class="space-y-5">

                    {{-- Feature 1 --}}
                    <div class="flex items-center gap-4">

                        <div
                            class="w-10 h-10 rounded-xl bg-blue-500/10
                            border border-blue-500/20 flex items-center justify-center">

                            ✓

                        </div>

                        <div>

                            <p class="font-medium">
                                Manage your property
                            </p>

                            <p class="text-sm text-slate-500">
                                Buildings, flats, residents & facilities
                            </p>

                        </div>

                    </div>


                    {{-- Feature 2 --}}
                    <div class="flex items-center gap-4">

                        <div
                            class="w-10 h-10 rounded-xl bg-blue-500/10
                            border border-blue-500/20 flex items-center justify-center">

                            ✓

                        </div>

                        <div>

                            <p class="font-medium">
                                Track maintenance
                            </p>

                            <p class="text-sm text-slate-500">
                                Maintenance and outstanding payments
                            </p>

                        </div>

                    </div>


                    {{-- Feature 3 --}}
                    <div class="flex items-center gap-4">

                        <div
                            class="w-10 h-10 rounded-xl bg-blue-500/10
                            border border-blue-500/20 flex items-center justify-center">

                            ✓

                        </div>

                        <div>

                            <p class="font-medium">
                                Manage your community
                            </p>

                            <p class="text-sm text-slate-500">
                                Residents and property operations
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center
            p-6 sm:p-10 overflow-y-auto">

            <div class="w-full max-w-xl py-8">

                {{-- Heading --}}
                <div class="mb-8">

                    <p class="text-blue-500 text-sm font-semibold mb-2">
                        FINAL STEP
                    </p>

                    <h2 class="text-3xl font-bold mb-2">
                        Setup your apartment
                    </h2>

                    <p class="text-slate-400">
                        Enter your property details to complete your account setup.
                    </p>

                </div>


                {{-- Errors --}}
                @if ($errors->any())

                    <div class="mb-6 rounded-xl border border-red-500/20
                        bg-red-500/10 p-4">

                        <div class="text-red-400 text-sm space-y-1">

                            @foreach ($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach

                        </div>

                    </div>

                @endif


                {{-- Form --}}
                <form action="{{ route('apartment.onboarding.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">

                    @csrf


                    {{-- Property Name --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">

                            Property Name

                        </label>

                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Enter property name" required
                            class="w-full rounded-xl bg-slate-900
                            border border-slate-700 px-4 py-3.5
                            text-white placeholder-slate-500
                            focus:outline-none focus:border-blue-500
                            focus:ring-2 focus:ring-blue-500/20">

                    </div>


                    {{-- Property Photo --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">

                            Property Photo

                        </label>

                        <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full text-sm text-slate-400
                            file:mr-4 file:py-3 file:px-4
                            file:rounded-lg file:border-0
                            file:bg-blue-600 file:text-white
                            file:font-medium hover:file:bg-blue-700
                            cursor-pointer">

                        <p class="mt-2 text-xs text-slate-500">
                            JPG, JPEG, PNG or WEBP — maximum 2MB
                        </p>

                    </div>


                    {{-- Property Address --}}
                    <div>

                        <label class="block text-sm font-medium text-slate-300 mb-2">

                            Property Address

                        </label>

                        <textarea name="address" rows="3" placeholder="Enter complete property address" required
                            class="w-full rounded-xl bg-slate-900
                            border border-slate-700 px-4 py-3.5
                            text-white placeholder-slate-500
                            focus:outline-none focus:border-blue-500
                            focus:ring-2 focus:ring-blue-500/20">{{ old('address') }}</textarea>

                    </div>


                    {{-- City + State --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- City --}}
                        <div>

                            <label class="block text-sm font-medium text-slate-300 mb-2">

                                City

                            </label>

                            <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter city"
                                required
                                class="w-full rounded-xl bg-slate-900
                                border border-slate-700 px-4 py-3.5
                                text-white placeholder-slate-500
                                focus:outline-none focus:border-blue-500
                                focus:ring-2 focus:ring-blue-500/20">

                        </div>


                        {{-- State --}}
                        <div>

                            <label class="block text-sm font-medium text-slate-300 mb-2">

                                State

                            </label>

                            <input type="text" name="state" value="{{ old('state') }}" placeholder="Enter state"
                                required
                                class="w-full rounded-xl bg-slate-900
                                border border-slate-700 px-4 py-3.5
                                text-white placeholder-slate-500
                                focus:outline-none focus:border-blue-500
                                focus:ring-2 focus:ring-blue-500/20">

                        </div>

                    </div>


                    {{-- Pincode + Property Type --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Pincode --}}
                        <div>

                            <label class="block text-sm font-medium text-slate-300 mb-2">

                                Pincode

                            </label>

                            <input type="text" name="pincode" value="{{ old('pincode') }}"
                                placeholder="Enter pincode" maxlength="6" required
                                class="w-full rounded-xl bg-slate-900
                                border border-slate-700 px-4 py-3.5
                                text-white placeholder-slate-500
                                focus:outline-none focus:border-blue-500
                                focus:ring-2 focus:ring-blue-500/20">

                        </div>


                        {{-- Property Type --}}
                        <div>

                            <label class="block text-sm font-medium text-slate-300 mb-2">

                                Property Type

                            </label>

                            <select name="type" required
                                class="w-full rounded-xl bg-slate-900
                                border border-slate-700 px-4 py-3.5
                                text-white
                                focus:outline-none focus:border-blue-500
                                focus:ring-2 focus:ring-blue-500/20">

                                <option value="">
                                    Select property type
                                </option>

                                <option value="Apartment Society"
                                    {{ old('type') === 'Apartment Society' ? 'selected' : '' }}>
                                    Apartment Society
                                </option>

                                <option value="Gated Community"
                                    {{ old('type') === 'Gated Community' ? 'selected' : '' }}>
                                    Gated Community
                                </option>

                                <option value="Residential Complex"
                                    {{ old('type') === 'Residential Complex' ? 'selected' : '' }}>
                                    Residential Complex
                                </option>

                                <option value="Builder Apartment"
                                    {{ old('type') === 'Builder Apartment' ? 'selected' : '' }}>
                                    Builder Apartment
                                </option>

                                <option value="Other" {{ old('type') === 'Other' ? 'selected' : '' }}>
                                    Other
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full rounded-xl bg-blue-600
                        hover:bg-blue-700 transition
                        px-6 py-4 font-semibold text-white
                        shadow-lg shadow-blue-600/20">

                        Create Account & Continue to Login

                    </button>


                    <p class="text-center text-xs text-slate-500">

                        Your account will be created after submitting these details.

                    </p>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
