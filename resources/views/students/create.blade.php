@extends('layouts.admin')

@section('title', 'Add Student')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">

        <a href="{{ route('students.index') }}"
           class="text-sm text-blue-600 hover:text-blue-700">
            ← Back to Students
        </a>

        <h1 class="mt-3 text-2xl font-bold text-slate-800 dark:text-white">
            Add Student
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Add a new student to the hostel
        </p>

    </div>


    {{-- Form --}}
    <form action="{{ route('students.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

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
                        value="{{ old('full_name') }}"
                        placeholder="Enter full name"
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
                        value="{{ old('father_name') }}"
                        placeholder="Enter father's name"
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
                        value="{{ old('email') }}"
                        placeholder="student@example.com"
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
                        value="{{ old('aadhar_number') }}"
                        maxlength="12"
                        placeholder="12 digit Aadhaar number"
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
                        value="{{ old('mobile_number') }}"
                        placeholder="Enter mobile number"
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
                        value="{{ old('joining_date') }}"
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
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
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
                        placeholder="Enter complete address"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                    >{{ old('address') }}</textarea>

                    @error('address')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Image --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Student Photo
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
             {{-- ===================================================== --}}
{{-- FEE & PAYMENT SECTION --}}
{{-- ===================================================== --}}

<div class="mt-8 border-t border-slate-200 pt-8 dark:border-slate-800">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white">
            💰 Fee & Initial Payment
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Set the student's monthly fee and record the initial payment.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Monthly Fee --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Monthly Fee <span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <span class="absolute left-4 top-1/2 -translate-y-1/2
                             text-sm font-medium text-slate-500">
                    ₹
                </span>

                <input
                    type="number"
                    name="monthly_fee"
                    value="{{ old('monthly_fee') }}"
                    min="0.01"
                    step="0.01"
                    required
                    placeholder="3000"
                    class="w-full rounded-lg border border-slate-300 bg-white
                           py-2.5 pl-9 pr-4 text-sm outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                >

            </div>

            @error('monthly_fee')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
         </div>


         {{-- Initial Payment --}}
         <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Initial Payment
                <span class="text-xs font-normal text-slate-400">
                    (Optional)
                </span>
            </label>

            <div class="relative">

                <span class="absolute left-4 top-1/2 -translate-y-1/2
                             text-sm font-medium text-slate-500">
                    ₹
                </span>

                <input
                    type="number"
                    name="initial_payment"
                    value="{{ old('initial_payment', 0) }}"
                    min="0"
                    step="0.01"
                    placeholder="3000"
                    class="w-full rounded-lg border border-slate-300 bg-white
                           py-2.5 pl-9 pr-4 text-sm outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                >

            </div>

            @error('initial_payment')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <p class="mt-1 text-xs text-slate-400">
                You can record full or partial payment.
            </p>
         </div>


         {{-- Payment Date --}}
         <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Payment Date
            </label>

            <input
                type="date"
                name="payment_date"
                value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                class="w-full rounded-lg border border-slate-300 bg-white
                       px-4 py-2.5 text-sm outline-none
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800 dark:text-white"
            >

            @error('payment_date')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
             @enderror
         </div>


         {{-- Payment Method --}}
         <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Payment Method
            </label>

            <select
                name="payment_method"
                class="w-full rounded-lg border border-slate-300 bg-white
                       px-4 py-2.5 text-sm outline-none
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800 dark:text-white"
            >
                <option value="cash"
                    {{ old('payment_method', 'cash') === 'cash' ? 'selected' : '' }}>
                    Cash
                </option>

                <option value="upi"
                    {{ old('payment_method') === 'upi' ? 'selected' : '' }}>
                    UPI
                </option>

                <option value="bank_transfer"
                    {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>
                    Bank Transfer
                </option>

                <option value="card"
                    {{ old('payment_method') === 'card' ? 'selected' : '' }}>
                    Card
                </option>

                <option value="other"
                    {{ old('payment_method') === 'other' ? 'selected' : '' }}>
                    Other
                </option>
            </select>

            @error('payment_method')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror


            {{-- Fee Due Date --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Fee Due Date <span class="text-red-500">*</span>
                </label>

                <input
                    type="date"
                    name="fee_due_date"
                    value="{{ old('fee_due_date', now()->format('Y-m-d')) }}"
                    required
                    class="w-full rounded-lg border border-slate-300 bg-white
                        px-4 py-2.5 text-sm outline-none
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                        dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                >

                @error('fee_due_date')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- SECURITY DEPOSIT SECTION --}}
{{-- ===================================================== --}}

<div class="mt-8 border-t border-slate-200 pt-8 dark:border-slate-800">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white">
            🔐 Security Deposit
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Record the security deposit collected from the student.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Required Security --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Required Security Deposit <span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <span class="absolute left-4 top-1/2 -translate-y-1/2
                             text-sm font-medium text-slate-500">
                    ₹
                </span>

                <input
                    type="number"
                    name="security_required"
                    value="{{ old('security_required') }}"
                    min="0"
                    step="0.01"
                    required
                    placeholder="10000"
                    class="w-full rounded-lg border border-slate-300 bg-white
                           py-2.5 pl-9 pr-4 text-sm outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                >

            </div>

            @error('security_required')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        {{-- Security Paid --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Security Paid Now
            </label>

            <div class="relative">

                <span class="absolute left-4 top-1/2 -translate-y-1/2
                             text-sm font-medium text-slate-500">
                    ₹
                </span>

                <input
                    type="number"
                    name="security_paid"
                    value="{{ old('security_paid', 0) }}"
                    min="0"
                    step="0.01"
                    placeholder="10000"
                    class="w-full rounded-lg border border-slate-300 bg-white
                           py-2.5 pl-9 pr-4 text-sm outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                >

            </div>

            @error('security_paid')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <p class="mt-1 text-xs text-slate-400">
                Full or partial security payment can be recorded.
            </p>
        </div>


        {{-- Security Received Date --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Security Received Date
            </label>

            <input
                type="date"
                name="security_received_date"
                value="{{ old('security_received_date', now()->format('Y-m-d')) }}"
                class="w-full rounded-lg border border-slate-300 bg-white
                       px-4 py-2.5 text-sm outline-none
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800 dark:text-white"
            >

            @error('security_received_date')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

    </div>

</div>



{{-- ===================================================== --}}
{{-- ROOM & BED ASSIGNMENT SECTION --}}
{{-- ===================================================== --}}

<div class="mt-8 border-t border-slate-200 pt-8 dark:border-slate-800">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white">
            🛏️ Room & Bed Assignment
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Assign an available bed to the student during admission.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        {{-- Floor --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Floor <span class="text-red-500">*</span>
            </label>

            <select
                id="floor"
                name="floor"
                required
                class="w-full rounded-lg border border-slate-300 bg-white
                       px-4 py-2.5 text-sm outline-none
                       focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                       dark:border-slate-700 dark:bg-slate-800 dark:text-white"
            >
                <option value="">Select Floor</option>

                @foreach($floors as $floorNumber => $floorName)
                    <option
                        value="{{ $floorNumber }}"
                        {{ old('floor') == $floorNumber ? 'selected' : '' }}
                    >
                        {{ $floorName }}
                    </option>
                @endforeach
            </select>

            @error('floor')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        {{-- Room --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Room <span class="text-red-500">*</span>
            </label>

            <select
                id="room_id"
                name="room_id"
                required
                disabled
                class="w-full rounded-lg border border-slate-300 bg-slate-100
                       px-4 py-2.5 text-sm outline-none
                       dark:border-slate-700 dark:bg-slate-700 dark:text-slate-300"
            >
                <option value="">Select Room</option>
            </select>

            @error('room_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>


        {{-- Bed --}}
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Available Bed <span class="text-red-500">*</span>
            </label>

            <select
                id="bed_id"
                name="bed_id"
                required
                disabled
                class="w-full rounded-lg border border-slate-300 bg-slate-100
                       px-4 py-2.5 text-sm outline-none
                       dark:border-slate-700 dark:bg-slate-700 dark:text-slate-300"
            >
                <option value="">Select Bed</option>
            </select>

            @error('bed_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

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
                    Save Student
                </button>

            </div>

        </div>

    </form>

</div>

  
<script>
    const rooms = @json($rooms);

    const floorSelect = document.getElementById('floor');
    const roomSelect = document.getElementById('room_id');
    const bedSelect = document.getElementById('bed_id');

    floorSelect.addEventListener('change', function () {

        const selectedFloor = this.value;

        roomSelect.innerHTML = '<option value="">Select Room</option>';
        bedSelect.innerHTML = '<option value="">Select Bed</option>';

        roomSelect.disabled = true;
        bedSelect.disabled = true;

        if (selectedFloor === '') {
            return;
        }

        const filteredRooms = rooms.filter(room =>
            room.floor == selectedFloor &&
            room.beds.length > 0
        );

        filteredRooms.forEach(room => {

            const option = document.createElement('option');

            option.value = room.id;
            option.textContent =
                'Room ' + room.room_number +
                ' (' + room.beds.length + ' available)';

            roomSelect.appendChild(option);
        });

        if (filteredRooms.length > 0) {
            roomSelect.disabled = false;
        }
    });


    roomSelect.addEventListener('change', function () {

        const roomId = this.value;

        bedSelect.innerHTML = '<option value="">Select Bed</option>';
        bedSelect.disabled = true;

        if (roomId === '') {
            return;
        }

        const room = rooms.find(room => room.id == roomId);

        if (!room) {
            return;
        }

        room.beds.forEach(bed => {

            const option = document.createElement('option');

            option.value = bed.id;
            option.textContent = 'Bed ' + bed.bed_number;

            bedSelect.appendChild(option);
        });

        if (room.beds.length > 0) {
            bedSelect.disabled = false;
        }
    });
</script>


@endsection