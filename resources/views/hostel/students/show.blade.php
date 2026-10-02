@extends('layouts.admin')

@section('title', 'Student Details')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">

        <a href="{{ route('students.index') }}"
           class="text-sm text-blue-600 hover:text-blue-700">
            ← Back to Students
        </a>

        <div class="mt-3 flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Student Details
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    View complete student information
                </p>
            </div>

            <a href="{{ route('students.edit', $student) }}"
               class="rounded-lg bg-amber-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-amber-600">
                Edit Student
            </a>

        </div>

    </div>


    {{-- Student Card --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        {{-- Profile Header --}}
        <div class="border-b border-slate-200 p-6 dark:border-slate-800">

            <div class="flex items-center gap-5">

                @if($student->image)

                    <img
                        src="{{ asset('storage/' . $student->image) }}"
                        alt="{{ $student->full_name }}"
                        class="h-20 w-20 rounded-full object-cover"
                    >

                @else

                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-blue-100 text-2xl font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                        {{ strtoupper(substr($student->full_name, 0, 1)) }}
                    </div>

                @endif


                <div>

                    <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                        {{ $student->full_name }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Father's Name: {{ $student->father_name }}
                    </p>

                    <div class="mt-2">

                        @if($student->status === 'active')

                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                Active
                            </span>

                        @else

                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                Inactive
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Details --}}
        <div class="p-6">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Email
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                        {{ $student->email ?? '—' }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Mobile Number
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                        {{ $student->mobile_number }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Aadhaar Number
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                        {{ $student->aadhar_number }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Joining Date
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                        {{ \Carbon\Carbon::parse($student->joining_date)->format('d M Y') }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Student ID
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                        #{{ $student->id }}
                    </p>
                </div>


                <div class="md:col-span-2 lg:col-span-3">

                    <p class="text-xs font-medium uppercase text-slate-400">
                        Address
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-800 dark:text-white">
                        {{ $student->address }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection