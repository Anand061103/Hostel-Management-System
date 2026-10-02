@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">

        <a href="{{ route('students.index') }}"
           class="text-sm text-blue-600 hover:text-blue-700">
            ← Back to Students
        </a>

        <h1 class="mt-3 text-2xl font-bold text-slate-800 dark:text-white">
            Edit Student
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Update student information
        </p>

    </div>


    {{-- Form --}}
    <form action="{{ route('students.update', $student) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                {{-- Full Name --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="full_name"
                        value="{{ old('full_name', $student->full_name) }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    @error('full_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Father Name --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Father's Name
                    </label>

                    <input
                        type="text"
                        name="father_name"
                        value="{{ old('father_name', $student->father_name) }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    @error('father_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $student->email) }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Aadhaar --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Aadhaar Number
                    </label>

                    <input
                        type="text"
                        name="aadhar_number"
                        value="{{ old('aadhar_number', $student->aadhar_number) }}"
                        maxlength="12"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    @error('aadhar_number')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Mobile --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Mobile Number
                    </label>

                    <input
                        type="text"
                        name="mobile_number"
                        value="{{ old('mobile_number', $student->mobile_number) }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    @error('mobile_number')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Joining Date --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Joining Date
                    </label>

                    <input
                        type="date"
                        name="joining_date"
                        value="{{ old('joining_date', $student->joining_date) }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                    @error('joining_date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >

                        <option value="active"
                            {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $student->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Address --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Address
                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >{{ old('address', $student->address) }}</textarea>

                    @error('address')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Current Image --}}
                @if($student->image)

                    <div class="md:col-span-2">

                        <p class="mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                            Current Photo
                        </p>

                        <img
                            src="{{ asset('storage/' . $student->image) }}"
                            alt="{{ $student->full_name }}"
                            class="h-24 w-24 rounded-lg object-cover"
                        >

                    </div>

                @endif


                {{-- New Image --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Change Photo
                    </label>

                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-medium dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:file:bg-slate-700 dark:file:text-slate-200"
                    >

                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>

            </div>


            {{-- Buttons --}}
            <div class="mt-8 flex justify-end gap-3">

                <a href="{{ route('students.index') }}"
                   class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    Update Student
                </button>

            </div>

        </div>

    </form>

</div>

@endsection