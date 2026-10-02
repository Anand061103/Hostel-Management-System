@extends('layouts.admin')

@section('title', 'Edit Bed')

@section('content')

    <div class="p-6">

        {{-- Header --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Edit Bed
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Update bed information
            </p>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div
                class="mb-6 rounded-lg border border-red-200
                    bg-red-50 px-4 py-4
                    dark:border-red-900
                    dark:bg-red-900/20">

                <ul class="list-disc space-y-1 pl-5 text-sm
                       text-red-600 dark:text-red-400">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Form Card --}}
        <div
            class="mx-auto max-w-3xl rounded-xl border
                border-slate-200 bg-white shadow-sm
                dark:border-slate-700 dark:bg-slate-800">


            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5
                    dark:border-slate-700">

                <h2 class="text-lg font-bold text-slate-800
                       dark:text-white">

                    Bed Information

                </h2>

                <p class="mt-1 text-sm text-slate-500
                      dark:text-slate-400">

                    Update the room, bed number and status.

                </p>

            </div>


            {{-- Form --}}
            <form action="{{ route('beds.update', $bed) }}" method="POST">

                @csrf
                @method('PUT')


                <div class="space-y-6 px-6 py-6">


                    {{-- Room --}}
                    <div>

                        <label for="room_id"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">

                            Room
                            <span class="text-red-500">*</span>

                        </label>


                        <select id="room_id" name="room_id" required
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white">

                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{ old('room_id', $bed->room_id) == $room->id ? 'selected' : '' }}>

                                    Room {{ $room->room_number }}
                                    — Floor {{ $room->floor }}

                                </option>
                            @endforeach

                        </select>


                        @error('room_id')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Bed Number --}}
                    <div>

                        <label for="bed_number"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">

                            Bed Number
                            <span class="text-red-500">*</span>

                        </label>


                        <input type="text" id="bed_number" name="bed_number"
                            value="{{ old('bed_number', $bed->bed_number) }}" maxlength="50" required
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white
                               dark:placeholder-slate-500">


                        @error('bed_number')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div>

                        <label for="status"
                            class="mb-2 block text-sm font-medium
                               text-slate-700 dark:text-slate-300">

                            Status
                            <span class="text-red-500">*</span>

                        </label>


                        <select id="status" name="status" required
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white">

                            <option value="available" {{ old('status', $bed->status) === 'available' ? 'selected' : '' }}>
                                Available
                            </option>

                            <option value="occupied" {{ old('status', $bed->status) === 'occupied' ? 'selected' : '' }}>
                                Occupied
                            </option>

                            <option value="maintenance"
                                {{ old('status', $bed->status) === 'maintenance' ? 'selected' : '' }}>
                                Maintenance
                            </option>

                        </select>


                        @error('status')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Buttons --}}
                    <div class="flex flex-col-reverse gap-3 pt-2
                            sm:flex-row sm:justify-end">

                        <a href="{{ route('beds.show', $bed) }}"
                            class="inline-flex items-center justify-center
                               rounded-lg border border-slate-300
                               px-5 py-2.5 text-sm font-medium
                               text-slate-700
                               hover:bg-slate-50
                               dark:border-slate-600
                               dark:text-slate-300
                               dark:hover:bg-slate-700">

                            Cancel

                        </a>


                        <button type="submit"
                            class="inline-flex items-center justify-center
                               rounded-lg bg-blue-600 px-5 py-2.5
                               text-sm font-semibold text-white
                               hover:bg-blue-700">

                            Update Bed

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
