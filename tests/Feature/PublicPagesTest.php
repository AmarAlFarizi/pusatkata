<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_with_featured_books(): void
    {
        $featured = Book::factory()->featured()->published()->create();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($featured->title);
    }

    public function test_static_pages_load(): void
    {
        $this->get(route('about'))->assertOk();
        $this->get(route('services'))->assertOk();
        $this->get(route('contact'))->assertOk();
    }

    public function test_catalog_index_loads(): void
    {
        $book = Book::factory()->create();

        $this->get(route('catalog.index'))
            ->assertOk();
    }

    public function test_book_detail_loads(): void
    {
        $book = Book::factory()->published()->create();

        $this->get(route('catalog.show', $book))
            ->assertOk()
            ->assertSee($book->title)
            ->assertSee($book->isbn_number);
    }

    public function test_unknown_book_slug_returns_404(): void
    {
        $this->get('/katalog/buku-tidak-ada')->assertNotFound();
    }

    public function test_posts_index_loads(): void
    {
        $post = Post::factory()->published()->create();

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee($post->title);
    }
}
