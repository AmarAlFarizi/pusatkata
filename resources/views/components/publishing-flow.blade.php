@php
    $steps = [
        [
            'no' => '01',
            'title' => 'Registrasi & Pengiriman Naskah',
            'desc' => 'Penulis melakukan administrasi pendaftaran, mengisi media order, serta mengirimkan naskah dan dokumen pendukung kepada penerbit.',
            'points' => [],
        ],
        [
            'no' => '02',
            'title' => 'Penyuntingan & Persetujuan',
            'desc' => 'Naskah disiapkan hingga benar-benar layak terbit, lalu dikonfirmasi kepada penulis.',
            'points' => [
                'Naskah Siap Terbit — dilakukan pengecekan akhir (proofreading).',
                'Naskah Konversi — tim redaksi melakukan editing hingga naskah siap diterbitkan, kemudian hasil revisi dikonfirmasi ke penulis untuk persetujuan (ACC).',
            ],
        ],
        [
            'no' => '03',
            'title' => 'Desain & Produksi',
            'desc' => 'Tim redaksi mengerjakan layout isi dan desain cover. Setelah disetujui penulis, penerbit mengajukan ISBN dan menyiapkan spesifikasi cetak.',
            'points' => [],
        ],
        [
            'no' => '04',
            'title' => 'Cetak & Publikasi',
            'desc' => 'Buku dicetak dan dikirim kepada penulis, kemudian dipasarkan melalui berbagai kanal distribusi penerbit.',
            'points' => [],
        ],
    ];
@endphp

<div class="overflow-clip bg-canvas">
    {{-- Intro --}}
    <div class="mx-auto max-w-7xl px-6 pt-20 lg:pt-24" data-reveal>
        <p class="eyebrow mb-3">Alur Penerbitan</p>
        <h2 class="font-display text-3xl font-medium text-ink sm:text-4xl lg:text-5xl">Empat langkah dari naskah menjadi buku</h2>
        <div class="mt-6 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-body-mid pb-5">
            @foreach (['Registrasi & Pengiriman', 'Editing / Proofreading', 'Desain & Produksi', 'Cetak & Publikasi'] as $k => $chip)
                @if ($k > 0)
                    <span class="text-primary">&rarr;</span>
                @endif
                <span class="rounded-full bg-canvas-soft px-3 py-1 font-medium text-ink">{{ $chip }}</span>
            @endforeach
        </div>
    </div>

    {{-- Sticky sections --}}
    @foreach ($steps as $i => $step)
        @php $alt = $i % 2 === 1; @endphp
        <section class="relative overflow-clip {{ $alt ? 'bg-canvas-soft' : 'bg-canvas' }}">
            {{-- Header menempel di bawah navbar (top-16 = tinggi navbar) --}}
            <div class="sticky top-16 z-10 -mt-px border-y border-ink/10 {{ $alt ? 'bg-canvas-soft' : 'bg-canvas' }}">
                <div class="mx-auto flex max-w-7xl items-center gap-4 px-6 py-5">
                    <span class="font-display text-xl font-semibold text-primary">{{ $step['no'] }}</span>
                    <span class="h-5 w-px bg-ink/15"></span>
                    <h3 class="my-0 font-display text-xl font-medium leading-none text-ink md:text-2xl lg:text-3xl">{{ $step['title'] }}</h3>
                </div>
            </div>

            {{-- Konten --}}
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 lg:grid-cols-[1fr_auto] lg:py-24">
                <div class="max-w-2xl">
                    <p class="text-lg leading-relaxed text-body lg:text-xl">{{ $step['desc'] }}</p>

                    @if (! empty($step['points']))
                        <ul class="mt-6 space-y-4">
                            @foreach ($step['points'] as $point)
                                <li class="flex gap-3">
                                    <span class="mt-1 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-primary/15 text-primary">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0L3.3 9.7a1 1 0 011.4-1.4l3.1 3.1 6.8-6.8a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                                    </span>
                                    <span class="text-body">{{ $point }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- Nomor besar dekoratif --}}
                <div class="hidden select-none items-start lg:flex" aria-hidden="true">
                    <span class="font-display text-[10rem] font-semibold leading-none text-ink/5">{{ $step['no'] }}</span>
                </div>
            </div>
        </section>
    @endforeach
</div>
