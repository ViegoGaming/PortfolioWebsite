<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Posts;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Posts::query()
            ->with('user:id,name')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(10);

        $imageUrlsByPost = $posts->getCollection()->mapWithKeys(function (Posts $post): array {
            $imageUrls = collect($post->images ?? [])
                ->filter(fn (string $path): bool => Storage::disk('public')->exists($path))
                ->map(fn (string $path): string => Storage::disk('public')->url($path))
                ->values()->all();

            return [$post->id => $imageUrls];
        });

        return view('dashboard', [
            'posts' => $posts,
            'imageUrlsByPost' => $imageUrlsByPost,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $imagePaths = collect($request->file('images', []))
            ->map(fn (UploadedFile $image): string => $image->store('posts', 'public'))
            ->all();

        $request->user()->posts()->create([
            ...$request->safe()->only(['title', 'description', 'published_at']),
            'images' => $imagePaths,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Posts $post): View
    {
        abort_unless($request->user()->is($post->user), 404);

        $images = collect($post->images ?? [])
            ->filter(fn (string $path): bool => Storage::disk('public')->exists($path))
            ->map(fn (string $path): array => [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
            ])
            ->values()
            ->all();

        return view('posts.edit', [
            'post' => $post,
            'images' => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Posts $post): RedirectResponse
    {
        $attributes = $request->safe()->only(['title', 'description', 'published_at']);

        if ($request->hasFile('images')) {
            $previousImagePaths = $post->images ?? [];
            $newImagePaths = collect($request->file('images'))
                ->map(fn (UploadedFile $image): string => $image->store('posts', 'public'))
                ->all();

            try {
                $post->updateOrFail([
                    ...$attributes,
                    'images' => $newImagePaths,
                ]);
            } catch (\Throwable $exception) {
                Storage::disk('public')->delete($newImagePaths);

                throw $exception;
            }

            Storage::disk('public')->delete($previousImagePaths);
        } else {
            $post->updateOrFail($attributes);
        }

        return redirect()
            ->route('dashboard')
            ->with('status', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $posts)
    {
        //
    }
}
