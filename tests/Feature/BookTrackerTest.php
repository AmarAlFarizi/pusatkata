<?php

namespace Tests\Feature;

use App\Enums\ProductionStage;
use App\Livewire\BookTracker;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class BookTrackerTest extends TestCase
{
    use RefreshDatabase;

    public function test_track_page_loads(): void
    {
        $this->get(route('track'))->assertOk();
    }

    public function test_search_finds_book_and_shows_stage(): void
    {
        $book = Book::factory()->create([
            'title' => 'Belajar Laravel Mahir',
            'production_stage' => ProductionStage::Desain,
        ]);

        Livewire::test(BookTracker::class)
            ->set('query', 'Laravel')
            ->call('search')
            ->assertSee('Belajar Laravel Mahir')
            ->assertSee(ProductionStage::Desain->label());
    }

    public function test_search_unknown_title_shows_empty_message(): void
    {
        Book::factory()->create(['title' => 'Judul Lain']);

        Livewire::test(BookTracker::class)
            ->set('query', 'tidak ada judul ini')
            ->call('search')
            ->assertSee('tidak ditemukan');
    }

    public function test_blank_query_returns_no_results(): void
    {
        Book::factory()->count(3)->create();

        Livewire::test(BookTracker::class)
            ->set('query', '')
            ->call('search')
            ->assertDontSee('Tahap saat ini');
    }
}
