# Website Penerbit Buku ber-ISBN

Company profile + katalog buku untuk penerbit. Backend admin memakai **Filament**,
frontend publik memakai **Blade + Tailwind + Livewire + Alpine.js**.

Spec & PRD ada di `docs/superpowers/specs/`.

## Stack

- Laravel 12 (PHP 8.2+)
- Filament 3 (panel admin di `/admin`)
- Livewire 3 + Alpine.js
- Tailwind CSS 4 (Vite)
- MySQL / MariaDB

## Fitur

- Beranda (hero, buku unggulan, berita terbaru, form kontak)
- Katalog buku dengan filter kategori + pencarian live (judul/penulis/ISBN)
- Detail buku dengan tombol beli: link marketplace, fallback ke WhatsApp
- Status ISBN: Pengajuan / Terbit (nomor ISBN wajib saat Terbit)
- Halaman Tentang Kami, Layanan Penerbitan (konten dikelola dari admin)
- Berita/Blog (hanya artikel `published` yang tampil)
- Halaman Kontak + form (validasi server-side + honeypot anti-spam)
- Admin Filament: CRUD Buku, Kategori, Artikel; kelola Pesan Kontak; Pengaturan Situs

## Menjalankan

1. Pastikan MySQL aktif (mis. via XAMPP) dan database `web_penerbit` ada.
   Konfigurasi koneksi ada di `.env`.

2. Install dependency & siapkan database:

   ```bash
   composer install
   npm install
   php artisan migrate --seed
   php artisan storage:link
   ```

3. Build aset frontend (atau `npm run dev` saat pengembangan):

   ```bash
   npm run build
   ```

4. Jalankan server:

   ```bash
   php artisan serve
   ```

   Situs: http://127.0.0.1:8000 · Admin: http://127.0.0.1:8000/admin

## Akun admin (hasil seeder)

- Email: `admin@penerbit.test`
- Password: `password`

## Pengujian

```bash
php artisan test
```
