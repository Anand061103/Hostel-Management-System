@extends('layouts.admin')

@section('content')

<div class="mx-auto max-w-3xl px-6 py-6">

    {{-- Header --}}
    <div class="mb-6">

        <a href="{{ route('rooms.index', ['floor' => $floor]) }}"
           class="text-sm font-medium text-blue-600 hover:text-blue-700">
            ← Back to Rooms
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-800 dark:text-white">
            Create Room
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Create a new room and automatically add beds.
        </p>

    </div>


    {{-- Form Card --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

        <form action="{{ route('rooms.store') }}" method="POST">

            @csrf


            {{-- Floor --}}
            <div class="mb-5">

                <label for="floor"
                       class="mb-2 block text-sm font-medium text-slate-700
                              dark:text-slate-200">
                    Floor <span class="text-red-500">*</span>
                </label>

                <select name="floor"
                        id="floor"
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm text-slate-700
                               outline-none focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               dark:border-slate-600 dark:bg-slate-700
                               dark:text-white">

                    @foreach($floors as $floorNumber => $floorName)

                        <option value="{{ $floorNumber }}"
                            {{ old('floor', $floor) == $floorNumber ? 'selected' : '' }}>

                            {{ $floorName }}

                        </option>

                    @endforeach

                </select>

                @error('floor')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Number of Beds --}}
            <div class="mb-5">

                <label for="bed_count"
                       class="mb-2 block text-sm font-medium text-slate-700
                              dark:text-slate-200">
                    Number of Beds <span class="text-red-500">*</span>
                </label>

                <select name="bed_count"
                        id="bed_count"
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm text-slate-700
                               outline-none focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               dark:border-slate-600 dark:bg-slate-700
                               dark:text-white">

                    @for($i = 1; $i <= 5; $i++)

                        <option value="{{ $i }}"
                            {{ old('bed_count', 2) == $i ? 'selected' : '' }}>

                            {{ $i }} {{ $i == 1 ? 'Bed' : 'Beds' }}

                        </option>

                    @endfor

                </select>

                @error('bed_count')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Room Type --}}
            <div class="mb-6">

                <label for="room_type"
                       class="mb-2 block text-sm font-medium text-slate-700
                              dark:text-slate-200">
                    Room Type <span class="text-red-500">*</span>
                </label>

                <select name="room_type"
                        id="room_type"
                        class="w-full rounded-lg border border-slate-300
                               bg-white px-4 py-3 text-sm text-slate-700
                               outline-none focus:border-blue-500
                               focus:ring-2 focus:ring-blue-100
                               dark:border-slate-600 dark:bg-slate-700
                               dark:text-white">

                    <option value="Single"
                        {{ old('room_type') === 'Single' ? 'selected' : '' }}>
                        Single Room
                    </option>

                    <option value="Double"
                        {{ old('room_type', 'Double') === 'Double' ? 'selected' : '' }}>
                        Double Room
                    </option>

                    <option value="Shared"
                        {{ old('room_type') === 'Shared' ? 'selected' : '' }}>
                        Shared Room
                    </option>

                </select>

                @error('room_type')
                    <p class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Information --}}
            <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4
                        dark:border-blue-500/30 dark:bg-blue-500/10">

                <p class="text-sm font-medium text-blue-700 dark:text-blue-300">
                    Room number and beds will be generated automatically.
                </p>

                <p class="mt-1 text-xs text-blue-600 dark:text-blue-400">
                    Ground Floor: G01, G02, G03...
                    <br>
                    First Floor: 101, 102, 103...
                    <br>
                    Second Floor: 201, 202, 203...
                    <br>
                    Beds will be named A, B, C, D and E.
                </p>

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('rooms.index', ['floor' => $floor]) }}"
                   class="rounded-lg border border-slate-300 px-5 py-3
                          text-sm font-medium text-slate-600
                          hover:bg-slate-50
                          dark:border-slate-600 dark:text-slate-300
                          dark:hover:bg-slate-700">
                    Cancel
                </a>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-3 text-sm
                               font-medium text-white transition
                               hover:bg-blue-700">
                    Create Room
                </button>

            </div>

        </form>

    </div>

</div>

@endsection