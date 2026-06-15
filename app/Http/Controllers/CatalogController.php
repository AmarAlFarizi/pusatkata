<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CatalogController extends Controller
{
    public function index()
    {
        return view('catalog.index');
    }

    public function show(Book $book)
    {
        $book->load('category');

        $relatedBooks = Book::where('id', '!=', $book->id)
            ->when($book->category_id, fn ($query) => $query->where('category_id', $book->category_id))
            ->latest()
            ->take(4)
            ->get();

        return view('catalog.show', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
        ]);
    }
}
