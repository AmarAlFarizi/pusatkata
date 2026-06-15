<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        // Halaman statis.
        foreach ([
            ['route' => 'home', 'freq' => 'weekly', 'priority' => '1.0'],
            ['route' => 'catalog.index', 'freq' => 'daily', 'priority' => '0.9'],
            ['route' => 'services', 'freq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'about', 'freq' => 'monthly', 'priority' => '0.6'],
            ['route' => 'posts.index', 'freq' => 'daily', 'priority' => '0.8'],
            ['route' => 'track', 'freq' => 'monthly', 'priority' => '0.6'],
            ['route' => 'contact', 'freq' => 'yearly', 'priority' => '0.5'],
        ] as $page) {
            $urls[] = [
                'loc' => route($page['route']),
                'changefreq' => $page['freq'],
                'priority' => $page['priority'],
            ];
        }

        // Buku.
        foreach (Book::query()->latest('updated_at')->get() as $book) {
            $urls[] = [
                'loc' => route('catalog.show', $book),
                'lastmod' => $book->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Artikel terbit.
        foreach (Post::published()->latest('published_at')->get() as $post) {
            $urls[] = [
                'loc' => route('posts.show', $post),
                'lastmod' => $post->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . e($url['loc']) . "</loc>\n";
            if (! empty($url['lastmod'])) {
                $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
            }
            $xml .= '    <changefreq>' . $url['changefreq'] . "</changefreq>\n";
            $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
