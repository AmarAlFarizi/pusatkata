<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_has_basic_meta_and_structured_data(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('rel="canonical"', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('name="twitter:card"', false)
            ->assertSee('"@type":"Organization"', false);
    }

    public function test_book_detail_has_book_schema(): void
    {
        $book = Book::factory()->published()->create(['title' => 'Buku SEO']);

        $this->get(route('catalog.show', $book))
            ->assertOk()
            ->assertSee('"@type":"Book"', false)
            ->assertSee('property="og:type" content="book"', false);
    }

    public function test_post_detail_has_article_schema(): void
    {
        $post = Post::factory()->published()->create(['title' => 'Artikel SEO']);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('"@type":"Article"', false);
    }

    public function test_sitemap_lists_books_and_posts(): void
    {
        $book = Book::factory()->create();
        $post = Post::factory()->published()->create();

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('<urlset', false)
            ->assertSee($book->slug)
            ->assertSee($post->slug);
    }

    public function test_robots_txt_allows_and_links_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap:')
            ->assertSee('GPTBot');
    }
}
