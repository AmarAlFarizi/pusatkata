# PRD: Website Company Profile Penerbit Buku ber-ISBN

Tanggal: 2026-06-13
Status: Draft
Dokumen terkait: `2026-06-13-web-penerbit-design.md` (design spec teknis)

## 1. Latar Belakang & Masalah

Penerbit buku ber-ISBN membutuhkan kehadiran online yang kredibel untuk
memperkenalkan perusahaan, memamerkan buku terbitannya, dan menawarkan jasa
penerbitan kepada calon penulis. Saat ini belum ada kanal terpusat yang:
- Menampilkan profil dan layanan penerbit secara profesional.
- Menyajikan katalog buku yang mudah dijelajahi.
- Mengarahkan calon pembeli ke kanal penjualan (marketplace/WhatsApp).

## 2. Tujuan Produk

- Membangun citra profesional penerbit lewat website company profile.
- Memudahkan pengunjung menemukan dan mengeksplorasi buku terbitan.
- Mengarahkan minat beli ke marketplace atau WhatsApp tanpa proses transaksi
  di website.
- Mendapatkan prospek lewat layanan penerbitan dan form kontak.
- Memberi admin kontrol penuh atas konten tanpa perlu ngoding.

### Non-Tujuan (Out of Scope)
- Transaksi e-commerce (keranjang, checkout, pembayaran, stok).
- Multi-bahasa.
- Aplikasi SPA / framework JS terpisah.

## 3. Target Pengguna

| Persona | Kebutuhan |
|---------|-----------|
| Pembaca/pembeli | Menemukan buku, membaca sinopsis, menuju kanal beli |
| Calon penulis | Memahami layanan penerbitan & menghubungi penerbit |
| Mitra/umum | Mengetahui profil & kredibilitas penerbit |
| Admin penerbit | Mengelola buku, artikel, pesan, dan konten situs |

## 4. User Stories

### Pengunjung
- Sebagai pengunjung, saya ingin melihat buku unggulan & terbaru di beranda.
- Sebagai pengunjung, saya ingin menelusuri katalog dan memfilter berdasarkan
  kategori serta mencari berdasarkan judul/penulis/ISBN.
- Sebagai pengunjung, saya ingin membuka detail buku (cover, sinopsis, ISBN,
  harga) dan menuju tombol beli.
- Sebagai calon penulis, saya ingin membaca layanan penerbitan dan mengirim
  pesan lewat form kontak.
- Sebagai pengunjung, saya ingin membaca berita/artikel penerbit.

### Admin
- Sebagai admin, saya ingin menambah/ubah/hapus buku beserta status ISBN.
- Sebagai admin, saya ingin mengelola kategori, artikel, dan konten halaman.
- Sebagai admin, saya ingin melihat pesan masuk dari form kontak.

## 5. Kebutuhan Fungsional

### F1 — Beranda
Menampilkan hero, buku unggulan, artikel terbaru, dan form kontak.

### F2 — Katalog Buku
Daftar buku dengan filter kategori dan pencarian live (judul/penulis/ISBN).

### F3 — Detail Buku
Menampilkan cover, penulis, kategori, status & nomor ISBN, sinopsis, tahun,
jumlah halaman, harga. Tombol beli mengarah ke `marketplace_url`; bila kosong,
fallback ke WhatsApp admin dengan pesan otomatis (judul + ISBN).

### F4 — Tentang Kami
Halaman profil penerbit; konten dikelola admin.

### F5 — Layanan Penerbitan
Halaman layanan (mis. jasa penerbitan ISBN); konten dikelola admin.

### F6 — Berita/Blog
Daftar dan detail artikel; hanya artikel berstatus `published` yang tampil.

### F7 — Kontak
Halaman kontak berisi form (nama, email, telepon, pesan) + info kontak.
Form juga tersedia di beranda. Validasi server-side + proteksi spam (honeypot).

### F8 — Admin (Filament)
CRUD Buku, Kategori, Artikel; pengelolaan Pesan Kontak (view + tandai dibaca);
halaman tunggal Site Settings (Tentang, Layanan, hero Beranda, info kontak,
nomor WA fallback). Slug buku/artikel auto dari judul namun dapat diedit.
Nomor ISBN wajib hanya saat status `terbit`.

## 6. Kebutuhan Non-Fungsional

- **Teknologi:** Laravel + Filament (admin), Blade + Tailwind + Livewire +
  Alpine.js (frontend), MySQL.
- **SEO:** Server-rendered; URL bersih berbasis slug; meta dasar tiap halaman.
- **Responsif:** Tampil baik di mobile & desktop.
- **Keamanan:** Validasi input, proteksi CSRF (bawaan Laravel), honeypot anti
  spam, panel admin terproteksi autentikasi.
- **Maintainability:** Satu sumber data Eloquent untuk admin & publik;
  komponen Blade/Livewire terpisah dan fokus.
- **Performa:** Halaman publik ringan tanpa overhead SPA.

## 7. Kriteria Sukses

- Semua halaman publik dapat diakses dan menampilkan data dengan benar.
- Pengunjung dapat memfilter & mencari buku, lalu menuju kanal beli yang tepat.
- Admin dapat mengelola seluruh konten tanpa bantuan developer.
- Pesan dari form kontak tersimpan dan terlihat oleh admin.

## 8. Asumsi & Batasan

- Pembelian terjadi di luar website (marketplace/WhatsApp).
- Satu bahasa (Indonesia).
- Konten awal (buku, artikel, profil) disiapkan oleh admin penerbit.
