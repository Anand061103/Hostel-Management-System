@extends('layouts.admin')

@section('title', 'Fee Details')

@section('content')

    <div class="p-6">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="mb-6 flex items-start justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Fee Details
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Complete fee and payment information
                </p>
            </div>


            {{-- Status --}}
            @if ($fee->remaining_amount <= 0)
                <span
                    class="rounded-full bg-emerald-100 px-4 py-2 text-xs
                         font-semibold text-emerald-700
                         dark:bg-emerald-900/30 dark:text-emerald-400">
                    Paid
                </span>
            @elseif($fee->paid_amount > 0)
                <span
                    class="rounded-full bg-amber-100 px-4 py-2 text-xs
                         font-semibold text-amber-700
                         dark:bg-amber-900/30 dark:text-amber-400">
                    Partial
                </span>
            @elseif($fee->status === 'cancelled')
                <span
                    class="rounded-full bg-slate-200 px-4 py-2 text-xs
                         font-semibold text-slate-700
                         dark:bg-slate-700 dark:text-slate-300">
                    Cancelled
                </span>
            @else
                <span
                    class="rounded-full bg-red-100 px-4 py-2 text-xs
                         font-semibold text-red-700
                         dark:bg-red-900/30 dark:text-red-400">
                    Pending
                </span>
            @endif

        </div>



        {{-- ===================================================== --}}
        {{-- STUDENT CARD --}}
        {{-- ===================================================== --}}

        <div
            class="mb-6 rounded-xl border border-slate-200 bg-white
                p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

            <p
                class="mb-4 text-xs font-semibold uppercase tracking-wider
                  text-slate-500 dark:text-slate-400">
                Student
            </p>


            <div class="flex items-center gap-4">

                {{-- Avatar --}}
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center
                        rounded-full bg-blue-100 text-lg font-bold text-blue-600
                        dark:bg-blue-900/30 dark:text-blue-400">

                    {{ strtoupper(substr($fee->student->full_name, 0, 1)) }}

                </div>


                {{-- Student Info --}}
                <div>

                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                        {{ $fee->student->full_name }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Student ID: {{ $fee->student->id }}
                    </p>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- FEE INFORMATION --}}
        {{-- ===================================================== --}}

        <div
            class="mb-6 rounded-xl border border-slate-200 bg-white
                p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

            <div class="mb-5">

                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Fee Information
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Details of this fee
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">


                {{-- Fee Type --}}
                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Fee Type
                    </p>

                    <p class="mt-1 font-semibold text-slate-800 dark:text-white">
                        {{ $fee->fee_type }}
                    </p>

                </div>


                {{-- Due Date --}}
                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Due Date
                    </p>

                    <p class="mt-1 font-semibold text-slate-800 dark:text-white">
                        {{ $fee->due_date->format('d M Y') }}
                    </p>

                </div>


                {{-- Period Start --}}
                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Period Start
                    </p>

                    <p class="mt-1 font-semibold text-slate-800 dark:text-white">

                        @if ($fee->period_start)
                            {{ $fee->period_start->format('d M Y') }}
                        @else
                            —
                        @endif

                    </p>

                </div>


                {{-- Period End --}}
                <div>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Period End
                    </p>

                    <p class="mt-1 font-semibold text-slate-800 dark:text-white">

                        @if ($fee->period_end)
                            {{ $fee->period_end->format('d M Y') }}
                        @else
                            —
                        @endif

                    </p>

                </div>


                {{-- Description --}}
                <div class="sm:col-span-2">

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Description
                    </p>

                    <p class="mt-1 font-medium text-slate-800 dark:text-slate-200">

                        @if ($fee->description)
                            {{ $fee->description }}
                        @else
                            —
                        @endif

                    </p>

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- FEE SUMMARY --}}
        {{-- ===================================================== --}}

        <div class="mb-6 grid grid-cols-1 gap-5 md:grid-cols-3">


            {{-- Total Fee --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-6 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Total Fee
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-800 dark:text-white">
                    ₹{{ number_format($fee->amount, 2) }}
                </p>

            </div>


            {{-- Total Paid --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-6 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Total Paid
                </p>

                <p class="mt-2 text-2xl font-bold text-emerald-600
                      dark:text-emerald-400">
                    ₹{{ number_format($fee->paid_amount, 2) }}
                </p>

            </div>


            {{-- Remaining --}}
            <div
                class="rounded-xl border border-slate-200 bg-white
                    p-6 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                    Remaining
                </p>

                <p
                    class="mt-2 text-2xl font-bold
                      {{ $fee->remaining_amount > 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">

                    ₹{{ number_format($fee->remaining_amount, 2) }}

                </p>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- PAYMENT HISTORY --}}
        {{-- ===================================================== --}}

        <div
            class="overflow-hidden rounded-xl border border-slate-200
                bg-white shadow-sm
                dark:border-slate-800 dark:bg-slate-900">


            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5
                    dark:border-slate-800">

                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Payment History
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    All fee payments received from this student
                </p>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50 dark:bg-slate-800">

                        <tr>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                                Date
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                                Amount
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                                Method
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                                Reference
                            </th>

                            <th
                                class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                                Notes
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-200
                             dark:divide-slate-800">

                        @forelse($fee->payments->sortByDesc('payment_date') as $payment)
                            <tr class="hover:bg-slate-50
                                   dark:hover:bg-slate-800/50">


                                {{-- Date --}}
                                <td
                                    class="px-6 py-4 text-slate-600
                                       dark:text-slate-300">

                                    {{ $payment->payment_date->format('d M Y') }}

                                </td>


                                {{-- Amount --}}
                                <td
                                    class="px-6 py-4 font-semibold
                                       text-emerald-600
                                       dark:text-emerald-400">

                                    ₹{{ number_format($payment->amount, 2) }}

                                </td>


                                {{-- Method --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="capitalize text-slate-700
                                             dark:text-slate-300">

                                        {{ str_replace('_', ' ', $payment->payment_method) }}

                                    </span>

                                </td>


                                {{-- Reference --}}
                                <td
                                    class="px-6 py-4 text-slate-600
                                       dark:text-slate-400">

                                    {{ $payment->reference_no ?: '—' }}

                                </td>


                                {{-- Notes --}}
                                <td
                                    class="px-6 py-4 text-slate-600
                                       dark:text-slate-400">

                                    {{ $payment->notes ?: '—' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <div class="text-4xl">
                                        💰
                                    </div>

                                    <p
                                        class="mt-3 text-lg font-semibold
                                          text-slate-600 dark:text-slate-300">
                                        No payments found
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        No payment has been recorded for this fee.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- BACK BUTTON --}}
        {{-- ===================================================== --}}

        <div class="mt-6">

            <a href="{{ route('fees.index') }}"
                class="inline-flex items-center rounded-lg border
                  border-slate-300 px-4 py-2.5 text-sm font-medium
                  text-slate-700 hover:bg-slate-50
                  dark:border-slate-600 dark:text-slate-300
                  dark:hover:bg-slate-800">

                ← Back to Fees

            </a>

        </div>

    </div>

@endsection
