@extends('layouts.admin')

@section('title', 'Security Deposit Details')

@section('content')

<div class="p-6">

    {{-- Back --}}
    <div class="mb-6">

        <a href="{{ route('security-deposits.index') }}"
           class="text-sm text-blue-600 hover:text-blue-700
                  dark:text-blue-400">
            ← Back to Security Deposits
        </a>

    </div>


    {{-- Header --}}
    <div class="mb-6 flex items-start justify-between">

        <div>

            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Security Deposit Details
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Complete security deposit and payment information
            </p>

        </div>


        {{-- Status --}}
        @if($securityDeposit->remaining_amount <= 0)

            <span class="rounded-full bg-emerald-100 px-4 py-2
                         text-sm font-medium text-emerald-700
                         dark:bg-emerald-900/30
                         dark:text-emerald-400">
                Held
            </span>

        @else

            <span class="rounded-full bg-amber-100 px-4 py-2
                         text-sm font-medium text-amber-700
                         dark:bg-amber-900/30
                         dark:text-amber-400">
                Pending
            </span>

        @endif

    </div>


    {{-- Student + Summary --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Student --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6
                    shadow-sm dark:border-slate-700 dark:bg-slate-800
                    lg:col-span-1">

            <p class="text-xs font-semibold uppercase tracking-wider
                      text-slate-400">
                Student
            </p>

            <div class="mt-5 flex items-center gap-4">

                <div class="flex h-14 w-14 items-center justify-center
                            rounded-full bg-blue-100 text-lg font-bold
                            text-blue-600 dark:bg-blue-900/30
                            dark:text-blue-400">

                    {{ strtoupper(
                        substr($securityDeposit->student->full_name, 0, 1)
                    ) }}

                </div>

                <div>

                    <h2 class="font-bold text-slate-800 dark:text-white">
                        {{ $securityDeposit->student->full_name }}
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Student ID: {{ $securityDeposit->student->id }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Required --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6
                    shadow-sm dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Security Required
            </p>

            <p class="mt-3 text-2xl font-bold text-slate-800 dark:text-white">
                ₹{{ number_format($securityDeposit->required_amount, 2) }}
            </p>

        </div>


        {{-- Paid --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6
                    shadow-sm dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Total Paid
            </p>

            <p class="mt-3 text-2xl font-bold text-emerald-600
                      dark:text-emerald-400">
                ₹{{ number_format($securityDeposit->paid_amount, 2) }}
            </p>

        </div>

    </div>


    {{-- Remaining --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6
                shadow-sm dark:border-slate-700 dark:bg-slate-800">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Remaining Security
                </p>

                <p class="mt-2 text-2xl font-bold
                          {{ $securityDeposit->remaining_amount > 0
                                ? 'text-red-600 dark:text-red-400'
                                : 'text-emerald-600 dark:text-emerald-400' }}">

                    ₹{{ number_format(
                        $securityDeposit->remaining_amount,
                        2
                    ) }}

                </p>

            </div>


            @if($securityDeposit->remaining_amount > 0)

                <button
                type="button"
                onclick="openSecurityPaymentModal()"
                class="rounded-lg bg-emerald-600 px-4 py-2.5
                    text-sm font-medium text-white
                    hover:bg-emerald-700">

                Record Payment

            </button>

            @endif

        </div>

    </div>


    {{-- Payment History --}}
    <div class="mt-6 overflow-hidden rounded-xl border
                border-slate-200 bg-white shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

        <div class="border-b border-slate-200 px-6 py-5
                    dark:border-slate-700">

            <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                Payment History
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                All security deposit payments received from this student
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 dark:bg-slate-900">

                    <tr>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Date
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Method
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Reference
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Notes
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-200
                             dark:divide-slate-700">

                    @forelse($securityDeposit->payments as $payment)

                        <tr class="hover:bg-slate-50
                                   dark:hover:bg-slate-900/50">

                            <td class="px-6 py-4 text-slate-700
                                       dark:text-slate-300">

                                {{ $payment->payment_date->format('d M Y') }}

                            </td>


                            <td class="px-6 py-4 font-semibold text-emerald-600
                                       dark:text-emerald-400">

                                ₹{{ number_format($payment->amount, 2) }}

                            </td>


                            <td class="px-6 py-4">

                                <span class="capitalize text-slate-700
                                             dark:text-slate-300">

                                    {{ str_replace(
                                        '_',
                                        ' ',
                                        $payment->payment_method
                                    ) }}

                                </span>

                            </td>


                            <td class="px-6 py-4 text-slate-500
                                       dark:text-slate-400">

                                {{ $payment->reference_no ?: '—' }}

                            </td>


                            <td class="px-6 py-4 text-slate-500
                                       dark:text-slate-400">

                                {{ $payment->notes ?: '—' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-12 text-center">

                                <div class="text-4xl">
                                    💰
                                </div>

                                <p class="mt-3 text-sm font-medium
                                          text-slate-600 dark:text-slate-300">

                                    No payment history found

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- ===================================================== --}}
{{-- SECURITY PAYMENT MODAL --}}
{{-- ===================================================== --}}

<div id="securityPaymentModal"
     class="fixed inset-0 z-50 hidden items-center justify-center
            bg-slate-900/60 px-4 backdrop-blur-sm">

    <div class="w-full max-w-lg rounded-xl bg-white shadow-2xl
                dark:bg-slate-800">

        {{-- Header --}}
        <div class="flex items-start justify-between border-b
                    border-slate-200 px-6 py-5
                    dark:border-slate-700">

            <div>
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Record Security Payment
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Add payment for security deposit
                </p>
            </div>

            <button
                type="button"
                onclick="closeSecurityPaymentModal()"
                class="text-2xl leading-none text-slate-400
                       hover:text-slate-600 dark:hover:text-slate-200">
                &times;
            </button>

        </div>


        {{-- Security Summary --}}
        <div class="grid grid-cols-3 gap-3 px-6 py-5">

            {{-- Required --}}
            <div class="rounded-lg bg-slate-50 p-3
                        dark:bg-slate-700/50">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Required
                </p>

                <p class="mt-1 text-sm font-bold text-slate-800
                          dark:text-white">

                    ₹{{ number_format(
                        $securityDeposit->required_amount,
                        2
                    ) }}

                </p>

            </div>


            {{-- Paid --}}
            <div class="rounded-lg bg-emerald-50 p-3
                        dark:bg-emerald-900/20">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Already Paid
                </p>

                <p class="mt-1 text-sm font-bold text-emerald-600
                          dark:text-emerald-400">

                    ₹{{ number_format(
                        $securityDeposit->paid_amount,
                        2
                    ) }}

                </p>

            </div>


            {{-- Remaining --}}
            <div class="rounded-lg bg-red-50 p-3
                        dark:bg-red-900/20">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Remaining
                </p>

                <p class="mt-1 text-sm font-bold text-red-600
                          dark:text-red-400">

                    ₹{{ number_format(
                        $securityDeposit->remaining_amount,
                        2
                    ) }}

                </p>

            </div>

        </div>


        {{-- Form --}}
        <form
            action="{{ route(
                'security-deposits.recordPayment',
                $securityDeposit
            ) }}"
            method="POST">

            @csrf

            <div class="space-y-5 px-6 pb-6">


                {{-- Student --}}
                <div>

                    <label class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                        Student

                    </label>

                    <div class="rounded-lg border border-slate-200
                                bg-slate-50 px-4 py-3 text-sm font-medium
                                text-slate-700
                                dark:border-slate-700
                                dark:bg-slate-900
                                dark:text-slate-200">

                        {{ $securityDeposit->student->full_name }}

                    </div>

                </div>


                {{-- Payment Amount --}}
                <div>

                    <label for="security_payment_amount"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                        Payment Amount
                        <span class="text-red-500">*</span>

                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2
                                     -translate-y-1/2 text-sm
                                     font-medium text-slate-500">
                            ₹
                        </span>

                        <input
                            type="number"
                            id="security_payment_amount"
                            name="amount"
                            min="0.01"
                            max="{{ $securityDeposit->remaining_amount }}"
                            step="0.01"
                            required
                            placeholder="Enter amount"
                            class="w-full rounded-lg border border-slate-300
                                   bg-white py-3 pl-9 pr-4 text-sm
                                   text-slate-800 outline-none
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-500/20
                                   dark:border-slate-600
                                   dark:bg-slate-900
                                   dark:text-white"
                        >

                    </div>

                    <p id="securityPaymentAmountError"
                       class="mt-1 hidden text-xs text-red-500">
                    </p>

                </div>


                {{-- Payment Date --}}
                <div>

                    <label for="security_payment_date"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                        Payment Date
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="date"
                        id="security_payment_date"
                        name="payment_date"
                        value="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm
                               text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white"
                    >

                </div>


                {{-- Payment Method --}}
                <div>

                    <label for="security_payment_method"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                        Payment Method
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        id="security_payment_method"
                        name="payment_method"
                        required
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm
                               text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white">

                        <option value="cash">Cash</option>

                        <option value="upi">UPI</option>

                        <option value="bank_transfer">
                            Bank Transfer
                        </option>

                        <option value="card">Card</option>

                        <option value="other">Other</option>

                    </select>

                </div>


                {{-- Reference --}}
                <div>

                    <label for="security_reference_no"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                        Reference No.
                        <span class="text-xs font-normal text-slate-400">
                            (Optional)
                        </span>

                    </label>

                    <input
                        type="text"
                        id="security_reference_no"
                        name="reference_no"
                        placeholder="UPI / transaction reference"
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm
                               text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white"
                    >

                </div>


                {{-- Notes --}}
                <div>

                    <label for="security_payment_notes"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                        Notes
                        <span class="text-xs font-normal text-slate-400">
                            (Optional)
                        </span>

                    </label>

                    <textarea
                        id="security_payment_notes"
                        name="notes"
                        rows="3"
                        placeholder="Any additional details..."
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm
                               text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white"
                    ></textarea>

                </div>


                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-2">

                    <button
                        type="button"
                        onclick="closeSecurityPaymentModal()"
                        class="rounded-lg border border-slate-300
                               px-5 py-2.5 text-sm font-medium
                               text-slate-700 hover:bg-slate-50
                               dark:border-slate-600
                               dark:text-slate-300
                               dark:hover:bg-slate-700">

                        Cancel

                    </button>


                    <button
                        type="submit"
                        id="recordSecurityPaymentButton"
                        class="rounded-lg bg-emerald-600 px-5 py-2.5
                               text-sm font-medium text-white
                               hover:bg-emerald-700">

                        Record Payment

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>

const securityRemainingAmount =
    {{ $securityDeposit->remaining_amount }};


/*
|--------------------------------------------------------------------------
| Open Modal
|--------------------------------------------------------------------------
*/

function openSecurityPaymentModal()
{
    const modal =
        document.getElementById('securityPaymentModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document
        .getElementById('security_payment_amount')
        .focus();
}


/*
|--------------------------------------------------------------------------
| Close Modal
|--------------------------------------------------------------------------
*/

function closeSecurityPaymentModal()
{
    const modal =
        document.getElementById('securityPaymentModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/*
|--------------------------------------------------------------------------
| Prevent Overpayment
|--------------------------------------------------------------------------
*/

document
    .getElementById('security_payment_amount')
    .addEventListener('input', function () {

        const amount =
            parseFloat(this.value);

        const error =
            document.getElementById(
                'securityPaymentAmountError'
            );

        const button =
            document.getElementById(
                'recordSecurityPaymentButton'
            );


        if (amount > securityRemainingAmount) {

            error.textContent =
                'Payment cannot be greater than ₹' +
                Number(securityRemainingAmount)
                    .toLocaleString('en-IN');

            error.classList.remove('hidden');

            button.disabled = true;

            button.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            );

        } else {

            error.textContent = '';

            error.classList.add('hidden');

            button.disabled = false;

            button.classList.remove(
                'opacity-50',
                'cursor-not-allowed'
            );

        }

    });


/*
|--------------------------------------------------------------------------
| Close By Clicking Outside
|--------------------------------------------------------------------------
*/

document
    .getElementById('securityPaymentModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {
            closeSecurityPaymentModal();
        }

    });


/*
|--------------------------------------------------------------------------
| Close With Escape
|--------------------------------------------------------------------------
*/

document.addEventListener('keydown', function (event) {

    if (event.key === 'Escape') {
        closeSecurityPaymentModal();
    }

});

</script>




@endsection