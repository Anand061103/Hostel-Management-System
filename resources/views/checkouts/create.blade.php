@extends('layouts.admin')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div class="mb-6">

            <a href="{{ route('students.index') }}" class="text-sm text-blue-600 hover:underline">
                ← Back to Students
            </a>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mt-2">
                Student Checkout
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Complete the student's final settlement before checkout.
            </p>

        </div>


        {{-- Validation / Error Message --}}
        @if ($errors->any())
            <div
                class="mb-6 rounded-lg bg-red-100 border border-red-300
                    text-red-700 px-4 py-3 dark:bg-red-900/30 dark:text-red-300">

                <ul class="list-disc ml-5">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif


        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-lg bg-green-100 border border-green-300
                    text-green-700 px-4 py-3
                    dark:bg-green-900/30 dark:text-green-300">

                {{ session('success') }}

            </div>
        @endif


        {{-- Student Information --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Student Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Student Name
                    </p>

                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $student->full_name }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Mobile Number
                    </p>

                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $student->mobile_number ?? 'N/A' }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Joining Date
                    </p>

                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $student->joining_date?->format('d M Y') ?? 'N/A' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Room & Bed Information --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Room & Bed Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Room
                    </p>

                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $assignment->bed->room->room_number }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Bed
                    </p>

                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $assignment->bed->bed_number }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Assigned Since
                    </p>

                    <p class="font-semibold text-gray-800 dark:text-white">
                        {{ $assignment->start_date?->format('d M Y') ?? 'N/A' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Fee Summary --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                Fee Summary
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Fees
                    </p>

                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        ₹{{ number_format($totalFees, 2) }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Paid
                    </p>

                    <p class="text-lg font-bold text-green-600">
                        ₹{{ number_format($totalPaidFees, 2) }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Outstanding
                    </p>

                    <p
                        class="text-lg font-bold
                        {{ $feeOutstanding > 10 ? 'text-red-600' : 'text-green-600' }}">

                        ₹{{ number_format($feeOutstanding, 2) }}

                    </p>

                </div>

            </div>


            {{-- Outstanding Fee --}}
            @if ($feeOutstanding > 10)
                {{-- Warning --}}
                <div
                    class="mt-5 p-4 rounded-lg bg-red-50 border border-red-200
                    text-red-700 dark:bg-red-900/20
                    dark:border-red-800 dark:text-red-300">

                    <p class="font-semibold">
                        Checkout is blocked.
                    </p>

                    <p class="text-sm mt-1">
                        Please clear the outstanding fee of
                        ₹{{ number_format($feeOutstanding, 2) }}
                        before checking out this student.
                    </p>

                </div>


                {{-- Pay Outstanding Fee --}}
                <div
                    class="mt-6 p-5 rounded-lg border border-blue-200
                    bg-blue-50 dark:bg-blue-900/20
                    dark:border-blue-800">

                    <h3 class="text-md font-semibold text-gray-800 dark:text-white mb-4">
                        Pay Outstanding Fee
                    </h3>

                    <form action="{{ route('students.checkout.payFees', $student) }}" method="POST">

                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Payment Amount
                                </label>

                                <input type="number" name="amount"
                                    value="{{ old('amount', number_format($feeOutstanding, 2, '.', '')) }}" min="0.01"
                                    max="{{ $feeOutstanding }}" step="0.01" required
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Maximum: ₹{{ number_format($feeOutstanding, 2) }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Payment Date
                                </label>

                                <input type="date" name="payment_date"
                                    value="{{ old('payment_date', now()->format('Y-m-d')) }}" required
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Payment Method
                                </label>

                                <select name="payment_method" required
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select payment method</option>
                                    <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="upi" {{ old('payment_method') === 'upi' ? 'selected' : '' }}>UPI
                                    </option>
                                    <option value="bank_transfer"
                                        {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                    </option>
                                    <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Card
                                    </option>
                                    <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Reference Number
                                </label>

                                <input type="text" name="reference_no" value="{{ old('reference_no') }}"
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="UPI / transaction reference">
                            </div>

                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Notes
                            </label>

                            <textarea name="notes" rows="3"
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Optional payment notes...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                Pay ₹{{ number_format($feeOutstanding, 2) }}
                            </button>
                        </div>

                    </form>
                </div>
            @elseif ($feeOutstanding > 0)
                {{-- Within ₹10 Tolerance --}}
                <div
                    class="mt-5 p-4 rounded-lg bg-green-50 border border-green-200
                    text-green-700 dark:bg-green-900/20
                    dark:border-green-800 dark:text-green-300">

                    <p class="font-semibold">
                        ✓ Fee cleared within tolerance.
                    </p>

                    <p class="text-sm mt-1">
                        Remaining amount of ₹{{ number_format($feeOutstanding, 2) }}
                        is within the allowed ₹10 tolerance. Checkout can be completed.
                    </p>

                </div>
            @else
                {{-- Fully Paid --}}
                <div
                    class="mt-5 p-4 rounded-lg bg-green-50 border border-green-200
                    text-green-700 dark:bg-green-900/20
                    dark:border-green-800 dark:text-green-300">

                    ✓ All fees are fully paid.

                </div>
            @endif

        </div>


        {{-- Security Deposit --}}
        <form action="{{ route('students.checkout.store', $student) }}" method="POST">

            @csrf


            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                    Security Deposit Settlement
                </h2>


                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    {{-- Required --}}
                    <div>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Required
                        </p>

                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            ₹{{ number_format($securityRequired, 2) }}
                        </p>

                    </div>


                    {{-- Paid --}}
                    <div>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Paid
                        </p>

                        <p class="text-lg font-bold text-green-600">
                            ₹{{ number_format($securityPaid, 2) }}
                        </p>

                    </div>


                    {{-- Remaining --}}
                    <div>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Remaining
                        </p>

                        <p
                            class="text-lg font-bold
                            {{ $securityRemaining > 0 ? 'text-red-600' : 'text-green-600' }}">

                            ₹{{ number_format($securityRemaining, 2) }}

                        </p>

                    </div>

                </div>


                {{-- Partial Security Warning --}}
                @if ($securityRemaining > 0)
                    <div
                        class="mt-5 p-4 rounded-lg bg-yellow-50
                        border border-yellow-200 text-yellow-700
                        dark:bg-yellow-900/20
                        dark:border-yellow-800
                        dark:text-yellow-300">

                        <p class="font-semibold">
                            Security Deposit Partially Paid
                        </p>

                        <p class="text-sm mt-1">
                            ₹{{ number_format($securityRemaining, 2) }}
                            security deposit is still outstanding.
                            Checkout can still be completed.
                        </p>

                    </div>
                @endif


                {{-- Damage / Deduction --}}
                <div class="mt-6">

                    <label class="block text-sm font-medium
                        text-gray-700 dark:text-gray-300 mb-2">

                        Damage / Deduction Amount

                    </label>

                    <input type="number" id="securityDeduction" name="security_deduction"
                        value="{{ old('security_deduction', 0) }}" min="0" max="{{ $securityPaid }}"
                        step="0.01"
                        class="w-full rounded-lg border-gray-300
                        dark:bg-gray-700 dark:border-gray-600
                        dark:text-white">

                    <p class="text-xs text-gray-500 mt-1">

                        Maximum deduction:
                        ₹{{ number_format($securityPaid, 2) }}

                    </p>

                </div>


                {{-- Deduction Reason --}}
                <div class="mt-5">

                    <label class="block text-sm font-medium
                        text-gray-700 dark:text-gray-300 mb-2">

                        Deduction Reason

                    </label>

                    <textarea name="security_settlement_reason" rows="3"
                        class="w-full rounded-lg border-gray-300
                        dark:bg-gray-700 dark:border-gray-600
                        dark:text-white"
                        placeholder="Example: Broken fan, damaged chair, lost key...">{{ old('security_settlement_reason') }}</textarea>

                </div>


                {{-- Refund Method --}}
                <div class="mt-5">

                    <label class="block text-sm font-medium
                        text-gray-700 dark:text-gray-300 mb-2">

                        Refund Method

                    </label>

                    <select name="refund_method"
                        class="w-full rounded-lg border-gray-300
                        dark:bg-gray-700 dark:border-gray-600
                        dark:text-white">

                        <option value="">
                            Select refund method
                        </option>

                        <option value="cash" {{ old('refund_method') === 'cash' ? 'selected' : '' }}>
                            Cash
                        </option>

                        <option value="upi" {{ old('refund_method') === 'upi' ? 'selected' : '' }}>
                            UPI
                        </option>

                        <option value="bank_transfer" {{ old('refund_method') === 'bank_transfer' ? 'selected' : '' }}>
                            Bank Transfer
                        </option>

                    </select>

                </div>


                {{-- Refund Amount --}}
                <div
                    class="mt-5 p-4 rounded-lg bg-green-50
                    border border-green-200
                    dark:bg-green-900/20
                    dark:border-green-800">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Security Refund
                            </p>

                            <p id="refundAmount" class="text-2xl font-bold text-green-600">

                                ₹{{ number_format($securityPaid, 2) }}

                            </p>

                        </div>


                        <div class="text-right">

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Security Paid
                            </p>

                            <p class="font-semibold text-gray-800 dark:text-white">
                                ₹{{ number_format($securityPaid, 2) }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Refund Reference --}}
                <div class="mt-5">

                    <label class="block text-sm font-medium
                        text-gray-700 dark:text-gray-300 mb-2">

                        Refund Reference

                    </label>

                    <input type="text" name="refund_reference" value="{{ old('refund_reference') }}"
                        class="w-full rounded-lg border-gray-300
                        dark:bg-gray-700 dark:border-gray-600
                        dark:text-white"
                        placeholder="UPI / transaction reference (if applicable)">

                </div>

            </div>


            {{-- Checkout Details --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                    Checkout Details
                </h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Checkout Date --}}
                    <div>

                        <label
                            class="block text-sm font-medium
                            text-gray-700 dark:text-gray-300 mb-2">

                            Checkout Date

                        </label>

                        <input type="date" name="checkout_date"
                            value="{{ old('checkout_date', now()->format('Y-m-d')) }}" required
                            class="w-full rounded-lg border-gray-300
                            dark:bg-gray-700 dark:border-gray-600
                            dark:text-white">

                    </div>


                    {{-- Checkout Reason --}}
                    <div>

                        <label
                            class="block text-sm font-medium
                            text-gray-700 dark:text-gray-300 mb-2">

                            Checkout Reason

                        </label>

                        <select name="reason"
                            class="w-full rounded-lg border-gray-300
                            dark:bg-gray-700 dark:border-gray-600
                            dark:text-white">

                            <option value="">
                                Select reason
                            </option>

                            <option value="Course Completed" {{ old('reason') === 'Course Completed' ? 'selected' : '' }}>
                                Course Completed
                            </option>

                            <option value="Personal Reason" {{ old('reason') === 'Personal Reason' ? 'selected' : '' }}>
                                Personal Reason
                            </option>

                            <option value="Transfer" {{ old('reason') === 'Transfer' ? 'selected' : '' }}>
                                Transfer
                            </option>

                            <option value="Hostel Change" {{ old('reason') === 'Hostel Change' ? 'selected' : '' }}>
                                Hostel Change
                            </option>

                            <option value="Disciplinary" {{ old('reason') === 'Disciplinary' ? 'selected' : '' }}>
                                Disciplinary
                            </option>

                            <option value="Other" {{ old('reason') === 'Other' ? 'selected' : '' }}>
                                Other
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Notes --}}
                <div class="mt-5">

                    <label class="block text-sm font-medium
                        text-gray-700 dark:text-gray-300 mb-2">

                        Notes

                    </label>

                    <textarea name="notes" rows="4"
                        class="w-full rounded-lg border-gray-300
                        dark:bg-gray-700 dark:border-gray-600
                        dark:text-white"
                        placeholder="Any additional checkout notes...">{{ old('notes') }}</textarea>

                </div>

            </div>


            {{-- Final Action --}}
            <div class="flex items-center justify-end gap-3">

                <a href="{{ route('students.index') }}"
                    class="px-5 py-2.5 rounded-lg border
                    border-gray-300 dark:border-gray-600
                    text-gray-700 dark:text-gray-300
                    hover:bg-gray-100 dark:hover:bg-gray-700">

                    Cancel

                </a>


                @if ($canCheckout)
                    <button type="submit"
                        onclick="return confirm('Are you sure you want to complete this student checkout?')"
                        class="px-5 py-2.5 rounded-lg
                        bg-red-600 text-white hover:bg-red-700">

                        Confirm Checkout

                    </button>
                @else
                    <button type="button" disabled
                        class="px-5 py-2.5 rounded-lg
                        bg-gray-400 text-white
                        cursor-not-allowed">

                        Checkout Blocked

                    </button>
                @endif

            </div>

        </form>

    </div>


    {{-- Refund Calculation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const deductionInput =
                document.getElementById('securityDeduction');

            const refundAmount =
                document.getElementById('refundAmount');

            if (!deductionInput || !refundAmount) {
                return;
            }

            const securityPaid =
                {{ (float) $securityPaid }};


            function updateRefund() {

                let deduction =
                    parseFloat(deductionInput.value) || 0;


                if (deduction < 0) {
                    deduction = 0;
                }


                if (deduction > securityPaid) {

                    deduction = securityPaid;

                    deductionInput.value =
                        securityPaid.toFixed(2);
                }


                const refund =
                    securityPaid - deduction;


                refundAmount.textContent =
                    '₹' + refund.toLocaleString('en-IN', {

                        minimumFractionDigits: 2,

                        maximumFractionDigits: 2

                    });

            }


            deductionInput.addEventListener(
                'input',
                updateRefund
            );


            updateRefund();

        });
    </script>

@endsection
