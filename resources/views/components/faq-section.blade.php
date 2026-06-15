@php
    $faqs = [
        [
            'q' => 'Berapa lama proses penerbitan sebuah buku?',
            'a' => '30 Hari Kerja bergantung kondisi naskah. Naskah yang sudah siap terbit umumnya lebih cepat karena hanya melalui proofreading, sedangkan naskah yang perlu penyuntingan menyeluruh memerlukan waktu lebih lama. Estimasi waktu akan kami sampaikan setelah naskah ditinjau.',
        ],
        [
            'q' => 'Apakah penerbit mengurus ISBN?',
            'a' => 'Ya. Kami mengurus pengajuan ISBN secara resmi dan terdaftar untuk buku Anda, sehingga buku sah dan diakui secara nasional.',
        ],
        [
            'q' => 'Bagaimana cara memantau progres naskah saya?',
            'a' => 'Gunakan menu "Lacak Naskah" di situs ini. Cukup masukkan judul naskah, lalu Anda dapat melihat naskah sedang berada di tahap mana — seperti melacak resi.',
        ],
        [
            'q' => 'Format naskah apa yang diterima?',
            'a' => 'Umumnya naskah dikirim dalam format dokumen (mis. Microsoft Word/DOCX) beserta dokumen pendukung. Ketentuan lengkap akan dijelaskan saat registrasi dan pengisian media order.',
        ],
        [
            'q' => 'Apakah hak cipta tetap milik penulis?',
            'a' => 'Ya, hak cipta karya tetap menjadi milik penulis. Penerbit membantu proses produksi, penerbitan, dan distribusi sesuai kesepakatan.',
        ],
        [
            'q' => 'Bagaimana cara membeli buku yang sudah terbit?',
            'a' => 'Pada halaman detail buku tersedia tautan pembelian melalui marketplace. Jika belum tersedia, Anda dapat menghubungi kami langsung melalui WhatsApp.',
        ],
    ];
@endphp

<section class="bg-canvas-soft py-20 lg:py-24" x-data="{ open: 0 }">
    <div class="mx-auto max-w-3xl px-6">
        <div class="text-center" data-reveal>
            <p class="eyebrow mb-3">FAQ</p>
            <h2 class="font-display text-3xl font-medium text-ink sm:text-4xl">Pertanyaan yang sering diajukan</h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-body">Jawaban ringkas seputar layanan penerbitan, ISBN, dan proses naskah kami.</p>
        </div>

        <div class="mt-12 overflow-hidden rounded-xl bg-canvas ring-1 ring-ink/10" data-reveal>
            @foreach ($faqs as $i => $faq)
                <div class="border-b border-ink/10 last:border-b-0">
                    <button type="button"
                            @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                            class="flex w-full cursor-pointer items-center justify-between gap-4 px-6 py-5 text-left md:px-8">
                        <span class="font-display text-base font-semibold text-ink sm:text-lg">{{ $faq['q'] }}</span>
                        <svg class="h-5 w-5 shrink-0 text-primary transition-transform duration-200"
                             :class="open === {{ $i }} ? 'rotate-180' : ''"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="grid transition-all duration-300 ease-in-out"
                         :class="open === {{ $i }} ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                        <div class="overflow-hidden">
                            <p class="px-6 pb-5 text-body md:px-8">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="mt-6 text-center text-body-mid">
            Tidak menemukan jawaban?
            <a href="{{ route('contact') }}" class="font-semibold text-primary hover:underline">Hubungi tim kami</a>.
        </p>
    </div>
</section>
