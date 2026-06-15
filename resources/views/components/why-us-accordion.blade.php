@php
    $features = [
        [
            'id' => 1,
            'title' => 'Pengurusan ISBN Resmi',
            'description' => 'Kami mengurus pendaftaran ISBN secara resmi dan terdaftar, sehingga buku Anda sah dan diakui secara nasional.',
            'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=1080&auto=format&fit=crop',
        ],
        [
            'id' => 2,
            'title' => 'Penyuntingan oleh Editor Berpengalaman',
            'description' => 'Naskah Anda disunting oleh editor berpengalaman — dari ejaan, struktur, hingga keterbacaan — agar siap diterbitkan dengan kualitas terbaik.',
            'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?q=80&w=1080&auto=format&fit=crop',
        ],
        [
            'id' => 3,
            'title' => 'Desain Sampul & Tata Letak Profesional',
            'description' => 'Tim desain kami menyiapkan sampul menarik dan tata letak isi yang rapi serta nyaman dibaca, sesuai karakter buku Anda.',
            'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1080&auto=format&fit=crop',
        ],
        [
            'id' => 4,
            'title' => 'Pendampingan dari Naskah hingga Terbit',
            'description' => 'Anda tidak sendirian. Kami mendampingi setiap tahap — dari naskah mentah, proses produksi, hingga buku terbit dan dipasarkan.',
            'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1080&auto=format&fit=crop',
        ],
    ];
    $first = $features[0];
@endphp

<section class="bg-canvas-soft">
    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-24"
         x-data="{ active: {{ $first['id'] }}, image: @js($first['image']) }">

        <div class="mb-10 max-w-2xl" data-reveal>
            <p class="eyebrow mb-3">Mengapa Kami</p>
            <h2 class="font-display text-3xl font-medium text-ink sm:text-4xl">Alasan penulis memilih kami</h2>
        </div>

        <div class="flex w-full items-start justify-between gap-12">
            {{-- Accordion --}}
            <div class="w-full md:w-1/2" data-reveal>
                @foreach ($features as $f)
                    <div class="border-b border-ink/10">
                        <button type="button"
                                @click="active === {{ $f['id'] }} ? active = null : (active = {{ $f['id'] }}, image = @js($f['image']))"
                                class="flex w-full cursor-pointer items-center justify-between gap-4 py-5 text-left">
                            <h6 class="font-display text-lg font-semibold transition-colors sm:text-xl"
                                :class="active === {{ $f['id'] }} ? 'text-ink' : 'text-body-mid'">
                                {{ $f['title'] }}
                            </h6>
                            <svg class="h-5 w-5 shrink-0 text-ink transition-transform duration-200"
                                 :class="active === {{ $f['id'] }} ? 'rotate-180' : ''"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>

                        {{-- Konten (animasi buka-tutup via grid-rows) --}}
                        <div class="grid transition-all duration-300 ease-in-out"
                             :class="active === {{ $f['id'] }} ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                            <div class="overflow-hidden">
                                <p class="pb-5 text-body">{{ $f['description'] }}</p>
                                {{-- Gambar inline untuk mobile --}}
                                <div class="mb-5 md:hidden">
                                    <img src="{{ $f['image'] }}" alt="{{ $f['title'] }}"
                                         class="max-h-72 w-full rounded-xl object-cover"
                                         onerror="this.onerror=null;this.src='https://placehold.co/800x600/f8f4f0/201515?text=Penerbit';">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Preview gambar (desktop) --}}
            <div class="relative m-auto hidden w-1/2 overflow-hidden rounded-xl bg-canvas md:block" data-reveal style="--reveal-delay: 120ms">
                <img :src="image" alt="Pratinjau keunggulan"
                     class="aspect-[4/3] w-full rounded-xl object-cover transition-opacity duration-300"
                     onerror="this.onerror=null;this.src='https://placehold.co/800x600/f8f4f0/201515?text=Penerbit';">
            </div>
        </div>
    </div>
</section>
