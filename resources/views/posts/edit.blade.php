<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.22em] text-emerald-600">Project archive / Edit file</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-stone-900">Edit project</h1>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-sm border border-emerald-400/40 bg-[#fffaf0] px-4 py-2 text-center text-sm font-semibold text-stone-600 transition hover:border-emerald-400 hover:bg-white hover:text-stone-900">Cancel</a>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-12rem)] bg-[#efe7d6] py-10 sm:py-14">
        <div class="mx-auto grid max-w-6xl gap-6 px-4 sm:px-6 lg:grid-cols-[minmax(0,1fr)_17rem] lg:px-8">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="overflow-hidden rounded-sm border border-emerald-400/30 bg-[#fffaf0] shadow-[6px_6px_0_rgba(52,211,153,0.22)]">
                @csrf
                @method('PUT')

                <div class="flex items-center justify-between gap-4 border-b border-emerald-400/30 bg-emerald-200 px-6 py-3 text-stone-900">
                    <span class="font-mono text-[10px] font-bold uppercase tracking-[0.2em]">Project details</span>
                    <span class="font-mono text-[10px] text-stone-600">Fields marked * are required</span>
                </div>

                <div class="grid gap-7 p-6 sm:p-8">
                    <div class="grid gap-2">
                        <label for="title" class="text-sm font-bold text-stone-800">Project title <span class="text-emerald-600">*</span></label>
                        <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required autofocus class="rounded-sm border-emerald-400/40 bg-white text-stone-900 shadow-sm focus:border-emerald-400 focus:ring-emerald-300">
                        <x-input-error :messages="$errors->get('title')" />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-end justify-between gap-3">
                            <label for="description" class="text-sm font-bold text-stone-800">Description <span class="text-emerald-600">*</span></label>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-stone-500">Context / Process / Result</span>
                        </div>
                        <textarea id="description" name="description" rows="9" required class="resize-y rounded-sm border-emerald-400/40 bg-white text-stone-900 shadow-sm focus:border-emerald-400 focus:ring-emerald-300">{{ old('description', $post->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    @if ($images)
                        <div class="grid gap-3">
                            <div>
                                <h2 class="text-sm font-bold text-stone-800">Current images</h2>
                                <p class="mt-1 text-xs text-stone-500">These remain unchanged unless you upload replacements.</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                @foreach ($images as $index => $image)
                                    <img src="{{ $image['url'] }}" alt="Current {{ $post->title }} image {{ $index + 1 }}" class="aspect-video w-full rounded-sm border border-emerald-400/30 object-cover">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div x-data="{ fileCount: 0 }" class="grid gap-2">
                        <label for="images" class="text-sm font-bold text-stone-800">Replace project images</label>
                        <label for="images" class="group grid cursor-pointer place-items-center gap-3 rounded-sm border-2 border-dashed border-emerald-400/40 bg-white px-6 py-9 text-center transition hover:border-emerald-400 hover:bg-emerald-50">
                            <span class="grid h-11 w-11 place-items-center rounded-sm bg-emerald-100 text-2xl text-emerald-600 transition group-hover:bg-emerald-200" aria-hidden="true">+</span>
                            <span>
                                <span class="block text-sm font-bold text-stone-800" x-text="fileCount ? `${fileCount} replacement image${fileCount === 1 ? '' : 's'} selected` : 'Choose replacement images'"></span>
                                <span class="mt-1 block text-xs text-stone-500">Optional · JPG, PNG or WebP · maximum 8 files · 5 MB each</span>
                            </span>
                        </label>
                        <input id="images" name="images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple class="sr-only" @change="fileCount = $event.target.files.length">
                        <x-input-error :messages="$errors->get('images')" />
                        <x-input-error :messages="$errors->get('images.*')" />
                    </div>

                    <div class="grid gap-2 sm:max-w-sm">
                        <label for="published_at" class="text-sm font-bold text-stone-800">Publish date</label>
                        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="rounded-sm border-emerald-400/40 bg-white text-stone-900 shadow-sm focus:border-emerald-400 focus:ring-emerald-300">
                        <p class="text-xs leading-relaxed text-stone-500">Leave empty to keep this project as a private draft.</p>
                        <x-input-error :messages="$errors->get('published_at')" />
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-emerald-400/30 bg-emerald-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-end sm:px-8">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2.5 text-center text-sm font-semibold text-stone-600 hover:text-stone-900">Discard changes</a>
                    <button type="submit" class="rounded-sm bg-emerald-300 px-6 py-2.5 text-sm font-bold text-stone-900 shadow-[3px_3px_0_#6ee7b7] transition hover:-translate-y-0.5 hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-300 focus:ring-offset-2">Save changes</button>
                </div>
            </form>

            <aside class="h-fit rounded-sm border border-emerald-400/30 bg-[#fffaf0] p-5 shadow-[4px_4px_0_rgba(52,211,153,0.18)]">
                <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-emerald-600">Editing guide</p>
                <ul class="mt-4 grid gap-4 text-sm leading-6 text-stone-600">
                    <li>Uploading new images replaces every current image.</li>
                    <li>Leave the image field empty to keep the current gallery.</li>
                    <li>Remove the publish date to return the project to draft status.</li>
                </ul>
            </aside>
        </div>
    </div>
</x-app-layout>
