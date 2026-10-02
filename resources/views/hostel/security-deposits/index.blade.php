@extends('layouts.admin')

@section('title', 'Security Deposits')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
            Security Deposits
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Manage student security deposits and balances
        </p>
    </div>


    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Total Required --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Total Required
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-800 dark:text-white">
                ₹{{ number_format($totalRequired, 2) }}
            </p>

        </div>


        {{-- Total Collected --}}
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


        {{-- Pending Deposits --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                Pending Deposits
            </p>

            <p class="mt-2 text-2xl font-bold text-amber-600 dark:text-amber-400">
                {{ $pendingDeposits }}
            </p>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-4 rounded-lg border border-emerald-200
                    bg-emerald-50 px-4 py-3 text-sm text-emerald-700
                    dark:border-emerald-900 dark:bg-emerald-900/20
                    dark:text-emerald-400">

            {{ session('success') }}

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="mb-4 rounded-lg border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-700
                    dark:border-red-900 dark:bg-red-900/20
                    dark:text-red-400">

            {{ session('error') }}

        </div>

    @endif


    {{-- Security Deposit Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200
                bg-white shadow-sm
                dark:border-slate-800 dark:bg-slate-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Student
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase
                                   tracking-wider text-slate-500">
                            Required
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
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold
                                   uppercase tracking-wider text-slate-500">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse($securityDeposits as $securityDeposit)

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

                                        {{ strtoupper(
                                            substr($securityDeposit->student->full_name, 0, 1)
                                        ) }}

                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-800
                                                  dark:text-white">

                                            {{ $securityDeposit->student->full_name }}

                                        </p>

                                        <p class="text-xs text-slate-500
                                                  dark:text-slate-400">

                                            ID: {{ $securityDeposit->student->id }}

                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Required --}}
                            <td class="px-6 py-4 font-medium text-slate-800
                                       dark:text-white">

                                ₹{{ number_format(
                                    $securityDeposit->required_amount,
                                    2
                                ) }}

                            </td>


                            {{-- Paid --}}
                            <td class="px-6 py-4 font-medium text-emerald-600
                                       dark:text-emerald-400">

                                ₹{{ number_format(
                                    $securityDeposit->paid_amount,
                                    2
                                ) }}

                            </td>


                            {{-- Remaining --}}
                            <td class="px-6 py-4 font-medium
                                       {{ $securityDeposit->remaining_amount > 0
                                            ? 'text-red-600 dark:text-red-400'
                                            : 'text-emerald-600 dark:text-emerald-400' }}">

                                ₹{{ number_format(
                                    $securityDeposit->remaining_amount,
                                    2
                                ) }}

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if($securityDeposit->remaining_amount <= 0)

                                    <span class="rounded-full bg-emerald-100
                                                 px-3 py-1 text-xs font-medium
                                                 text-emerald-700
                                                 dark:bg-emerald-900/30
                                                 dark:text-emerald-400">
                                        Held
                                    </span>

                                @else

                                    <span class="rounded-full bg-amber-100
                                                 px-3 py-1 text-xs font-medium
                                                 text-amber-700
                                                 dark:bg-amber-900/30
                                                 dark:text-amber-400">
                                        Pending
                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">

                                <div class="flex items-center justify-end gap-3">

                                    {{-- View --}}
                                   <a href="{{ route('security-deposits.show', $securityDeposit) }}"
                                    class="text-blue-600 hover:text-blue-800
                                            dark:text-blue-400">
                                        View
                                    </a>


                                    {{-- Record Payment --}}
                                    @if($securityDeposit->remaining_amount > 0)

                                        <button
                                    type="button"
                                    onclick="openSecurityPaymentModal(
                                        {{ $securityDeposit->id }},
                                        '{{ addslashes($securityDeposit->student->full_name) }}',
                                        {{ $securityDeposit->required_amount }},
                                        {{ $securityDeposit->paid_amount }},
                                        {{ $securityDeposit->remaining_amount }}
                                    )"
                                    class="rounded-lg bg-emerald-600
                                        px-3 py-2 text-xs font-medium
                                        text-white hover:bg-emerald-700">
                                    Record Payment
                                </button>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-12 text-center">

                                <div class="text-4xl">
                                    🔐
                                </div>

                                <p class="mt-3 text-lg font-semibold
                                          text-slate-600 dark:text-slate-300">
                                    No security deposits found
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Security deposits will appear here
                                    after student admission.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($securityDeposits->hasPages())

            <div class="flex justify-center border-t border-slate-200
                        px-6 py-4 dark:border-slate-800">

                {{ $securityDeposits->links('pagination::tailwind') }}

            </div>

        @endif

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
                    Add a security deposit payment
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


        {{-- Summary --}}
        <div class="grid grid-cols-3 gap-3 px-6 py-5">

            {{-- Required --}}
            <div class="rounded-lg bg-slate-50 p-3
                        dark:bg-slate-700/50">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Required
                </p>

                <p id="securityPaymentRequired"
                   class="mt-1 text-sm font-bold text-slate-800 dark:text-white">
                    ₹0.00
                </p>

            </div>


            {{-- Paid --}}
            <div class="rounded-lg bg-emerald-50 p-3
                        dark:bg-emerald-900/20">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Already Paid
                </p>

                <p id="securityPaymentPaid"
                   class="mt-1 text-sm font-bold text-emerald-600
                          dark:text-emerald-400">
                    ₹0.00
                </p>

            </div>


            {{-- Remaining --}}
            <div class="rounded-lg bg-red-50 p-3
                        dark:bg-red-900/20">

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Remaining
                </p>

                <p id="securityPaymentRemaining"
                   class="mt-1 text-sm font-bold text-red-600
                          dark:text-red-400">
                    ₹0.00
                </p>

            </div>

        </div>


        {{-- Form --}}
        <form id="securityPaymentForm" method="POST">

            @csrf

            <div class="space-y-5 px-6 pb-6">

                {{-- Student --}}
                <div>

                    <label class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">
                        Student
                    </label>

                    <div id="securityPaymentStudent"
                         class="rounded-lg border border-slate-200
                                bg-slate-50 px-4 py-3 text-sm font-medium
                                text-slate-700
                                dark:border-slate-700 dark:bg-slate-900
                                dark:text-slate-200">
                        -
                    </div>

                </div>


                {{-- Payment Amount --}}
                <div>

                    <label for="security_payment_amount"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">
                        Payment Amount <span class="text-red-500">*</span>
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
                            step="0.01"
                            required
                            class="w-full rounded-lg border border-slate-300
                                   bg-white py-3 pl-9 pr-4 text-sm
                                   text-slate-800 outline-none
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-500/20
                                   dark:border-slate-600
                                   dark:bg-slate-900 dark:text-white"
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
                        Payment Date <span class="text-red-500">*</span>
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
                               dark:bg-slate-900 dark:text-white"
                    >

                </div>


                {{-- Payment Method --}}
                <div>

                    <label for="security_payment_method"
                           class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">
                        Payment Method <span class="text-red-500">*</span>
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
                               dark:bg-slate-900 dark:text-white"
                    >

                        <option value="cash">Cash</option>
                        <option value="upi">UPI</option>
                        <option value="bank_transfer">Bank Transfer</option>
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
                               dark:bg-slate-900 dark:text-white"
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
                               dark:bg-slate-900 dark:text-white"
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

let currentSecurityRemainingAmount = 0;


/*
|--------------------------------------------------------------------------
| Open Modal
|--------------------------------------------------------------------------
*/

function openSecurityPaymentModal(
    securityDepositId,
    studentName,
    requiredAmount,
    paidAmount,
    remainingAmount
) {

    const modal =
        document.getElementById('securityPaymentModal');

    const form =
        document.getElementById('securityPaymentForm');


    currentSecurityRemainingAmount =
        parseFloat(remainingAmount);


    // Student
    document.getElementById('securityPaymentStudent')
        .textContent = studentName;


    // Required
    document.getElementById('securityPaymentRequired')
        .textContent =
        '₹' + Number(requiredAmount).toLocaleString('en-IN', {
            minimumFractionDigits: 2
        });


    // Paid
    document.getElementById('securityPaymentPaid')
        .textContent =
        '₹' + Number(paidAmount).toLocaleString('en-IN', {
            minimumFractionDigits: 2
        });


    // Remaining
    document.getElementById('securityPaymentRemaining')
        .textContent =
        '₹' + Number(remainingAmount).toLocaleString('en-IN', {
            minimumFractionDigits: 2
        });


    // Form action
    form.action =
        '/security-deposits/' + securityDepositId + '/payment';


    // Reset amount
    const amountInput =
        document.getElementById('security_payment_amount');

    amountInput.value = '';
    amountInput.max = remainingAmount;


    // Reset error
    const error =
        document.getElementById('securityPaymentAmountError');

    error.textContent = '';
    error.classList.add('hidden');


    // Reset button
    const button =
        document.getElementById('recordSecurityPaymentButton');

    button.disabled = false;
    button.classList.remove(
        'opacity-50',
        'cursor-not-allowed'
    );


    // Open
    modal.classList.remove('hidden');
    modal.classList.add('flex');
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

document.getElementById('security_payment_amount')
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


        if (amount > currentSecurityRemainingAmount) {

            error.textContent =
                'Payment cannot be greater than ₹' +
                Number(currentSecurityRemainingAmount)
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
| Close When Clicking Outside
|--------------------------------------------------------------------------
*/

document.getElementById('securityPaymentModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {
            closeSecurityPaymentModal();
        }

    });

</script>


@endsection