<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class BookCatalog extends Component
{
    use WithPagination;

    #[Url(as: 'q', keep: false)]
    public string $search = '';

    #[Url(as: 'kategori', keep: false)]
    public ?string $category = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'category']);
        $this->resetPage();
    }

    public function render(): View
    {
        $books = Book::query()
            ->with('category')
            ->search($this->search)
            ->when($this->category, function ($query) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
            })
            ->latest()
            ->paginate(9);

        return view('livewire.book-catalog', [
            'books' => $books,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
