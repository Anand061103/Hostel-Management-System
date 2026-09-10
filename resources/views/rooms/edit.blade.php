@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
            Edit Room
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Update room information
        </p>
    </div>


    {{-- Form Card --}}
    <div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm
                dark:border-slate-700 dark:bg-slate-800">

        <form action="{{ route('rooms.update', $room) }}" method="POST">

            @csrf
            @method('PUT')


            {{-- Room Number --}}
            <div class="mb-5">
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Room Number
                </label>

                <input
                    type="text"
                    value="{{ $room->room_number }}"
                    disabled
                    class="w-full rounded-lg border border-slate-200 bg-slate-100 px-4 py-3
                           text-sm text-slate-500 outline-none
                           dark:border-slate-700 dark:bg-slate-700 dark:text-slate-400"
                >

                <p class="mt-1 text-xs text-slate-400">
                    Room number cannot be changed.
                </p>
            </div>


            {{-- Floor --}}
            <div class="mb-5">
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">
                    Floor
                </label>

                <input
                    type="text"
                    value="{{ $floors[$room->floor] ?? 'Floor '.$room->floor }}"
                    disabled
                    class="w-full rounded-lg border border-slate-200 bg-slate-100 px-4 py-3
                           text-sm text-slate-500 outline-none
                           dark:border-slate-700 dark:bg-slate-700 dark:text-slate-400"
                >

                <p class="mt-1 text-xs text-slate-400">
                    Floor cannot be changed after room creation.
                </p>
            </div>


            {{-- Room Type --}}
            <div class="mb-5">
                <label
                    for="room_type"
                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200"
                >
                    Room Type
                </label>

                <input
                    type="text"
                    id="room_type"
                    name="room_type"
                    value="{{ old('room_type', $room->room_type) }}"
                    placeholder="e.g. AC, Non-AC, Deluxe"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                           text-sm text-slate-800 outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >

                @error('room_type')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Status --}}
            <div class="mb-6">
                <label
                    for="status"
                    class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200"
                >
                    Room Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3
                           text-sm text-slate-800 outline-none
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           dark:border-slate-600 dark:bg-slate-900 dark:text-white"
                >
                    <option value="active"
                        {{ old('status', $room->status) === 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ old('status', $room->status) === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>

                @error('status')
                    <p class="mt-1 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3">

                <a
                    href="{{ route('rooms.show', $room) }}"
                    class="rounded-lg border border-slate-300 px-5 py-3 text-sm font-medium
                           text-slate-700 transition hover:bg-slate-50
                           dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-700"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium
                           text-white transition hover:bg-blue-700"
                >
                    Update Room
                </button>

            </div>

        </form>

    </div>

</div>

@endsection