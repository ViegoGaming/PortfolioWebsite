<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostsRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_post_management(): void
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirectToRoute('login');
    }

    public function test_authenticated_user_can_view_the_create_project_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response
            ->assertOk()
            ->assertSee('Create a new project')
            ->assertSee('Save project');
    }

    public function test_authenticated_user_can_create_a_project_with_multiple_images(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Portfolio platform',
            'description' => 'A project that showcases my Laravel work.',
            'images' => [
                UploadedFile::fake()->image('overview.jpg'),
                UploadedFile::fake()->image('dashboard.png'),
            ],
            'published_at' => '2026-09-08 12:00:00',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('dashboard');

        $post = $user->posts()->sole();

        $this->assertSame('Portfolio platform', $post->title);
        $this->assertCount(2, $post->images);
        Storage::disk('public')->assertExists($post->images);
    }

    public function test_invalid_project_image_returns_a_visible_validation_error(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('posts.create'))
            ->post(route('posts.store'), [
                'title' => 'Portfolio platform',
                'description' => 'A project with an invalid uploaded file.',
                'images' => [UploadedFile::fake()->create('notes.jpg', 10, 'text/plain')],
            ]);

        $response->assertSee('Each uploaded file must be an image.');

        $this->assertSame(0, $user->posts()->count());
        Storage::disk('public')->assertDirectoryEmpty('posts');
    }

    public function test_project_owner_can_view_the_edit_page(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/current.jpg', 'image contents');
        $user = User::factory()->create();
        $post = Posts::create([
            'user_id' => $user->id,
            'title' => 'Existing project',
            'description' => 'Existing project description.',
            'images' => ['posts/current.jpg'],
            'published_at' => '2026-09-08 12:00:00',
        ]);

        $response = $this->actingAs($user)->get(route('posts.edit', $post));

        $response
            ->assertSee('Edit project')
            ->assertSee('Existing project')
            ->assertSee('Existing project description.')
            ->assertSee('/storage/posts/current.jpg', false);
    }

    public function test_user_cannot_view_another_users_edit_page(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Posts::create([
            'user_id' => $owner->id,
            'title' => 'Private project',
            'description' => 'Only the owner may edit this.',
        ]);

        $response = $this->actingAs($otherUser)->get(route('posts.edit', $post));

        $response->assertNotFound();
    }

    public function test_project_owner_can_update_details_without_replacing_images(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/current.jpg', 'image contents');
        $user = User::factory()->create();
        $post = Posts::create([
            'user_id' => $user->id,
            'title' => 'Old title',
            'description' => 'Old description.',
            'images' => ['posts/current.jpg'],
            'published_at' => null,
        ]);

        $response = $this->actingAs($user)->put(route('posts.update', $post), [
            'title' => 'Updated title',
            'description' => 'Updated description.',
            'published_at' => '2026-09-10 14:30:00',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('dashboard');

        $post->refresh();

        $this->assertSame('Updated title', $post->title);
        $this->assertSame('Updated description.', $post->description);
        $this->assertSame(['posts/current.jpg'], $post->images);
        $this->assertSame('2026-09-10 14:30:00', $post->published_at->format('Y-m-d H:i:s'));
        Storage::disk('public')->assertExists('posts/current.jpg');
    }

    public function test_new_images_replace_the_existing_project_images(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/old.jpg', 'old image contents');
        $user = User::factory()->create();
        $post = Posts::create([
            'user_id' => $user->id,
            'title' => 'Project title',
            'description' => 'Project description.',
            'images' => ['posts/old.jpg'],
        ]);

        $response = $this->actingAs($user)->put(route('posts.update', $post), [
            'title' => 'Project title',
            'description' => 'Project description.',
            'images' => [
                UploadedFile::fake()->image('new-overview.jpg'),
                UploadedFile::fake()->image('new-details.png'),
            ],
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('dashboard');

        $post->refresh();

        $this->assertCount(2, $post->images);
        Storage::disk('public')->assertExists($post->images);
        Storage::disk('public')->assertMissing('posts/old.jpg');
    }

    public function test_user_cannot_update_another_users_project(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Posts::create([
            'user_id' => $owner->id,
            'title' => 'Original title',
            'description' => 'Original description.',
        ]);

        $response = $this->actingAs($otherUser)->put(route('posts.update', $post), [
            'title' => 'Unauthorized title',
            'description' => 'Unauthorized description.',
        ]);

        $response->assertNotFound();
        $this->assertSame('Original title', $post->fresh()->title);
    }
}
