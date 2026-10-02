@extends('layouts.admin')

@section('content')

<div class="space-y-6 px-6 py-6">

    {{-- Back --}}
    <a href="{{ route('rooms.index', ['floor' => $room->floor]) }}"
       class="inline-flex items-center text-sm font-medium text-blue-600
              hover:text-blue-700 dark:text-blue-400">
        ← Back to {{ $room->floor == 0 ? 'Ground Floor' : 'Rooms' }}
    </a>


    {{-- Room Header --}}
    <div class="flex items-start justify-between">

        <div>
            <div class="flex items-center gap-3">

                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Room {{ $room->room_number }}
                </h1>

                @if($room->status === 'active')

                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs
                                 font-medium text-green-700
                                 dark:bg-green-500/10 dark:text-green-400">
                        Active
                    </span>

                @else

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs
                                 font-medium text-slate-500
                                 dark:bg-slate-700 dark:text-slate-400">
                        Inactive
                    </span>

                @endif

            </div>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                {{ $room->floor == 0 ? 'Ground Floor' : 'Floor '.$room->floor }}
                · {{ $room->room_type }}
            </p>
        </div>


        {{-- Edit --}}
        <a href="{{ route('rooms.edit', $room) }}"
           class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                  font-medium text-slate-600 transition hover:bg-slate-50
                  dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
            ✏️ Edit Room
        </a>

    </div>


    {{-- Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        {{-- Total Beds --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Total Beds
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-800 dark:text-white">
                {{ $room->beds->count() }}
            </p>

        </div>


        {{-- Available --}}
        <div class="rounded-xl border border-green-200 bg-green-50 p-5
                    dark:border-green-500/20 dark:bg-green-500/10">

            <p class="text-sm text-green-600 dark:text-green-400">
                Available Beds
            </p>

            <p class="mt-2 text-2xl font-bold text-green-700 dark:text-green-400">
                {{ $room->beds->where('status', 'available')->count() }}
            </p>

        </div>


        {{-- Occupied --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                    dark:border-slate-700 dark:bg-slate-800">

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Occupied Beds
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-800 dark:text-white">
                {{ $room->beds->where('status', 'occupied')->count() }}
            </p>

        </div>

    </div>


    {{-- Beds Section --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

        <div class="mb-6">

            <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                Room Beds
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Current availability and student assignment details
            </p>

        </div>


        {{-- Beds Grid --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3
                    xl:grid-cols-4 2xl:grid-cols-5">

            @foreach($room->beds as $bed)

                @php
                    $assignment = $bed->currentAssignment;
                    $student = $assignment?->student;
                @endphp


                {{-- Bed Card --}}
                <div class="rounded-xl border p-5
                    {{ $bed->status === 'available'
                        ? 'border-green-200 bg-green-50 dark:border-green-500/20 dark:bg-green-500/10'
                        : 'border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-700/40'
                    }}">

                    {{-- Bed Icon --}}
                    <div class="flex items-center justify-between">

                        <div class="flex h-14 w-14 items-center justify-center
                                    rounded-xl
                            {{ $bed->status === 'available'
                                ? 'bg-green-100 dark:bg-green-500/10'
                                : 'bg-slate-200 opacity-50 dark:bg-slate-600'
                            }}">

                            <span class="text-3xl">
                                🛏️
                            </span>

                        </div>


                        {{-- Status --}}
                        @if($bed->status === 'available')

                            <span class="rounded-full bg-green-100 px-2.5 py-1
                                         text-xs font-medium text-green-700
                                         dark:bg-green-500/10 dark:text-green-400">
                                Available
                            </span>

                        @elseif($bed->status === 'occupied')

                            <span class="rounded-full bg-red-100 px-2.5 py-1
                                         text-xs font-medium text-red-700
                                         dark:bg-red-500/10 dark:text-red-400">
                                Occupied
                            </span>

                        @else

                            <span class="rounded-full bg-slate-200 px-2.5 py-1
                                         text-xs font-medium text-slate-600
                                         dark:bg-slate-600 dark:text-slate-300">
                                Maintenance
                            </span>

                        @endif

                    </div>


                    {{-- Bed Name --}}
                    <h3 class="mt-4 font-bold text-slate-800 dark:text-white">
                        Bed {{ $bed->bed_number }}
                    </h3>


                    @if($bed->status === 'available')

                        <p class="mt-1 text-xs text-green-600 dark:text-green-400">
                            Ready for assignment
                        </p>

                         @if($room->status === 'active')
                                <button type="button"
                                        onclick="openAssignModal({{ $bed->id }}, '{{ $bed->bed_number }}')"
                                        class="mt-4 w-full rounded-lg bg-blue-600 px-4 py-2.5
                                            text-xs font-medium text-white hover:bg-blue-700">
                                    Assign Student
                                </button>
                            @else
                                <div class="mt-4 rounded-lg bg-slate-200 px-4 py-2.5
                                            text-center text-xs font-medium text-slate-500
                                            dark:bg-slate-700 dark:text-slate-400">
                                    Room Inactive
                                </div>
                            @endif


                    @elseif($bed->status === 'occupied')

                        @if($student)

                            <div class="mt-4 border-t border-slate-200 pt-4
                                        dark:border-slate-600">

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Student
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-800
                                          dark:text-white">
                                    {{ $student->full_name }}
                                </p>


                                <div class="mt-3 grid grid-cols-2 gap-3">

                                    <div>
                                        <p class="text-[11px] text-slate-500
                                                  dark:text-slate-400">
                                            Since
                                        </p>

                                        <p class="mt-1 text-xs font-medium
                                                  text-slate-700 dark:text-slate-200">
                                            {{ $assignment->start_date->format('d M Y') }}
                                        </p>
                                    </div>


                                    <div>
                                        <p class="text-[11px] text-slate-500
                                                  dark:text-slate-400">
                                            Until
                                        </p>

                                        <p class="mt-1 text-xs font-medium
                                                  text-slate-700 dark:text-slate-200">
                                            {{ $assignment->end_date
                                                ? $assignment->end_date->format('d M Y')
                                                : 'Currently' }}
                                        </p>
                                    </div>

                                </div>

                            </div>
                               {{-- Checkout Button --}}
                                <button type="button"
                            onclick="openCheckoutModal(
                                {{ $bed->id }},
                                '{{ $bed->bed_number }}',
                                '{{ $bed->currentAssignment->student->full_name }}'
                            )"
                            class="mt-4 w-full rounded-lg bg-red-600 px-4 py-2.5
                                text-xs font-medium text-white hover:bg-red-700">
                        Checkout Student
                          </button>

                        @else

                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                Student information unavailable.
                            </p>

                        @endif

                    @else

                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            Bed is currently unavailable.
                        </p>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

 </div>



 {{-- Assign Student Modal --}}
  <div id="assignStudentModal"
     class="fixed inset-0 z-50 hidden items-center justify-center
            bg-black/50 px-4">

     <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl
                dark:bg-slate-800">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Assign Student
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Assign a student to <span id="modalBedName"></span>
                </p>
            </div>

            <button type="button"
                    onclick="closeAssignModal()"
                    class="text-xl text-slate-400 hover:text-slate-600
                           dark:hover:text-white">
                ✕
            </button>

        </div>


        {{-- Form --}}
        <form id="assignStudentForm"
              method="POST"
              class="mt-6 space-y-4">

            @csrf


            {{-- Student --}}
            <div>

                <label class="mb-1 block text-sm font-medium
                              text-slate-700 dark:text-slate-300">
                    Student
                </label>

                <select name="student_id"
                        required
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-3 py-2.5 text-sm
                               text-slate-700 outline-none
                               focus:border-blue-500 focus:ring-2
                               focus:ring-blue-500/20
                               dark:border-slate-600 dark:bg-slate-700
                               dark:text-white">

                    <option value="">
                        Select Student
                    </option>

                    @foreach($students as $student)

                        <option value="{{ $student->id }}">
                            {{ $student->full_name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Start Date --}}
            <div>

                <label class="mb-1 block text-sm font-medium
                              text-slate-700 dark:text-slate-300">
                    Start Date
                </label>

                <input type="date"
                       name="start_date"
                       value="{{ date('Y-m-d') }}"
                       required
                       class="w-full rounded-lg border border-slate-300
                              bg-white px-3 py-2.5 text-sm
                              text-slate-700 outline-none
                              focus:border-blue-500 focus:ring-2
                              focus:ring-blue-500/20
                              dark:border-slate-600 dark:bg-slate-700
                              dark:text-white">

            </div>


            {{-- End Date --}}
            <div>

                <label class="mb-1 block text-sm font-medium
                              text-slate-700 dark:text-slate-300">
                    End Date
                    <span class="text-xs text-slate-400">
                        (Optional)
                    </span>
                </label>

                <input type="date"
                       name="end_date"
                       class="w-full rounded-lg border border-slate-300
                              bg-white px-3 py-2.5 text-sm
                              text-slate-700 outline-none
                              focus:border-blue-500 focus:ring-2
                              focus:ring-blue-500/20
                              dark:border-slate-600 dark:bg-slate-700
                              dark:text-white">

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-3 pt-3">

                <button type="button"
                        onclick="closeAssignModal()"
                        class="rounded-lg border border-slate-300
                               px-4 py-2.5 text-sm font-medium
                               text-slate-600 hover:bg-slate-50
                               dark:border-slate-600 dark:text-slate-300
                               dark:hover:bg-slate-700">
                    Cancel
                </button>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5
                               text-sm font-medium text-white
                               hover:bg-blue-700">
                    Assign Student
                </button>

            </div>

        </form>

    </div>
  </div>
    {{-- Checkout Student Modal --}}
  <div id="checkoutStudentModal"
     class="fixed inset-0 z-50 hidden items-center justify-center
            bg-black/50 px-4">

    <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl
                dark:bg-slate-800">

        <div class="flex items-start justify-between">

            <div>
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">
                    Checkout Student
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Remove the student from this bed.
                </p>
            </div>

            <button type="button"
                    onclick="closeCheckoutModal()"
                    class="text-xl text-slate-400 hover:text-slate-600
                           dark:hover:text-white">
                ✕
            </button>

        </div>


        {{-- Student Information --}}
        <div class="mt-5 rounded-lg bg-slate-50 p-4
                    dark:bg-slate-700">

            <p class="text-xs text-slate-500 dark:text-slate-400">
                Student
            </p>

            <p id="checkoutStudentName"
               class="mt-1 font-semibold text-slate-800 dark:text-white">
            </p>

            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                Bed
            </p>

            <p id="checkoutBedName"
               class="mt-1 font-semibold text-slate-800 dark:text-white">
            </p>

        </div>


        {{-- Form --}}
        <form id="checkoutStudentForm"
              method="POST"
              class="mt-5">

            @csrf


            {{-- Checkout Date --}}
            <div>

                <label class="mb-1 block text-sm font-medium
                              text-slate-700 dark:text-slate-300">
                    Checkout Date
                </label>

                <input type="date"
                       name="end_date"
                       value="{{ date('Y-m-d') }}"
                       required
                       class="w-full rounded-lg border border-slate-300
                              bg-white px-3 py-2.5 text-sm
                              text-slate-700 outline-none
                              focus:border-blue-500 focus:ring-2
                              focus:ring-blue-500/20
                              dark:border-slate-600 dark:bg-slate-700
                              dark:text-white">

            </div>


            {{-- Buttons --}}
            <div class="mt-6 flex justify-end gap-3">

                <button type="button"
                        onclick="closeCheckoutModal()"
                        class="rounded-lg border border-slate-300
                               px-4 py-2.5 text-sm font-medium
                               text-slate-600 hover:bg-slate-50
                               dark:border-slate-600 dark:text-slate-300
                               dark:hover:bg-slate-700">
                    Cancel
                </button>

                <button type="submit"
                        class="rounded-lg bg-red-600 px-5 py-2.5
                               text-sm font-medium text-white
                               hover:bg-red-700">
                    Confirm Checkout
                </button>

            </div>

        </form>

    </div>

  </div>





<script>
    function openAssignModal(bedId, bedNumber) {

        const modal = document.getElementById('assignStudentModal');
        const form = document.getElementById('assignStudentForm');
        const bedName = document.getElementById('modalBedName');

        bedName.textContent = 'Bed ' + bedNumber;

        form.action = `/beds/${bedId}/assign`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }


    function closeAssignModal() {

        const modal = document.getElementById('assignStudentModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }


    // Close when clicking outside modal
    document.getElementById('assignStudentModal').addEventListener('click', function(event) {

        if (event.target === this) {
            closeAssignModal();
        }

    });

</script>

<script>

function openCheckoutModal(bedId, bedNumber, studentName)
{
    const modal = document.getElementById('checkoutStudentModal');
    const form = document.getElementById('checkoutStudentForm');

    document.getElementById('checkoutStudentName').textContent = studentName;
    document.getElementById('checkoutBedName').textContent = 'Bed ' + bedNumber;

    form.action = '/beds/' + bedId + '/checkout';

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function closeCheckoutModal()
{
    const modal = document.getElementById('checkoutStudentModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

</script>
@endsection