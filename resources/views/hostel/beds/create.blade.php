@extends('layouts.admin')

@section('title', 'Add Bed')

@section('content')

    <div class="p-6">

        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                Add Bed
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Add a new bed to a hostel room
            </p>

        </div>



        {{-- ===================================================== --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ===================================================== --}}

        @if ($errors->any())

            <div
                class="mb-6 rounded-lg border border-red-200
                    bg-red-50 px-4 py-4
                    dark:border-red-900
                    dark:bg-red-900/20">

                <p class="mb-2 text-sm font-semibold text-red-700
                      dark:text-red-400">

                    Please fix the following errors:

                </p>

                <ul class="list-disc space-y-1 pl-5 text-sm
                       text-red-600 dark:text-red-400">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

            </div>

        @endif



        {{-- ===================================================== --}}
        {{-- FORM CARD --}}
        {{-- ===================================================== --}}

        <div
            class="mx-auto max-w-3xl rounded-xl border border-slate-200
             bg-white shadow-sm
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

                    Select a room and assign a unique bed number.

                </p>

            </div>



            {{-- ================================================= --}}
            {{-- FORM --}}
            {{-- ================================================= --}}

            <form action="{{ route('beds.store') }}" method="POST">

                @csrf


                <div class="space-y-6 px-6 py-6">


                    {{-- ================================================= --}}
                    {{-- ROOM --}}
                    {{-- ================================================= --}}

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

                            <option value="">
                                Select Room
                            </option>


                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>

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



                    {{-- ================================================= --}}
                    {{-- BED NUMBER --}}
                    {{-- ================================================= --}}

                    <div>

                        <label for="bed_number"
                            class="mb-2 block text-sm font-medium
                                  text-slate-700 dark:text-slate-300">

                            Bed Number
                            <span class="text-red-500">*</span>

                        </label>


                        <input type="text" id="bed_number" name="bed_number" value="{{ old('bed_number') }}"
                            placeholder="Example: A" maxlength="50" required
                            class="w-full rounded-lg border
                               border-slate-300 bg-white px-4 py-3
                               text-sm text-slate-800 outline-none
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-500/20
                               dark:border-slate-600
                               dark:bg-slate-900
                               dark:text-white
                               dark:placeholder-slate-500">


                        <p class="mt-1 text-xs text-slate-500
                              dark:text-slate-400">

                            Use a unique number or label such as
                            <span class="font-medium">A</span>,
                            <span class="font-medium">B</span> or
                            <span class="font-medium">1</span>,
                            <span class="font-medium">2</span>.

                        </p>


                        @error('bed_number')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- ================================================= --}}
                    {{-- DEFAULT STATUS INFO --}}
                    {{-- ================================================= --}}

                    <div
                        class="rounded-lg border border-emerald-200
                            bg-emerald-50 px-4 py-3
                            dark:border-emerald-900
                            dark:bg-emerald-900/20">

                        <div class="flex items-start gap-3">

                            <div class="mt-0.5 text-emerald-600
                                    dark:text-emerald-400">

                                ✓

                            </div>

                            <div>

                                <p
                                    class="text-sm font-semibold
                                      text-emerald-700
                                      dark:text-emerald-400">

                                    Bed will be Available

                                </p>

                                <p
                                    class="mt-1 text-xs
                                      text-emerald-600
                                      dark:text-emerald-500">

                                    A newly created bed will automatically
                                    be marked as available.

                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- BUTTONS --}}
                    {{-- ================================================= --}}

                    <div class="flex flex-col-reverse gap-3 pt-2
                            sm:flex-row sm:justify-end">


                        {{-- Cancel --}}
                        <a href="{{ route('beds.index') }}"
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


                        {{-- Submit --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center
                               rounded-lg bg-blue-600 px-5 py-2.5
                               text-sm font-semibold text-white
                               hover:bg-blue-700
                               focus:outline-none
                               focus:ring-2 focus:ring-blue-500/30">

                            Add Bed

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection
