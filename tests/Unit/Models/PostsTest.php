<?php

namespace Tests\Unit\Models;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class PostsTest extends TestCase
{
    public function test_project_content_is_mass_assignable_and_structured_fields_are_cast(): void
    {
        $project = new Posts([
            'title' => 'Portfolio platform',
            'description' => 'A Laravel portfolio application.',
            'images' => ['projects/overview.webp', 'projects/dashboard.webp'],
            'published_at' => '2026-09-08 10:00:00',
        ]);

        $this->assertSame(['projects/overview.webp', 'projects/dashboard.webp'], $project->images);
        $this->assertSame('2026-09-08 10:00:00', $project->published_at->format('Y-m-d H:i:s'));
    }

    public function test_project_belongs_to_an_author(): void
    {
        $project = new Posts;

        $relation = $project->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertSame(User::class, $relation->getRelated()::class);
        $this->assertSame('user_id', $relation->getForeignKeyName());
    }
}
