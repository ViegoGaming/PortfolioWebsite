<nav x-data="{ open: false }" class="relative z-40 border-b border-stone-300 bg-[#f4f0e8] text-stone-900 shadow-[0_1px_0_rgba(68,64,60,0.08)]">
    <div class="border-b border-stone-300/80 bg-stone-900 text-stone-100">
        <div class="mx-auto flex h-7 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-stone-300">Selected case studies &amp; experiments</p>
            <div class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.16em] text-stone-300">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.7)]"></span>
                Project archive / 2026
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-6">
            <a href="{{ url('/') }}" class="group flex shrink-0 items-center gap-3" aria-label="Go to portfolio home">
                <span class="grid h-11 w-11 place-items-center rounded-sm bg-amber-700 text-white shadow-[3px_3px_0_#292524] transition-transform duration-200 group-hover:-translate-y-0.5">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 7.5h6l1.5 2h9.5v8.75A1.75 1.75 0 0 1 18.75 20H5.25a1.75 1.75 0 0 1-1.75-1.75V7.5Zm2.5 0V5.75C6 4.78 6.78 4 7.75 4h3.5L13 6h3.25C17.22 6 18 6.78 18 7.75V9.5" />
                    </svg>
                </span>
                <span>
                    <span class="block text-base font-bold leading-none tracking-tight">PROJECT FILES</span>
                    <span class="mt-1 block font-mono text-[10px] uppercase tracking-[0.24em] text-stone-500">Portfolio / Case studies</span>
                </span>
            </a>

            <div class="hidden items-center gap-1 lg:flex" aria-label="Primary navigation">
                <a href="{{ url('/') }}" class="rounded-sm border-b-2 px-4 py-2 text-sm font-semibold transition-colors {{ request()->is('/') ? 'border-amber-700 text-stone-950' : 'border-transparent text-stone-600 hover:border-stone-400 hover:text-stone-950' }}">Overview</a>
                <a href="{{ url('/#work') }}" class="rounded-sm border-b-2 border-transparent px-4 py-2 text-sm font-semibold text-stone-600 transition-colors hover:border-stone-400 hover:text-stone-950">Projects</a>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                @auth
                    <x-dropdown align="right" width="48" contentClasses="py-1 bg-[#faf8f3]">
                        <x-slot name="trigger">
                            <button type="button" class="flex items-center gap-3 rounded-sm border border-stone-300 bg-[#faf8f3] px-3 py-2 text-left shadow-sm transition hover:border-stone-500 focus:outline-none focus:ring-2 focus:ring-amber-700 focus:ring-offset-2 focus:ring-offset-[#f4f0e8]">
                                <span class="grid h-8 w-8 place-items-center rounded-sm bg-stone-800 text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                <span class="hidden xl:block">
                                    <span class="block text-xs font-bold leading-tight">{{ auth()->user()->name }}</span>
                                    <span class="block font-mono text-[9px] uppercase tracking-wider text-stone-500">Studio account</span>
                                </span>
                                <svg class="h-4 w-4 text-stone-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="rounded-sm border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 transition hover:border-stone-500 hover:bg-white">Sign in</a>
                @endauth

                <a href="{{ url('/#work') }}" class="hidden items-center gap-2 rounded-sm bg-amber-700 px-4 py-2.5 text-sm font-bold text-white shadow-[3px_3px_0_#292524] transition hover:-translate-y-0.5 hover:bg-amber-800 md:flex">
                    Browse projects <span aria-hidden="true">&darr;</span>
                </a>
            </div>

            <button @click="open = ! open" type="button" class="grid h-11 w-11 place-items-center rounded-sm border border-stone-400 bg-[#faf8f3] text-stone-800 shadow-[2px_2px_0_#78716c] focus:outline-none focus:ring-2 focus:ring-amber-700 sm:hidden" :aria-expanded="open" aria-controls="mobile-navigation" aria-label="Toggle navigation">
                <svg x-show="! open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" /></svg>
                <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" /></svg>
            </button>
        </div>
    </div>

    <div id="mobile-navigation" x-show="open" x-cloak class="border-t border-stone-300 bg-[#faf8f3] sm:hidden">
        <div class="grid gap-1 px-4 py-4">
            <a href="{{ url('/') }}" class="rounded-sm bg-stone-900 px-4 py-3 text-sm font-bold text-white">Overview</a>
            <a href="{{ url('/#work') }}" class="rounded-sm px-4 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-200">Projects</a>
        </div>
        <div class="border-t border-dashed border-stone-300 px-4 py-4">
            @auth
                <p class="px-4 pb-2 font-mono text-[10px] uppercase tracking-widest text-stone-500">Signed in as {{ auth()->user()->name }}</p>
                <a href="{{ route('profile.edit') }}" class="block rounded-sm px-4 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-200">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-sm px-4 py-3 text-left text-sm font-semibold text-stone-700 hover:bg-stone-200">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block rounded-sm px-4 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-200">Sign in</a>
            @endauth
            <a href="{{ url('/#work') }}" class="mt-2 flex items-center justify-between rounded-sm bg-amber-700 px-4 py-3 text-sm font-bold text-white">Browse projects <span aria-hidden="true">&darr;</span></a>
         </div>
    </div>
</nav>
