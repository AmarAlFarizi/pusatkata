<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_post_is_accessible(): void
    {
        $post = Post::factory()->published()->create();

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_draft_post_returns_404(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get(route('posts.show', $post))->assertNotFound();
    }

    public function test_scheduled_post_is_not_yet_visible(): void
    {
        $post = Post::factory()->scheduled()->create();

        $this->get(route('posts.show', $post))->assertNotFound();
    }

    public function test_draft_post_is_hidden_from_index(): void
    {
        $published = Post::factory()->published()->create();
        $draft = Post::factory()->draft()->create();

        $this->get(route('posts.index'))
            ->assertSee($published->title)
            ->assertDontSee($draft->title);
    }
}
