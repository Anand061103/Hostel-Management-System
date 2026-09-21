<header class="sticky top-0 z-30 border-b border-slate-200
           bg-white dark:border-slate-700 dark:bg-slate-900">

    <div class="flex h-20 items-center justify-between px-6">

        {{-- Left --}}
        <div>

            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">
                Dashboard
            </h2>

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Welcome back, {{ auth()->user()->name ?? 'Admin' }}
            </p>

        </div>


        {{-- Right --}}
        <div class="flex items-center gap-5">


            {{-- Back to Global Panel --}}
            @if (auth()->user()->role === 'superadmin' && session('current_hostel_id'))
                <a href="{{ route('owner.exitHostel') }}"
                    class="rounded-lg border border-slate-200
                           bg-white px-3 py-2 text-sm font-medium
                           text-slate-700 transition
                           hover:bg-slate-100
                           dark:border-slate-700
                           dark:bg-slate-800
                           dark:text-slate-200
                           dark:hover:bg-slate-700">

                    ← Global Panel

                </a>
            @endif


            {{-- Theme Toggle --}}
            <button id="theme-toggle" type="button">

                <span id="theme-icon">🌙</span>

            </button>


            {{-- Notification --}}
            <button
                class="relative rounded-full p-2
                       text-slate-500 hover:bg-slate-100
                       hover:text-slate-700
                       dark:text-slate-400
                       dark:hover:bg-slate-800">

                <span class="text-xl">🔔</span>

                <span class="absolute right-1 top-1 h-2.5 w-2.5
                           rounded-full bg-red-500">
                </span>

            </button>


            {{-- Profile --}}
            <a href="{{ route('profile') }}"
                class="flex items-center gap-3 rounded-lg px-2 py-1
                       transition hover:bg-slate-100
                       dark:hover:bg-slate-800">

                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-full bg-blue-600
                           font-semibold text-white">

                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                </div>

                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p>

                    <p class="text-xs text-slate-500 dark:text-slate-400">

                        {{ auth()->user()->role === 'superadmin' ? 'Super Admin' : 'Warden' }}

                    </p>

                </div>

            </a>

        </div>

    </div>

</header>
