<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(9);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post)
    {
        // Artikel draf / belum waktunya terbit tidak boleh diakses publik.
        if (! Post::published()->whereKey($post->getKey())->exists()) {
            throw new NotFoundHttpException();
        }

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
