<?php

namespace Tests\Feature;

use App\Livewire\BookCatalog;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BookCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_filters_books_by_title(): void
    {
        $match = Book::factory()->create(['title' => 'Belajar Laravel Mahir']);
        $other = Book::factory()->create(['title' => 'Resep Masakan Nusantara']);

        Livewire::test(BookCatalog::class)
            ->set('search', 'Laravel')
            ->assertSee($match->title)
            ->assertDontSee($other->title);
    }

    public function test_search_matches_author_and_isbn(): void
    {
        $byAuthor = Book::factory()->create(['author' => 'Andrea Hirata']);
        $byIsbn = Book::factory()->published()->create(['isbn_number' => '978-602-1234-56-7']);

        Livewire::test(BookCatalog::class)
            ->set('search', 'Andrea')
            ->assertSee($byAuthor->title);

        Livewire::test(BookCatalog::class)
            ->set('search', '978-602-1234-56-7')
            ->assertSee($byIsbn->title);
    }

    public function test_filter_by_category(): void
    {
        $fiction = Category::factory()->create(['name' => 'Fiksi', 'slug' => 'fiksi']);
        $tech = Category::factory()->create(['name' => 'Teknologi', 'slug' => 'teknologi']);

        $fictionBook = Book::factory()->for($fiction)->create();
        $techBook = Book::factory()->for($tech)->create();

        Livewire::test(BookCatalog::class)
            ->set('category', 'fiksi')
            ->assertSee($fictionBook->title)
            ->assertDontSee($techBook->title);
    }

    public function test_clear_filters_resets_state(): void
    {
        Book::factory()->count(2)->create();

        Livewire::test(BookCatalog::class)
            ->set('search', 'sesuatu')
            ->set('category', 'apa-saja')
            ->call('clearFilters')
            ->assertSet('search', '')
            ->assertSet('category', null);
    }
}
