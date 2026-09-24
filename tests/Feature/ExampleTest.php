<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_dashboard_displays_published_projects_and_hides_drafts(): void
    {
        $user = User::factory()->create();
        Posts::create([
            'user_id' => $user->id,
            'title' => 'Published portfolio project',
            'description' => 'This project is ready for visitors.',
            'published_at' => now()->addHour(),
        ]);
        Posts::create([
            'user_id' => $user->id,
            'title' => 'Private draft project',
            'description' => 'This project is still being prepared.',
            'published_at' => null,
        ]);

        $response = $this->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Published portfolio project')
            ->assertDontSee('Private draft project');
    }

    public function test_dashboard_only_renders_images_that_exist_on_the_public_disk(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/overview.jpg', 'image contents');
        Storage::disk('public')->put('posts/details.jpg', 'image contents');
        Storage::disk('public')->put('posts/result.jpg', 'image contents');
        $user = User::factory()->create();
        Posts::create([
            'user_id' => $user->id,
            'title' => 'Project with images',
            'description' => 'Only existing files should be rendered.',
            'images' => [
                'posts/overview.jpg',
                'posts/details.jpg',
                'posts/result.jpg',
                'posts/missing.jpg',
            ],
            'published_at' => now(),
        ]);

        $response = $this->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('/storage/posts/overview.jpg', false)
            ->assertSee('/storage/posts/details.jpg', false)
            ->assertSee('/storage/posts/result.jpg', false)
            ->assertDontSee('/storage/posts/missing.jpg', false);
    }
}
