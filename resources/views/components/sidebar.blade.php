<aside class="flex w-64 shrink-0 flex-col bg-slate-900 text-white">
    {{-- Logo --}}
    <div class="flex h-20 items-center border-b border-slate-800 px-6">
        <div>
            <h1 class="text-xl font-bold">Hostel<span class="text-blue-400">MS</span></h1>
            <p class="text-xs text-slate-400">Management System</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="mt-6 px-4">

        <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
            Main Menu
        </p>

        <a href="{{ route('dashboard') }}"
           class="mb-2 flex items-center gap-3 rounded-lg bg-blue-600 px-4 py-3 text-sm font-medium">
            <span>📊</span>
            <span>Dashboard</span>
        </a>

       <a href="{{ route('students.index') }}"
           class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white">
            <span>👨‍🎓</span>
            <span>Students</span>
        </a>

        <a href="#"
           class="mb-2 flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
            <span>🚪</span>
            <span>Rooms</span>
        </a>

        <a href="#"
           class="mb-2 flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
            <span>🛏️</span>
            <span>Beds</span>
        </a>

        <a href="#"
           class="mb-2 flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
            <span>💰</span>
            <span>Fees</span>
        </a>

        <a href="#"
           class="mb-2 flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
            <span>⚠️</span>
            <span>Complaints</span>
        </a>

        <a href="#"
           class="mb-2 flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
            <span>📢</span>
            <span>Notices</span>
        </a>

        <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
            System
        </p>

        <a href="#"
           class="mb-2 flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white">
            <span>⚙️</span>
            <span>Settings</span>
        </a>

    </nav>

    {{-- Logout --}}
<div class="mt-auto border-t border-slate-800 p-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium text-slate-300 hover:bg-red-500/10 hover:text-red-400">
                <span>🚪</span>
                <span>Logout</span>
            </button>
        </form>

    </div>

</aside>