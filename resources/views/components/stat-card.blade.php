@props([
    'title',
    'value',
    'subtitle',
    'icon',
])

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">

    <div class="flex items-center justify-between">

        <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                {{ $title }}
            </p>

            <h2 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                {{ $value }}
            </h2>

            <p class="mt-2 text-xs text-emerald-600">
                {{ $subtitle }}
            </p>
        </div>

        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl dark:bg-blue-900/30">
            {{ $icon }}
        </div>

    </div>

</div>