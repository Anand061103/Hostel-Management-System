@extends('layouts.admin')

@section('title', $hostel->name . ' Dashboard')

@section('content')

    <div class="min-h-screen bg-slate-100 p-6 dark:bg-slate-950">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                {{ $hostel->name }}
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Hostel Management Dashboard
            </p>

        </div>


        <div
            class="rounded-xl border border-slate-200
                    bg-white p-6 shadow-sm
                    dark:border-slate-800 dark:bg-slate-900">

            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Welcome, {{ $user->name }}
            </h2>

            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                You are managing {{ $hostel->name }}.
            </p>

        </div>

    </div>

@endsection
