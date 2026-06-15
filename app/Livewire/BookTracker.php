<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class BookTracker extends Component
{
    #[Url(as: 'judul')]
    public string $query = '';

    public bool $searched = false;

    public function search(): void
    {
        $this->searched = true;
    }

    public function getResultsProperty(): Collection
    {
        $term = trim($this->query);

        if ($term === '') {
            return collect();
        }

        return Book::query()
            ->with('category')
            ->where('title', 'like', "%{$term}%")
            ->orderBy('title')
            ->limit(15)
            ->get();
    }

    public function mount(): void
    {
        // Bila datang dengan ?judul= dari URL, langsung tampilkan hasil.
        if (trim($this->query) !== '') {
            $this->searched = true;
        }
    }

    public function render(): View
    {
        return view('livewire.book-tracker', [
            'results' => $this->results,
        ]);
    }
}
