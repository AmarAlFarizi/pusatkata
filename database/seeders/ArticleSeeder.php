<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan artikel lama (mis. hasil factory) agar tampil 6 artikel ini saja.
        Post::query()->delete();

        $img = fn (string $id) => "https://images.unsplash.com/photo-{$id}?q=80&w=1200&auto=format&fit=crop";

        $articles = [
            [
                'title' => 'Panduan Lengkap Mengurus ISBN untuk Buku Anda',
                'cover' => $img('1455390582262-044cdead277a'),
                'excerpt' => 'Apa itu ISBN, mengapa penting, dan bagaimana proses pengajuannya untuk buku yang akan Anda terbitkan.',
                'body' => '<p>ISBN (International Standard Book Number) adalah kode unik yang menjadi identitas resmi sebuah buku. Dengan ISBN, buku Anda terdaftar secara nasional dan lebih mudah didistribusikan ke toko buku maupun perpustakaan.</p>'
                    . '<h2>Mengapa ISBN penting?</h2>'
                    . '<ul><li>Menjadi identitas resmi dan sah sebuah terbitan.</li><li>Memudahkan distribusi dan pencatatan di toko buku.</li><li>Meningkatkan kredibilitas karya Anda.</li></ul>'
                    . '<p>Sebagai penerbit, kami membantu seluruh proses pengajuan ISBN sehingga Anda tidak perlu repot mengurus administrasinya sendiri.</p>',
            ],
            [
                'title' => '5 Tips Menyiapkan Naskah Sebelum Dikirim ke Penerbit',
                'cover' => $img('1519682337058-a94d519337bc'),
                'excerpt' => 'Naskah yang rapi mempercepat proses penerbitan. Berikut hal-hal yang perlu Anda siapkan sebelum mengirim naskah.',
                'body' => '<p>Sebelum mengirim naskah, ada baiknya Anda memastikan beberapa hal agar proses penerbitan berjalan lancar dan cepat.</p>'
                    . '<ol><li>Rapikan format dokumen (judul, bab, dan penomoran halaman).</li><li>Periksa ejaan dan tata bahasa dasar.</li><li>Lengkapi data penulis dan sinopsis singkat.</li><li>Pastikan seluruh bagian naskah sudah final.</li><li>Siapkan dokumen pendukung yang diminta penerbit.</li></ol>'
                    . '<p>Naskah yang siap akan lebih cepat masuk ke tahap penyuntingan dan produksi.</p>',
            ],
            [
                'title' => 'Mengenal Tahapan Proses Penerbitan Buku',
                'cover' => $img('1524995997946-a1c2e315a42f'),
                'excerpt' => 'Dari registrasi naskah hingga buku dicetak dan dipasarkan — kenali setiap tahap penerbitan.',
                'body' => '<p>Banyak penulis penasaran, apa saja yang terjadi setelah naskah dikirim? Secara umum, proses penerbitan melewati empat tahap utama.</p>'
                    . '<h2>Empat tahap penerbitan</h2>'
                    . '<ul><li><strong>Registrasi &amp; pengiriman naskah</strong> — administrasi dan penerimaan naskah.</li><li><strong>Penyuntingan &amp; persetujuan</strong> — editing/proofreading hingga disetujui penulis.</li><li><strong>Desain &amp; produksi</strong> — layout isi, desain cover, dan pengajuan ISBN.</li><li><strong>Cetak &amp; publikasi</strong> — buku dicetak, dikirim, dan dipasarkan.</li></ul>'
                    . '<p>Anda dapat memantau posisi naskah Anda kapan saja melalui fitur Lacak Naskah di situs kami.</p>',
            ],
            [
                'title' => 'Penerbitan Mandiri vs Penerbit Tradisional: Mana yang Tepat?',
                'cover' => $img('1497633762265-9d179a990aa6'),
                'excerpt' => 'Memahami perbedaan, kelebihan, dan kekurangan dua jalur penerbitan agar Anda bisa memilih dengan bijak.',
                'body' => '<p>Setiap penulis punya kebutuhan berbeda. Memahami perbedaan kedua jalur ini membantu Anda memilih yang paling sesuai.</p>'
                    . '<h2>Penerbitan mandiri</h2><p>Memberi kontrol penuh atas isi, desain, dan jadwal, namun penulis menanggung lebih banyak proses dan biaya produksi.</p>'
                    . '<h2>Penerbit tradisional</h2><p>Penerbit membantu penyuntingan, desain, ISBN, hingga distribusi, sehingga penulis bisa lebih fokus pada karya.</p>'
                    . '<p>Apa pun pilihan Anda, yang terpenting adalah karya terbit dengan kualitas yang baik.</p>',
            ],
            [
                'title' => 'Pentingnya Penyuntingan: Mengubah Naskah Biasa Jadi Luar Biasa',
                'cover' => $img('1507842217343-583bb7270b66'),
                'excerpt' => 'Penyuntingan bukan sekadar memperbaiki ejaan — ia menyempurnakan alur, kejelasan, dan kenyamanan membaca.',
                'body' => '<p>Penyuntingan adalah salah satu tahap paling menentukan kualitas sebuah buku. Editor membantu memastikan pesan Anda tersampaikan dengan jelas.</p>'
                    . '<ul><li>Memperbaiki ejaan dan tata bahasa.</li><li>Menyempurnakan struktur dan alur tulisan.</li><li>Menjaga konsistensi gaya dan istilah.</li></ul>'
                    . '<p>Dengan penyuntingan yang baik, naskah biasa pun bisa menjelma menjadi buku yang nyaman dan enak dibaca.</p>',
            ],
            [
                'title' => 'Strategi Memasarkan Buku di Era Digital',
                'cover' => $img('1481627834876-b7833e8f5570'),
                'excerpt' => 'Setelah buku terbit, tantangan berikutnya adalah menjangkau pembaca. Berikut strategi pemasaran yang relevan.',
                'body' => '<p>Buku yang baik perlu dikenal pembaca. Di era digital, ada banyak cara menjangkau audiens secara efektif.</p>'
                    . '<ol><li>Manfaatkan media sosial untuk membangun cerita di balik buku.</li><li>Sediakan buku di marketplace yang mudah diakses.</li><li>Libatkan komunitas pembaca dan ulasan.</li><li>Adakan peluncuran atau bedah buku, baik daring maupun luring.</li></ol>'
                    . '<p>Pemasaran yang konsisten membantu buku Anda menemukan pembacanya.</p>',
            ],
        ];

        foreach ($articles as $i => $article) {
            Post::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'cover' => $article['cover'],
                'excerpt' => $article['excerpt'],
                'body' => $article['body'],
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(($i + 1) * 3),
            ]);
        }
    }
}
