<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_generated_from_title_when_empty(): void
    {
        $book = Book::factory()->create(['title' => 'Judul Buku Hebat', 'slug' => null]);

        $this->assertSame('judul-buku-hebat', $book->slug);
    }

    public function test_slug_is_unique(): void
    {
        Book::factory()->create(['title' => 'Sama', 'slug' => 'sama']);
        $second = Book::factory()->create(['title' => 'Sama', 'slug' => null]);

        $this->assertNotSame('sama', $second->slug);
        $this->assertStringStartsWith('sama-', $second->slug);
    }

    public function test_custom_slug_is_respected(): void
    {
        $book = Book::factory()->create(['title' => 'Apa Pun', 'slug' => 'slug-khusus']);

        $this->assertSame('slug-khusus', $book->slug);
    }

    public function test_buy_url_uses_marketplace_when_present(): void
    {
        $book = Book::factory()->withMarketplace('https://tokopedia.link/abc')->make();

        $this->assertSame('https://tokopedia.link/abc', $book->buyUrl('6281234567890'));
        $this->assertTrue($book->buysViaMarketplace());
    }

    public function test_buy_url_falls_back_to_whatsapp(): void
    {
        $book = Book::factory()->withoutMarketplace()->make(['title' => 'Buku X']);

        $url = $book->buyUrl('6281234567890');

        $this->assertStringStartsWith('https://wa.me/6281234567890', $url);
        $this->assertStringContainsString(rawurlencode('Buku X'), $url);
        $this->assertFalse($book->buysViaMarketplace());
    }

    public function test_buy_url_is_null_without_marketplace_and_whatsapp(): void
    {
        $book = Book::factory()->withoutMarketplace()->make();

        $this->assertNull($book->buyUrl(null));
    }
}
