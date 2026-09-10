@extends('layouts.admin')

@section('title', 'Add Fee')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('fees.index') }}"
           class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
            ← Back to Fees
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-800 dark:text-white">
            Add Fee
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Create a new fee for a student
        </p>
    </div>


    {{-- Form --}}
   <div class="mx-auto max-w-3xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm
            dark:border-slate-700 dark:bg-slate-800">
        <form action="{{ route('fees.store') }}" method="POST">

            @csrf


            {{-- Student --}}
            <div class="mb-5">

                <label for="student_id"
                       class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Student <span class="text-red-500">*</span>
                </label>

                <select
                    id="student_id"
                    name="student_id"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                           text-sm text-slate-800 outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >

                    <option value="">Select Student</option>

                    @foreach($students as $student)

                        <option
                            value="{{ $student->id }}"
                            {{ old('student_id') == $student->id ? 'selected' : '' }}
                        >
                            {{ $student->full_name }} — ID: {{ $student->id }}
                        </option>

                    @endforeach

                </select>

                @error('student_id')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Fee Type --}}
            <div class="mb-5">

                <label for="fee_type"
                       class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Fee Type <span class="text-red-500">*</span>
                </label>

                <select
                    id="fee_type"
                    name="fee_type"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                           text-sm text-slate-800 outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >

                    <option value="">Select Fee Type</option>

                    <option value="Monthly Fee"
                        {{ old('fee_type') === 'Monthly Fee' ? 'selected' : '' }}>
                        Monthly Fee
                    </option>

                    <option value="Mess Fee"
                        {{ old('fee_type') === 'Mess Fee' ? 'selected' : '' }}>
                        Mess Fee
                    </option>

                    <option value="Electricity Fee"
                        {{ old('fee_type') === 'Electricity Fee' ? 'selected' : '' }}>
                        Electricity Fee
                    </option>

                    <option value="Maintenance Fee"
                        {{ old('fee_type') === 'Maintenance Fee' ? 'selected' : '' }}>
                        Maintenance Fee
                    </option>

                    <option value="Late Fee"
                        {{ old('fee_type') === 'Late Fee' ? 'selected' : '' }}>
                        Late Fee
                    </option>

                    <option value="Other"
                        {{ old('fee_type') === 'Other' ? 'selected' : '' }}>
                        Other
                    </option>

                </select>

                @error('fee_type')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Description --}}
            <div class="mb-5">

                <label for="description"
                       class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Description
                    <span class="text-xs font-normal text-slate-400">(Optional)</span>
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    placeholder="Enter any additional details..."
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                           text-sm text-slate-800 outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Amount --}}
            <div class="mb-5">

                <label for="amount"
                       class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Amount <span class="text-red-500">*</span>
                </label>

                <div class="relative">

                    <span class="absolute left-4 top-1/2 -translate-y-1/2
                                 text-sm font-medium text-slate-500">
                        ₹
                    </span>

                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        value="{{ old('amount') }}"
                        min="0.01"
                        step="0.01"
                        required
                        placeholder="3000"
                        class="w-full rounded-lg border border-slate-300 bg-white
                               py-3 pl-9 pr-4 text-sm text-slate-800 outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                    >

                </div>

                @error('amount')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Period --}}
            <div class="mb-5 grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Period Start --}}
                <div>

                    <label for="period_start"
                           class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                        Period Start
                        <span class="text-xs font-normal text-slate-400">(Optional)</span>
                    </label>

                    <input
                        type="date"
                        id="period_start"
                        name="period_start"
                        value="{{ old('period_start') }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                    >

                    @error('period_start')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Period End --}}
                <div>

                    <label for="period_end"
                           class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                        Period End
                        <span class="text-xs font-normal text-slate-400">(Optional)</span>
                    </label>

                    <input
                        type="date"
                        id="period_end"
                        name="period_end"
                        value="{{ old('period_end') }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                    >

                    @error('period_end')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Due Date --}}
            <div class="mb-6">

                <label for="due_date"
                       class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Due Date <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                    value="{{ old('due_date') }}"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                           text-sm text-slate-800 outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >

                @error('due_date')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">

                <a href="{{ route('fees.index') }}"
                   class="rounded-lg border border-slate-300 px-5 py-3
                          text-sm font-medium text-slate-700
                          transition hover:bg-slate-50
                          dark:border-slate-600 dark:text-slate-200
                          dark:hover:bg-slate-700">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium
                           text-white transition hover:bg-blue-700">
                    Create Fee
                </button>

            </div>

        </form>

    </div>

</div>

@endsection