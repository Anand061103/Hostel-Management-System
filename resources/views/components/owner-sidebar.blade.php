<aside
    class="fixed left-0 top-0 z-40 h-screen w-64
           border-r border-slate-200
           bg-slate-100
           dark:border-slate-800
           dark:bg-slate-900">

    <div class="flex h-full flex-col">

        {{-- Logo / Brand --}}
        <div
            class="flex h-20 items-center border-b
                   border-slate-200 px-6
                   dark:border-slate-800">

            <div>
                <h1 class="text-lg font-bold text-slate-800 dark:text-white">
                    Hostel Management
                </h1>

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Super Admin
                </p>
            </div>

        </div>


        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6">

            <p
                class="mb-4 px-3 text-xs font-medium uppercase
                       tracking-wider text-slate-500
                       dark:text-slate-400">
                Main Menu
            </p>


            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
                class="mb-2 flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm font-medium
                       text-slate-700 transition
                       hover:bg-slate-200
                       dark:text-slate-300
                       dark:hover:bg-slate-800">

                <span>📊</span>

                <span>Dashboard</span>

            </a>


            {{-- Profile --}}
            <a href="{{ route('profile') }}"
                class="mb-2 flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm font-medium
                       text-slate-700 transition
                       hover:bg-slate-200
                       dark:text-slate-300
                       dark:hover:bg-slate-800">

                <span>👤</span>

                <span>My Profile</span>

            </a>


            {{-- My Hostels --}}
            <a href="{{ route('profile') }}"
                class="mb-2 flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm font-medium
                       text-slate-700 transition
                       hover:bg-slate-200
                       dark:text-slate-300
                       dark:hover:bg-slate-800">

                <span>🏠</span>

                <span>My Hostels</span>

            </a>


            {{-- Wardens --}}
            <a href="{{ route('wardens.create') }}"
                class="mb-2 flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm font-medium
                       text-slate-700 transition
                       hover:bg-slate-200
                       dark:text-slate-300
                       dark:hover:bg-slate-800">

                <span>👨‍💼</span>

                <span>Wardens</span>

            </a>


            {{-- Add Hostel --}}
            <a href="{{ route('hostels.create') }}"
                class="mb-2 flex items-center gap-3 rounded-lg
                       px-3 py-2.5 text-sm font-medium
                       text-slate-700 transition
                       hover:bg-slate-200
                       dark:text-slate-300
                       dark:hover:bg-slate-800">

                <span>➕</span>

                <span>Add Hostel</span>

            </a>


            {{-- System --}}
            <div class="mt-8">

                <p
                    class="mb-4 px-3 text-xs font-medium uppercase
                           tracking-wider text-slate-500
                           dark:text-slate-400">

                    System

                </p>


                <a href="#"
                    class="flex items-center gap-3 rounded-lg
                           px-3 py-2.5 text-sm font-medium
                           text-slate-700 transition
                           hover:bg-slate-200
                           dark:text-slate-300
                           dark:hover:bg-slate-800">

                    <span>⚙️</span>

                    <span>Settings</span>

                </a>

            </div>

        </nav>

    </div>

</aside>
