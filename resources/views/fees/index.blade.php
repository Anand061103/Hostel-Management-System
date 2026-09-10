@extends('layouts.admin')

@section('title', 'Fees')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Fees
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Manage student fees and payments
            </p>
        </div>

        <a href="{{ route('fees.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold
                  text-white hover:bg-blue-700">
            + Add Fee
        </a>

    </div>


    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Total Fees --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Total Fees
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-800 dark:text-white">
                ₹{{ number_format($totalFeeAmount, 2) }}
            </p>

        </div>


        {{-- Total Paid --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Total Collected
            </p>

            <p class="mt-2 text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                ₹{{ number_format($totalPaid, 2) }}
            </p>

        </div>


        {{-- Outstanding --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Outstanding
            </p>

            <p class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">
                ₹{{ number_format($totalOutstanding, 2) }}
            </p>

        </div>


        {{-- Pending Fees --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Pending Fees
            </p>

            <p class="mt-2 text-2xl font-bold text-amber-600 dark:text-amber-400">
                {{ $pendingFees }}
            </p>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50
                    px-4 py-3 text-sm text-emerald-700
                    dark:border-emerald-900 dark:bg-emerald-900/20
                    dark:text-emerald-400">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="mb-4 rounded-lg border border-red-200 bg-red-50
                    px-4 py-3 text-sm text-red-700
                    dark:border-red-900 dark:bg-red-900/20
                    dark:text-red-400">
            {{ session('error') }}
        </div>

    @endif


    {{-- Fees Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200
                bg-white shadow-sm
                dark:border-slate-800 dark:bg-slate-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                {{-- Header --}}
                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Student
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Fee Type
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Paid
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Remaining
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Due Date
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Action
                        </th>

                    </tr>

                </thead>


                {{-- Body --}}
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse($fees as $fee)

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">

                            {{-- Student --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center
                                                justify-center rounded-full
                                                bg-blue-100 font-semibold
                                                text-blue-600
                                                dark:bg-blue-900/30
                                                dark:text-blue-400">
                                        {{ strtoupper(substr($fee->student->full_name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-800 dark:text-white">
                                            {{ $fee->student->full_name }}
                                        </p>

                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            ID: {{ $fee->student->id }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Fee Type --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $fee->fee_type }}
                            </td>


                            {{-- Amount --}}
                            <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">
                                ₹{{ number_format($fee->amount, 2) }}
                            </td>


                            {{-- Paid --}}
                            <td class="px-6 py-4 font-medium text-emerald-600 dark:text-emerald-400">
                                ₹{{ number_format($fee->paid_amount, 2) }}
                            </td>


                            {{-- Remaining --}}
                            <td class="px-6 py-4 font-medium
                                       {{ $fee->remaining_amount > 0
                                            ? 'text-red-600 dark:text-red-400'
                                            : 'text-emerald-600 dark:text-emerald-400' }}">
                                ₹{{ number_format($fee->remaining_amount, 2) }}
                            </td>


                            {{-- Due Date --}}
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                {{ $fee->due_date->format('d M Y') }}
                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if($fee->remaining_amount <= 0)

                                    <span class="rounded-full bg-emerald-100 px-3 py-1
                                                 text-xs font-medium text-emerald-700
                                                 dark:bg-emerald-900/30
                                                 dark:text-emerald-400">
                                        Paid
                                    </span>

                                @elseif($fee->paid_amount > 0)

                                    <span class="rounded-full bg-amber-100 px-3 py-1
                                                 text-xs font-medium text-amber-700
                                                 dark:bg-amber-900/30
                                                 dark:text-amber-400">
                                        Partial
                                    </span>

                                @else

                                    <span class="rounded-full bg-red-100 px-3 py-1
                                                 text-xs font-medium text-red-700
                                                 dark:bg-red-900/30
                                                 dark:text-red-400">
                                        Pending
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">

                                <a href="{{ route('fees.show', $fee) }}"
                                   class="text-blue-600 hover:text-blue-800
                                          dark:text-blue-400">
                                    View
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-6 py-12 text-center">

                                <div class="text-4xl">
                                    💰
                                </div>

                                <p class="mt-3 text-lg font-semibold
                                          text-slate-600 dark:text-slate-300">
                                    No fees found
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Add a fee to get started.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($fees->hasPages())

            <div class="flex justify-center border-t border-slate-200
                        px-6 py-4 dark:border-slate-800">

                {{ $fees->links('pagination::tailwind') }}

            </div>

        @endif

    </div>

</div>

@endsection