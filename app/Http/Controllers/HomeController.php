<?php

namespace App\Http\Controllers;

use App\Enums\IsbnStatus;
use App\Models\Book;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::featured()
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        // Cadangan bila belum ada buku unggulan: pakai buku terbaru.
        if ($featuredBooks->isEmpty()) {
            $featuredBooks = Book::with('category')->latest()->take(6)->get();
        }

        $latestPosts = Post::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Buku untuk galeri carousel di bawah hero.
        $galleryBooks = Book::with('category')
            ->latest()
            ->take(8)
            ->get();

        $stats = [
            'published' => Book::where('isbn_status', IsbnStatus::Terbit->value)->count(),
            'titles' => Book::count(),
            'categories' => Category::count(),
        ];

        return view('home', [
            'featuredBooks' => $featuredBooks,
            'latestPosts' => $latestPosts,
            'galleryBooks' => $galleryBooks,
            'stats' => $stats,
        ]);
    }
}
