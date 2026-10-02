@extends('layouts.admin')

@section('content')

<div class="px-6 py-6 space-y-6">

    {{-- Page Header --}}
    <div class="flex items-start justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Rooms
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Manage hostel rooms and bed availability
            </p>
        </div>

        <a href="{{ route('rooms.create', ['floor' => $floor]) }}"
           class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium
                  text-white transition hover:bg-blue-700">
            + Add Room
        </a>

    </div>


    {{-- Floor Navigation --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">

        @foreach($floors as $floorNumber => $floorName)

            <a href="{{ route('rooms.index', ['floor' => $floorNumber]) }}"
               class="rounded-xl border px-4 py-4 text-center transition
               {{ $floor == $floorNumber
                    ? 'border-blue-500 bg-blue-600 text-white shadow-md'
                    : 'border-slate-200 bg-white text-slate-700 hover:border-blue-400 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700'
               }}">

                <p class="text-sm font-semibold">
                    {{ $floorName }}
                </p>

                <p class="mt-1 text-xs opacity-80">
                    Floor {{ $floorNumber }}
                </p>

            </a>

        @endforeach

    </div>


    {{-- Current Floor Heading --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                🏢 {{ $currentFloorName }}
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Total Rooms: {{ $rooms->count() }}
            </p>
        </div>

    </div>


    {{-- Rooms Grid --}}
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">

        @forelse($rooms as $room)

            {{-- Room Card --}}
            <a href="{{ route('rooms.show', $room) }}"
               class="group block rounded-xl border border-slate-200 bg-white p-5 shadow-sm
                      transition hover:-translate-y-1 hover:shadow-md
                      dark:border-slate-700 dark:bg-slate-800
                      dark:hover:border-blue-500 dark:hover:shadow-none">


                {{-- Room Header --}}
                <div class="flex items-start justify-between">

                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                            Room {{ $room->room_number }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ $currentFloorName }}
                        </p>
                    </div>


                    {{-- Room Status --}}
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


                {{-- Beds --}}
                <div class="mt-6 flex flex-wrap justify-center gap-4">

                    @foreach($room->beds as $bed)

                        <div class="group/bed relative flex flex-col items-center">


                            {{-- Available Bed --}}
                            @if($bed->status === 'available')

                                <div class="flex h-16 w-16 items-center justify-center
                                            rounded-xl bg-green-100 text-4xl
                                            dark:bg-green-500/10">

                                    🛏️

                                </div>

                                <span class="mt-2 text-xs font-semibold text-green-600
                                             dark:text-green-400">
                                    Bed {{ $bed->bed_number }}
                                </span>

                                <span class="mt-0.5 text-[11px] text-green-500">
                                    Available
                                </span>


                            {{-- Occupied / Other --}}
                            @else

                                <div class="flex h-16 w-16 items-center justify-center
                                            rounded-xl bg-slate-100 text-4xl opacity-40
                                            dark:bg-slate-700">

                                    🛏️

                                </div>

                                <span class="mt-2 text-xs font-semibold text-slate-400">
                                    Bed {{ $bed->bed_number }}
                                </span>

                                <span class="mt-0.5 text-[11px] text-slate-400">
                                    Occupied
                                </span>

                            @endif


                            {{-- Bed Hover Tooltip --}}
                            <div class="pointer-events-none absolute bottom-full left-1/2 z-50 mb-3
                                        hidden w-52 -translate-x-1/2 rounded-lg
                                        bg-slate-900 p-3 text-left text-xs text-white
                                        shadow-xl group-hover/bed:block">


                                {{-- Bed Name --}}
                                <p class="text-sm font-semibold">
                                    Bed {{ $bed->bed_number }}
                                </p>


                                {{-- Available --}}
                                @if($bed->status === 'available')

                                    <p class="mt-1 text-green-400">
                                        ● Available
                                    </p>

                                    <p class="mt-1 text-slate-400">
                                        No student assigned
                                    </p>


                                {{-- Occupied --}}
                                @else

                                    <p class="mt-1 text-red-400">
                                        ● Occupied
                                    </p>


                                    @if($bed->currentAssignment && $bed->currentAssignment->student)

                                        <div class="mt-2 border-t border-slate-700 pt-2">

                                            <p class="text-slate-400">
                                                Student
                                            </p>

                                            <p class="font-medium text-white">
                                                {{ $bed->currentAssignment->student->full_name }}
                                            </p>


                                            <p class="mt-2 text-slate-400">
                                                Since
                                            </p>

                                            <p>
                                                {{ $bed->currentAssignment->start_date->format('d M Y') }}
                                            </p>


                                            @if($bed->currentAssignment->end_date)

                                                <p class="mt-2 text-slate-400">
                                                    Until
                                                </p>

                                                <p>
                                                    {{ $bed->currentAssignment->end_date->format('d M Y') }}
                                                </p>

                                            @else

                                                <p class="mt-2 text-slate-400">
                                                    Until
                                                </p>

                                                <p>
                                                    Currently
                                                </p>

                                            @endif

                                        </div>

                                    @else

                                        <p class="mt-2 text-slate-400">
                                            Student information unavailable.
                                        </p>

                                    @endif

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- Card Footer --}}
                <div class="mt-6 border-t border-slate-100 pt-4
                            dark:border-slate-700">

                    <div class="flex items-center justify-between">

                        <span class="text-xs text-slate-500 dark:text-slate-400">

                            {{ $room->beds->where('status', 'available')->count() }}
                            /
                            {{ $room->beds->count() }}
                            Available

                        </span>

                        <span class="text-xs text-slate-500 dark:text-slate-400">

                            {{ $room->beds->count() }} Beds

                        </span>

                    </div>

                </div>

            </a>

        @empty

            {{-- No Rooms --}}
            <div class="col-span-full rounded-xl border border-dashed
                        border-slate-300 bg-white py-16 text-center
                        dark:border-slate-700 dark:bg-slate-800">

                <div class="text-5xl">
                    🏢
                </div>

                <h3 class="mt-4 text-lg font-semibold text-slate-700
                           dark:text-slate-200">
                    No Rooms Found
                </h3>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    No rooms have been added to this floor yet.
                </p>

                <a href="{{ route('rooms.create', ['floor' => $floor]) }}"
                   class="mt-5 inline-block rounded-lg bg-blue-600 px-5 py-3
                          text-sm font-medium text-white hover:bg-blue-700">
                    + Add Room
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection