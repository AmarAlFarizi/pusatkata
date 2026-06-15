<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin Filament.
        User::updateOrCreate(
            ['email' => 'admin@penerbit.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // Pengaturan situs.
        SiteSetting::current()->update([
            'hero_title' => 'Menerbitkan Karya, Menyebarkan Gagasan',
            'hero_subtitle' => 'Penerbit buku ber-ISBN tepercaya. Jelajahi katalog kami atau terbitkan karya Anda bersama kami.',
            'about_content' => '<p>Kami adalah penerbit buku ber-ISBN yang berkomitmen menghadirkan karya berkualitas bagi pembaca Indonesia.</p>',
            'services_content' => '<p>Kami menyediakan jasa penerbitan buku ber-ISBN, mulai dari penyuntingan, tata letak, hingga pengurusan ISBN.</p><ul><li>Pengurusan ISBN</li><li>Penyuntingan naskah</li><li>Desain sampul & tata letak</li></ul>',
            'contact_address' => 'Jl. Pustaka No. 123, Jakarta',
            'contact_email' => 'halo@penerbit.test',
            'contact_phone' => '(021) 123-4567',
            'whatsapp_number' => '6281234567890',
            'social_instagram' => 'https://instagram.com/penerbit',
        ]);

        // Kategori + buku contoh.
        $categories = Category::factory()->count(4)->create();

        Book::factory()
            ->count(18)
            ->recycle($categories)
            ->create();

        Book::factory()
            ->count(4)
            ->featured()
            ->published()
            ->recycle($categories)
            ->create();

        // Artikel.
        Post::factory()->count(6)->published()->create();
        Post::factory()->count(2)->draft()->create();
    }
}
