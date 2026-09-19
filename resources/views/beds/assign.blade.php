@extends('layouts.admin')

@section('title', 'Assign Student')

@section('content')

    <div class="p-6">

        {{-- HEADER --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Assign Student
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Assign a student to this available bed
            </p>

        </div>


        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())

            <div
                class="mb-6 rounded-lg border border-red-200
                    bg-red-50 px-4 py-4
                    dark:border-red-900
                    dark:bg-red-900/20">

                <ul class="list-disc space-y-1 pl-5 text-sm
                       text-red-600 dark:text-red-400">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM CARD --}}
        <div
            class="mx-auto max-w-3xl rounded-xl border
                border-slate-200 bg-white shadow-sm
                dark:border-slate-700 dark:bg-slate-800">


            {{-- BED INFORMATION --}}
            <div class="border-b border-slate-200 px-6 py-5
                    dark:border-slate-700">

                <h2 class="text-lg font-bold text-slate-800
                       dark:text-white">

                    Bed Information

                </h2>

                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">

                    <div>

                        <p
                            class="text-xs uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">

                            Bed

                        </p>

                        <p class="mt-1 font-semibold text-slate-800
                              dark:text-white">

                            Bed {{ $bed->bed_number }}

                        </p>

                    </div>


                    <div>

                        <p
                            class="text-xs uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">

                            Room

                        </p>

                        <p class="mt-1 font-semibold text-slate-800
                              dark:text-white">

                            Room {{ $bed->room->room_number }}

                        </p>

                    </div>


                    <div>

                        <p
                            class="text-xs uppercase tracking-wide
                              text-slate-500 dark:text-slate-400">

                            Floor

                        </p>

                        <p class="mt-1 font-semibold text-slate-800
                              dark:text-white">

                            Floor {{ $bed->room->floor }}

                        </p>

                    </div>

                </div>

            </div>


            {{-- FORM --}}
            <form action="{{ route('beds.storeAssignment', $bed) }}" method="POST">

                @csrf

                <div class="space-y-6 px-6 py-6">


                    {{-- STUDENT --}}
                    <div>

                        <label for="student_id"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">

                            Student
                            <span class="text-red-500">*</span>

                        </label>


                        <select id="student_id" name="student_id" required
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white">

                            <option value="">
                                Select Student
                            </option>


                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>

                                    {{ $student->full_name }}
                                    — ID: {{ $student->id }}

                                </option>
                            @endforeach

                        </select>


                        @error('student_id')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- START DATE --}}
                    <div>

                        <label for="start_date"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">

                            Start Date
                            <span class="text-red-500">*</span>

                        </label>


                        <input type="date" id="start_date" name="start_date"
                            value="{{ old('start_date', now()->format('Y-m-d')) }}" required
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white">


                        @error('start_date')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- INFO --}}
                    <div
                        class="rounded-lg border border-blue-200
                            bg-blue-50 px-4 py-3
                            dark:border-blue-900
                            dark:bg-blue-900/20">

                        <p class="text-sm font-semibold text-blue-700
                              dark:text-blue-400">

                            Bed will become Occupied

                        </p>

                        <p class="mt-1 text-xs text-blue-600
                              dark:text-blue-400">

                            An assignment history record will be created
                            and this bed will be marked as occupied.

                        </p>

                    </div>


                    {{-- BUTTONS --}}
                    <div class="flex flex-col-reverse gap-3
                            sm:flex-row sm:justify-end">

                        <a href="{{ route('beds.show', $bed) }}"
                            class="inline-flex items-center justify-center
                               rounded-lg border border-slate-300
                               px-5 py-2.5 text-sm font-medium
                               text-slate-700
                               hover:bg-slate-50
                               dark:border-slate-600
                               dark:text-slate-300
                               dark:hover:bg-slate-700">

                            Cancel

                        </a>


                        <button type="submit"
                            class="inline-flex items-center justify-center
                               rounded-lg bg-emerald-600 px-5 py-2.5
                               text-sm font-semibold text-white
                               hover:bg-emerald-700">

                            Assign Student

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
