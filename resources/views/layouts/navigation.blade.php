<nav x-data="{ open: false }" class="relative z-40 border-b border-emerald-400/30 bg-[#efe7d6] text-stone-900 shadow-[0_1px_0_rgba(52,211,153,0.18)]">
    <div class="border-b border-emerald-400/30 bg-emerald-200 text-stone-900">
        <div class="mx-auto flex h-7 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-stone-600">Selected case studies &amp; experiments</p>
            <div class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.16em] text-stone-600">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(52,211,153,0.7)]"></span>
                Project archive / 2026
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative flex h-28 items-center justify-between gap-6">
            <a href="{{ url('/') }}" class="group flex shrink-0 items-center gap-3" aria-label="Go to portfolio home">
                <span class="grid h-11 w-11 place-items-center rounded-sm bg-emerald-300 text-stone-900 shadow-[3px_3px_0_#6ee7b7] transition-transform duration-200 group-hover:-translate-y-0.5">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 7.5h6l1.5 2h9.5v8.75A1.75 1.75 0 0 1 18.75 20H5.25a1.75 1.75 0 0 1-1.75-1.75V7.5Zm2.5 0V5.75C6 4.78 6.78 4 7.75 4h3.5L13 6h3.25C17.22 6 18 6.78 18 7.75V9.5" />
                    </svg>
                </span>
                <span>
                    <span class="block text-base font-bold leading-none tracking-tight">PROJECT FILES</span>
                    <span class="mt-1 block font-mono text-[10px] uppercase tracking-[0.24em] text-stone-500">Portfolio / Case studies</span>
                </span>
            </a>

            <div class="absolute left-1/2 top-1/2 hidden -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-2 md:flex" aria-label="Primary navigation">
                <div class="flex items-center gap-1">
                    <a href="{{ url('/') }}" class="rounded-sm border-b-2 px-4 py-2 text-sm font-semibold transition-colors {{ request()->is('/') ? 'border-emerald-500 text-stone-950' : 'border-transparent text-stone-600 hover:border-emerald-400 hover:text-stone-950' }}">Overview</a>
                    <a href="{{ url('/#work') }}" class="rounded-sm border-b-2 border-transparent px-4 py-2 text-sm font-semibold text-stone-600 transition-colors hover:border-emerald-400 hover:text-stone-950">Projects</a>
                </div>
                <a href="{{ url('/#work') }}" class="flex items-center gap-2 rounded-sm bg-emerald-300 px-4 py-2 text-xs font-bold text-stone-900 shadow-[3px_3px_0_#6ee7b7] transition hover:-translate-y-0.5 hover:bg-emerald-400">
                    Browse projects <span aria-hidden="true">&darr;</span>
                </a>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <x-dropdown align="right" width="48" contentClasses="py-1 bg-[#fffaf0]">
                        <x-slot name="trigger">
                            <button type="button" class="flex items-center gap-3 rounded-sm border border-emerald-400/40 bg-[#fffaf0] px-3 py-2 text-left shadow-sm transition hover:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-offset-2 focus:ring-offset-[#efe7d6]">
                                <span class="grid h-8 w-8 place-items-center rounded-sm bg-emerald-300 text-xs font-bold text-stone-900">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                <span class="hidden xl:block">
                                    <span class="block text-xs font-bold leading-tight">{{ auth()->user()->name }}</span>
                                    <span class="block font-mono text-[9px] uppercase tracking-wider text-stone-500">Studio account</span>
                                </span>
                                <svg class="h-4 w-4 text-stone-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-3 pb-1 pt-2">
                                <a href="{{ route('posts.create') }}" class="flex items-center justify-center gap-1.5 rounded-sm bg-emerald-300 px-3 py-2 text-xs font-bold text-stone-900 shadow-[2px_2px_0_#6ee7b7] transition hover:-translate-y-0.5 hover:bg-emerald-400">
                                    <span class="text-base leading-none" aria-hidden="true">+</span>
                                    New post
                                </a>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="rounded-sm border border-emerald-400/40 bg-[#fffaf0] px-4 py-2 text-sm font-semibold text-stone-700 transition hover:border-emerald-400 hover:bg-white">Sign in</a>
                    <a href="{{ route('register') }}" class="rounded-sm bg-emerald-300 px-4 py-2 text-sm font-semibold text-stone-900 shadow-[2px_2px_0_#6ee7b7] transition hover:-translate-y-0.5 hover:bg-emerald-400">Register</a>
                @endauth

            </div>

            <button @click="open = ! open" type="button" class="grid h-11 w-11 place-items-center rounded-sm border border-emerald-400 bg-emerald-100 text-stone-800 shadow-[2px_2px_0_#6ee7b7] focus:outline-none focus:ring-2 focus:ring-emerald-300 md:hidden" :aria-expanded="open" aria-controls="mobile-navigation" aria-label="Toggle navigation">
                <svg x-show="! open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" /></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" /></svg>
            </button>
        </div>
    </div>

    <div id="mobile-navigation" x-show="open" x-cloak class="border-t border-emerald-400/30 bg-[#fffaf0] md:hidden">
        <div class="flex flex-col items-center gap-3 px-4 py-4">
            <div class="grid w-full grid-cols-2 gap-1">
                <a href="{{ url('/') }}" class="rounded-sm bg-emerald-300 px-4 py-3 text-center text-sm font-bold text-stone-900">Overview</a>
                <a href="{{ url('/#work') }}" class="rounded-sm px-4 py-3 text-center text-sm font-semibold text-stone-700 hover:bg-emerald-100">Projects</a>
            </div>
            <a href="{{ url('/#work') }}" class="flex items-center gap-2 rounded-sm bg-emerald-300 px-4 py-2.5 text-sm font-bold text-stone-900 shadow-[3px_3px_0_#6ee7b7]">Browse projects <span aria-hidden="true">&darr;</span></a>
        </div>
        <div class="border-t border-dashed border-stone-300 px-4 py-4">
            @auth
                <p class="px-4 pb-2 font-mono text-[10px] uppercase tracking-widest text-stone-500">Signed in as {{ auth()->user()->name }}</p>
                <div class="px-4 pb-3">
                    <a href="{{ route('posts.create') }}" class="flex items-center justify-center gap-1.5 rounded-sm bg-emerald-300 px-3 py-2 text-xs font-bold text-stone-900 shadow-[2px_2px_0_#6ee7b7]">
                        <span class="text-base leading-none" aria-hidden="true">+</span>
                        New post
                    </a>
                </div>
                <a href="{{ route('profile.edit') }}" class="block rounded-sm px-4 py-3 text-sm font-semibold text-stone-700 hover:bg-emerald-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-sm px-4 py-3 text-left text-sm font-semibold text-stone-700 hover:bg-emerald-100">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block rounded-sm px-4 py-3 text-sm font-semibold text-stone-700 hover:bg-emerald-100">Sign in</a>
                <a href="{{ route('register') }}" class="block rounded-sm bg-emerald-300 px-4 py-3 text-sm font-semibold text-stone-900">Register</a>
            @endauth
         </div>
    </div>
</nav>
