<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.22em] text-emerald-600">Community board / Project files</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-stone-900">Project discussions</h1>
                <p class="mt-1 text-sm text-stone-500">A running archive of work, experiments and shipped ideas.</p>
            </div>
            @auth
                <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center gap-2 rounded-sm bg-emerald-300 px-4 py-2.5 text-sm font-bold text-stone-900 shadow-[3px_3px_0_#6ee7b7] transition hover:-translate-y-0.5 hover:bg-emerald-400">
                    <span class="text-lg leading-none" aria-hidden="true">+</span> Start new thread
                </a>
            @endauth
        </div>
    </x-slot>

    <div id="work" class="min-h-[calc(100vh-12rem)] bg-[#efe7d6] py-8 sm:py-12">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_18rem] lg:px-8">
            <main class="min-w-0">
                <div class="flex items-center justify-between gap-4 rounded-t-sm border border-emerald-400/40 bg-emerald-200 px-5 py-3 text-stone-900">
                    <div class="flex items-center gap-3">
                        <span class="h-2 w-2 rounded-full bg-emerald-300 shadow-[0_0_8px_rgba(110,231,183,0.7)]"></span>
                        <h2 class="font-mono text-[11px] font-bold uppercase tracking-[0.18em]">Latest projects</h2>
                    </div>
                    <span class="font-mono text-[10px] uppercase tracking-wider text-stone-600">{{ $posts->total() }} {{ Str::plural('thread', $posts->total()) }}</span>
                </div>

                <div class="grid gap-8 border-x border-b border-emerald-400/30 bg-[#efe7d6] p-4 sm:p-6">
                    @forelse ($posts as $post)
                        @php($imageUrls = $imageUrlsByPost->get($post->id, []))
                        <article class="group overflow-hidden rounded-sm border border-emerald-400/30 bg-[#fffaf0] shadow-[5px_5px_0_rgba(52,211,153,0.22)] transition hover:-translate-y-0.5 hover:bg-white hover:shadow-[7px_7px_0_rgba(52,211,153,0.3)]">
                            <div class="border-b border-emerald-400/30 bg-emerald-50 p-2">
                                @if (count($imageUrls) >= 3)
                                    <div class="grid gap-2 sm:aspect-video sm:grid-cols-[2fr_1fr]">
                                        <div class="relative aspect-video overflow-hidden rounded-sm border border-emerald-400/30 bg-[#fffaf0] sm:aspect-auto sm:min-h-0">
                                            <img src="{{ $imageUrls[0] }}" alt="{{ $post->title }} image 1" class="absolute inset-0 h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.03]">
                                        </div>

                                        <div class="grid gap-2 sm:min-h-0 sm:grid-rows-2">
                                            @foreach (array_slice($imageUrls, 1, 2) as $index => $imageUrl)
                                                <div class="relative aspect-video overflow-hidden rounded-sm border border-emerald-400/30 bg-[#fffaf0] sm:aspect-auto sm:min-h-0">
                                                    <img src="{{ $imageUrl }}" alt="{{ $post->title }} image {{ $index + 2 }}" class="absolute inset-0 h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.03]">
                                                    @if ($loop->last && count($imageUrls) > 3)
                                                        <span class="absolute bottom-2 right-2 rounded-sm bg-emerald-200/95 px-2 py-1 font-mono text-[9px] font-bold text-stone-900">+{{ count($imageUrls) - 3 }} images</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif (count($imageUrls) === 2)
                                    <div class="grid gap-2 sm:grid-cols-2">
                                        @foreach ($imageUrls as $index => $imageUrl)
                                            <div class="overflow-hidden rounded-sm border border-emerald-400/30 bg-[#fffaf0]">
                                                <img src="{{ $imageUrl }}" alt="{{ $post->title }} image {{ $index + 1 }}" class="aspect-video h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif (count($imageUrls) === 1)
                                    <div class="overflow-hidden rounded-sm border border-emerald-400/30 bg-[#fffaf0]">
                                        <img src="{{ $imageUrls[0] }}" alt="{{ $post->title }} image 1" class="aspect-video h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">
                                    </div>
                                @else
                                    <div class="grid aspect-video place-items-center text-stone-400">
                                        <svg class="h-14 w-14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 7.5h6l1.5 2h9.5v8.75A1.75 1.75 0 0 1 18.75 20H5.25a1.75 1.75 0 0 1-1.75-1.75V7.5Z" /></svg>
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 p-5 sm:p-7">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 font-mono text-[10px] uppercase tracking-wider text-stone-500">
                                    <span class="font-bold text-emerald-600">Project #{{ str_pad((string) $post->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    <span aria-hidden="true">/</span>
                                    <time datetime="{{ $post->published_at->toAtomString() }}">{{ $post->published_at->format('M d, Y') }}</time>
                                </div>
                                <h3 class="mt-2 text-2xl font-bold tracking-tight text-stone-900 sm:text-3xl">{{ $post->title }}</h3>
                                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-stone-600 sm:text-base">{{ $post->description }}</p>

                                <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-dashed border-stone-300 pt-3">
                                    <div class="flex items-center gap-2">
                                        <span class="grid h-7 w-7 place-items-center rounded-sm bg-emerald-300 text-[10px] font-bold text-stone-900">{{ strtoupper(substr($post->user->name, 0, 2)) }}</span>
                                        <span class="text-xs text-stone-500">Posted by <strong class="font-semibold text-stone-700">{{ $post->user->name }}</strong></span>
                                    </div>
                                    @auth
                                        @if (auth()->user()->is($post->user))
                                            <a href="{{ route('posts.edit', $post) }}" class="rounded-sm border border-emerald-400/40 px-3 py-1.5 font-mono text-[10px] font-bold uppercase tracking-wider text-stone-600 transition hover:border-emerald-500 hover:text-emerald-600">Edit thread</a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="px-6 py-16 text-center">
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-sm border border-emerald-400/40 bg-emerald-50 text-2xl text-emerald-600">#</div>
                            <h3 class="mt-4 text-lg font-bold text-stone-800">No projects posted yet</h3>
                            <p class="mt-1 text-sm text-stone-500">The first project thread will appear here once it is published.</p>
                            @auth
                                <a href="{{ route('posts.create') }}" class="mt-5 inline-flex rounded-sm bg-emerald-300 px-4 py-2 text-sm font-bold text-stone-900 hover:bg-emerald-400">Create first project</a>
                            @endauth
                        </div>
                    @endforelse
                </div>

                @if ($posts->hasPages())
                    <div class="mt-6">{{ $posts->links() }}</div>
                @endif
            </main>

            <aside class="grid h-fit gap-5">
                <section class="rounded-sm border border-emerald-400/30 bg-[#fffaf0] shadow-[4px_4px_0_rgba(52,211,153,0.22)]">
                    <h2 class="border-b border-stone-300 px-5 py-3 font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-stone-500">Board information</h2>
                    <div class="grid gap-4 p-5">
                        <p class="text-sm leading-6 text-stone-600">A visual logbook of selected development work, design decisions and final results.</p>
                        <dl class="grid grid-cols-2 gap-3 border-t border-dashed border-stone-300 pt-4">
                            <div><dt class="font-mono text-[9px] uppercase tracking-wider text-stone-400">Threads</dt><dd class="mt-1 text-xl font-bold text-stone-900">{{ $posts->total() }}</dd></div>
                            <div><dt class="font-mono text-[9px] uppercase tracking-wider text-stone-400">Status</dt><dd class="mt-1 flex items-center gap-2 text-xs font-bold text-stone-700"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Online</dd></div>
                        </dl>
                    </div>
                </section>
                <section class="rounded-sm border border-emerald-300 bg-emerald-50 p-5">
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.18em] text-emerald-600">Posting policy</p>
                    <p class="mt-2 text-xs leading-5 text-stone-600">Only finished and published project files are visible on this board.</p>
                </section>
            </aside>
        </div>
    </div>
</x-app-layout>
