@extends('layouts.admin')

@section('title', 'Students')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Students
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Manage all hostel students
                <span class="mx-1">•</span>
                Total Students:
                <span class="font-semibold text-slate-700 dark:text-slate-200">
                    {{ $students->total() }}
                </span>
            </p>
        </div>


        <div class="flex items-center gap-3">

            {{-- Bulk Delete --}}
            <form
                action="{{ route('students.bulkDestroy') }}"
                method="POST"
                id="bulk-delete-form"
                onsubmit="return confirm('Are you sure you want to delete the selected students?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    id="bulk-delete-btn"
                    disabled
                    class="cursor-not-allowed rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white opacity-50 hover:bg-red-700"
                >
                    Delete Selected
                </button>
            </form>


            {{-- Add Student --}}
            <a
                href="{{ route('students.create') }}"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                + Add Student
            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif


    {{-- Error Message --}}
    @if (session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900 dark:bg-red-900/20 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif


    {{-- Students Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                {{-- Table Header --}}
                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        {{-- Select All --}}
                        <th class="px-6 py-4">
                            <input
                                type="checkbox"
                                id="select-all"
                                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                            >
                        </th>


                        {{-- ID --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            ID
                        </th>


                        {{-- Student --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Student
                        </th>


                        {{-- Email --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Email
                        </th>


                        {{-- Mobile --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Mobile
                        </th>


                        {{-- Joining Date --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Joining Date
                        </th>


                        {{-- Status --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>


                        {{-- Action --}}
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Action
                        </th>

                    </tr>

                </thead>


                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse ($students as $student)

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">

                            {{-- Checkbox --}}
                            <td class="px-6 py-4">

                                <input
                                    type="checkbox"
                                    name="student_ids[]"
                                    value="{{ $student->id }}"
                                    form="bulk-delete-form"
                                    class="student-checkbox h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                >

                            </td>


                            {{-- ID --}}
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                                {{ $student->id }}
                            </td>


                            {{-- Student --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-semibold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ strtoupper(substr($student->full_name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-800 dark:text-white">
                                            {{ $student->full_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            {{ $student->father_name }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $student->email ?? '—' }}
                            </td>


                            {{-- Mobile --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $student->mobile_number }}
                            </td>


                            {{-- Joining Date --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ \Carbon\Carbon::parse($student->joining_date)->format('d M Y') }}
                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if ($student->status === 'active')

                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        Active
                                    </span>

                                @else

                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">

                                {{-- View --}}
                                <a
                                    href="{{ route('students.show', $student) }}"
                                    class="mr-3 text-blue-600 hover:text-blue-800"
                                >
                                    View
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('students.edit', $student) }}"
                                    class="mr-3 text-amber-600 hover:text-amber-800"
                                >
                                    Edit
                                </a>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('students.destroy', $student) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this student?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-6 py-12 text-center">

                                <p class="text-lg font-semibold text-slate-600 dark:text-slate-300">
                                    No students found
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Add your first student to get started.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
       @if ($students->hasPages())

    <div class="flex justify-center border-t border-slate-200 px-6 py-4 dark:border-slate-800">
        {{ $students->links('pagination::tailwind') }}
    </div>

@endif

    </div>

</div>


{{-- Select / Bulk Delete JavaScript --}}
<script>

    const selectAll = document.getElementById('select-all');

    const checkboxes = document.querySelectorAll('.student-checkbox');

    const deleteButton = document.getElementById('bulk-delete-btn');


    function updateDeleteButton() {

        const selected = document.querySelectorAll(
            '.student-checkbox:checked'
        );

        if (selected.length > 0) {

            deleteButton.disabled = false;

            deleteButton.classList.remove(
                'opacity-50',
                'cursor-not-allowed'
            );

        } else {

            deleteButton.disabled = true;

            deleteButton.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            );

        }

    }


    // Select All
    selectAll?.addEventListener('change', function () {

        checkboxes.forEach(function (checkbox) {

            checkbox.checked = selectAll.checked;

        });

        updateDeleteButton();

    });


    // Individual Checkbox
    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            const selectedCount =
                document.querySelectorAll(
                    '.student-checkbox:checked'
                ).length;

            selectAll.checked =
                selectedCount === checkboxes.length;

            updateDeleteButton();

        });

    });


</script>

@endsection