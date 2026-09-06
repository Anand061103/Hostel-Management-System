<header class="sticky top-0 z-30 border-b border-slate-200 bg-white">

    <div class="flex h-20 items-center justify-between px-6">

        {{-- Left --}}
        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                Dashboard
            </h2>

            <p class="text-sm text-slate-500">
                Welcome back, {{ auth()->user()->name ?? 'Admin' }}
            </p>
        </div>

        {{-- Right --}}
        <div class="flex items-center gap-5">

            {{-- Notification --}}
            <button
                class="relative rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700">

                <span class="text-xl">🔔</span>

                <span
                    class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full bg-red-500">
                </span>
            </button>

            {{-- Profile --}}
            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Administrator
                    </p>
                </div>

            </div>

        </div>

    </div>

</header>