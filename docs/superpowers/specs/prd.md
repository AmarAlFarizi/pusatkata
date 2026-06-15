# Desain: Website Company Profile Penerbit Buku ber-ISBN

Tanggal: 2026-06-13
Status: Disetujui (menunggu review akhir spec)

## Ringkasan

Website company profile untuk penerbit buku ber-ISBN, dilengkapi katalog
produk (buku). Katalog bersifat **showcase**: pengunjung melihat detail buku,
dan pembelian diarahkan keluar lewat **link marketplace per buku** (Tokopedia/
Shopee/dll). Jika link marketplace kosong, tombol beli fallback ke **WhatsApp**
admin dengan pesan otomatis (judul + ISBN).

Seluruh konten dikelola lewat admin **Filament**. Frontend publik dibangun
dengan **Blade + Tailwind + Livewire + Alpine.js** (server-rendered, dengan
interaktivitas ringan pada katalog dan form kontak — tanpa SPA).

## Stack & Arsitektur

- **Backend/Admin:** Laravel + Filament (panel admin di `/admin`).
- **Frontend publik:** Laravel Blade + Tailwind CSS + Livewire + Alpine.js.
- **Database:** MySQL.
- Frontend dan admin berbagi model Eloquent yang sama (satu sumber data, dua
  tampilan). Filament untuk CRUD/kelola; Blade+Livewire untuk tampilan publik.
- Tidak ada SPA / Inertia. Livewire dipakai hanya untuk interaktivitas terbatas
  (filter & pencarian katalog live, submit form kontak tanpa pindah halaman).
  Pilihan ini konsisten dengan Filament yang juga berbasis Livewire + Alpine.

## Data Model

### books
- `id`
- `title` — judul buku
- `slug` — auto-generate dari judul, **bisa diedit manual**, unik
- `author` — penulis
- `category_id` — relasi ke categories
- `isbn_status` — enum: `pengajuan` | `terbit`
- `isbn_number` — nullable; hanya diisi/tampil bila `isbn_status = terbit`
- `cover` — path gambar (upload via Filament)
- `synopsis` — text (sinopsis/deskripsi)
- `year` — tahun terbit
- `pages` — jumlah halaman
- `price` — harga
- `marketplace_url` — nullable; tujuan tombol beli
- `is_featured` — boolean; tampil sebagai buku unggulan di Beranda
- timestamps

### categories
- `id`, `name`, `slug`, timestamps

### posts (Berita/Blog)
- `id`, `title`, `slug` (auto dari judul, editable, unik)
- `cover` — path gambar
- `excerpt` — ringkasan
- `body` — rich text
- `status` — draft | published
- `published_at` — nullable
- timestamps

### contact_messages
- `id`, `name`, `email`, `phone`, `message`
- `is_read` — boolean
- timestamps

### site_settings (singleton — Pendekatan 1)
Satu baris data, diedit lewat halaman tunggal di Filament.
- Konten **Tentang Kami** (rich text)
- Konten **Layanan Penerbitan** (rich text / daftar layanan)
- Teks **hero Beranda** (judul, subjudul, gambar/CTA)
- **Info kontak**: alamat, email, telepon, tautan sosial media
- **Nomor WhatsApp fallback** (untuk tombol beli bila marketplace_url kosong)

## Halaman & Route Publik

| Route | Halaman | Catatan |
|-------|---------|---------|
| `/` | Beranda | Hero, buku unggulan (`is_featured`), artikel terbaru, form kontak |
| `/tentang` | Tentang Kami | Konten dari site_settings |
| `/layanan` | Layanan Penerbitan | Konten dari site_settings |
| `/katalog` | Katalog Buku | Filter kategori + pencarian live (judul/penulis/ISBN) via Livewire |
| `/katalog/{slug}` | Detail Buku | Tombol beli: marketplace_url → fallback WA |
| `/berita` | Daftar Artikel | Hanya status `published` |
| `/berita/{slug}` | Detail Artikel | |
| `/kontak` | Kontak | Form kontak (Livewire) + info kontak dari site_settings |

### Tombol Beli (Detail Buku)
- Jika `marketplace_url` terisi → tombol mengarah ke marketplace.
- Jika kosong → tombol mengarah ke WhatsApp admin (`site_settings.wa_number`)
  dengan pesan otomatis berisi judul + nomor ISBN (bila ada).

## Admin (Filament)

Panel di `/admin`. Resource & halaman:
- **Books** — CRUD penuh; slug auto dari judul (editable); field `isbn_number`
  hanya muncul/divalidasi wajib saat `isbn_status = terbit`; upload cover;
  toggle `is_featured`.
- **Categories** — CRUD kategori buku.
- **Posts** — CRUD artikel berita/blog; editor rich text; status & published_at.
- **Contact Messages** — view-only; bisa menandai sudah dibaca; tidak dibuat
  manual dari admin.
- **Site Settings** — halaman edit tunggal (Tentang Kami, Layanan, hero Beranda,
  info kontak, nomor WA fallback).

## Penanganan Error & Aturan

- Slug buku/artikel harus unik; auto dari judul namun dapat diedit.
- `isbn_number` wajib hanya ketika `isbn_status = terbit`; disembunyikan saat
  `pengajuan`.
- Detail buku/artikel dengan slug tidak ditemukan → 404.
- Form kontak: validasi server-side (nama, email valid, pesan wajib) +
  proteksi spam sederhana (honeypot).
- Artikel berstatus `draft` tidak tampil di publik.

## Testing

Feature test (PHPUnit/Pest):
- Semua route publik merespons 200 dengan data tampil.
- Filter kategori dan pencarian katalog mengembalikan hasil yang benar.
- Tombol beli: marketplace_url ada → link marketplace; kosong → link WA.
- Submit form kontak menyimpan `contact_messages` dan validasi gagal sesuai.
- Slug unik tergenerate dari judul dan dapat di-override.
- `isbn_number` hanya wajib saat status `terbit`.

## Out of Scope (YAGNI)

- Keranjang belanja, checkout, pembayaran online, manajemen stok.
- Multi-bahasa.
- SPA / Inertia / framework JS terpisah.
- Page builder berbasis blok.
