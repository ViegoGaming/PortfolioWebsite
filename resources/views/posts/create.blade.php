<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.22em] text-amber-700">Project archive / New file</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-stone-900">Create a new project</h1>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-sm border border-stone-300 bg-white px-4 py-2 text-sm font-semibold text-stone-600 transition hover:border-stone-500 hover:text-stone-900">
                Cancel
            </a>
        </div>
    </x-slot>

    <div class="bg-[#ebe6dc] py-10 sm:py-14">
        <div class="mx-auto grid max-w-6xl gap-6 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_17rem] lg:px-8">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="overflow-hidden rounded-sm border border-stone-300 bg-[#faf8f3] shadow-[6px_6px_0_rgba(68,64,60,0.18)]">
                @csrf

                <div class="flex items-center justify-between gap-4 border-b border-stone-300 bg-stone-900 px-6 py-3 text-stone-100">
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em]">Project details</span>
                    <span class="font-mono text-[10px] text-stone-400">Fields marked * are required</span>
                </div>

                <div class="grid gap-7 p-6 sm:p-8">
                    <div class="grid gap-2">
                        <label for="title" class="text-sm font-bold text-stone-800">Project title <span class="text-amber-700">*</span></label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus placeholder="e.g. Portfolio platform" class="rounded-sm border-stone-300 bg-white text-stone-900 shadow-sm placeholder:text-stone-400 focus:border-amber-700 focus:ring-amber-700">
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-end justify-between gap-3">
                            <label for="description" class="text-sm font-bold text-stone-800">Description <span class="text-amber-700">*</span></label>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-stone-500">Context / Process / Result</span>
                        </div>
                        <textarea id="description" name="description" rows="9" required placeholder="Tell visitors what you built, how you approached it, and what the result was..." class="resize-y rounded-sm border-stone-300 bg-white text-stone-900 shadow-sm placeholder:text-stone-400 focus:border-amber-700 focus:ring-amber-700">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div x-data="{ fileCount: 0 }" class="grid gap-2">
                        <label for="images" class="text-sm font-bold text-stone-800">Project images</label>
                        <label for="images" class="group grid cursor-pointer place-items-center gap-3 rounded-sm border-2 border-dashed border-stone-300 bg-white px-6 py-9 text-center transition hover:border-amber-700 hover:bg-amber-50/50">
                            <span class="grid h-11 w-11 place-items-center rounded-sm bg-stone-100 text-2xl text-stone-500 transition group-hover:bg-amber-100 group-hover:text-amber-800" aria-hidden="true">+</span>
                            <span>
                                <span class="block text-sm font-bold text-stone-800" x-text="fileCount ? `${fileCount} image${fileCount === 1 ? '' : 's'} selected` : 'Choose project images'"></span>
                                <span class="mt-1 block text-xs text-stone-500">JPG, PNG or WebP · maximum 8 files · 5 MB each</span>
                            </span>
                        </label>
                        <input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple class="sr-only" @change="fileCount = $event.target.files.length">
                        <x-input-error :messages="$errors->get('images')" />
                        <x-input-error :messages="$errors->get('images.*')" />
                    </div>

                    <div class="grid gap-2 sm:max-w-sm">
                        <label for="published_at" class="text-sm font-bold text-stone-800">Publish date</label>
                        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at') }}" class="rounded-sm border-stone-300 bg-white text-stone-900 shadow-sm focus:border-amber-700 focus:ring-amber-700">
                        <p class="text-xs leading-relaxed text-stone-500">Leave empty to save this project as a draft.</p>
                        <x-input-error :messages="$errors->get('published_at')" />
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-stone-300 bg-stone-100/70 px-6 py-5 sm:flex-row sm:items-center sm:justify-end sm:px-8">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2.5 text-center text-sm font-semibold text-stone-600 hover:text-stone-900">Discard</a>
                    <button type="submit" class="rounded-sm bg-amber-700 px-6 py-2.5 text-sm font-bold text-white shadow-[3px_3px_0_#292524] transition hover:-translate-y-0.5 hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-700 focus:ring-offset-2">
                        Save project
                    </button>
                </div>
            </form>

            <aside class="h-fit rounded-sm border border-stone-300 bg-[#faf8f3] p-5 shadow-sm">
                <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-stone-500">Filing guide</p>
                <ol class="mt-4 grid gap-4 text-sm text-stone-600">
                    <li class="flex gap-3"><span class="font-mono font-bold text-amber-700">01</span><span>Use a short, recognizable project title.</span></li>
                    <li class="flex gap-3"><span class="font-mono font-bold text-amber-700">02</span><span>Lead with your strongest image.</span></li>
                    <li class="flex gap-3"><span class="font-mono font-bold text-amber-700">03</span><span>Explain your role and the outcome.</span></li>
                </ol>
                <div class="mt-5 border-t border-dashed border-stone-300 pt-4">
                    <p class="text-xs leading-relaxed text-stone-500">Projects without a publish date remain private and can be completed later.</p>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
