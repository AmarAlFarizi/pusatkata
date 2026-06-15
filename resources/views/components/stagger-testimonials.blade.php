@php
    // Data testimoni (sample — mudah diganti / nanti bisa dari admin).
    $testimonials = [
        ['testimonial' => 'Proses penerbitan cepat dan transparan. ISBN terbit tepat waktu.', 'by' => 'Andi Pratama, Dosen & Penulis'],
        ['testimonial' => 'Editornya sabar membimbing naskah pertama saya hingga layak terbit.', 'by' => 'Siti Marlina, Penulis Pemula'],
        ['testimonial' => 'Desain sampul dan tata letaknya rapi, hasilnya terlihat profesional.', 'by' => 'Budi Santoso, Komunitas Literasi'],
        ['testimonial' => 'Sangat membantu menerbitkan buku ajar dengan kualitas yang baik.', 'by' => 'Dewi Lestari, Guru'],
        ['testimonial' => 'Pendampingan dari awal sampai distribusi membuat saya tenang.', 'by' => 'Fajar Nugroho, Peneliti'],
        ['testimonial' => 'Komunikatif dan hasil cetaknya memuaskan. Pasti kembali lagi.', 'by' => 'Maya Anggraini, Penulis Fiksi'],
        ['testimonial' => 'Tim yang andal. Buku antologi komunitas kami terbit mulus.', 'by' => 'Rendi Saputra, Editor Komunitas'],
        ['testimonial' => 'Dari naskah berantakan jadi buku yang membanggakan. Terima kasih!', 'by' => 'Nadia Rahma, Penulis'],
    ];

    $cards = collect($testimonials)->values()->map(function ($t, $i) {
        $name = trim(explode(',', $t['by'])[0]);
        $initials = collect(explode(' ', $name))
            ->filter()
            ->take(2)
            ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->implode('');

        return [
            'tempId' => $i,
            'testimonial' => $t['testimonial'],
            'by' => $t['by'],
            'initials' => $initials,
            'imgSrc' => null, // isi dengan URL/foto asli bila tersedia
        ];
    });
@endphp

<div
    x-data='{
        list: @json($cards),
        cardSize: 365,
        setSize() { this.cardSize = window.matchMedia("(min-width: 640px)").matches ? 365 : 290; },
        position(index) {
            return this.list.length % 2
                ? index - (this.list.length + 1) / 2
                : index - this.list.length / 2;
        },
        handleMove(steps) {
            const newList = [...this.list];
            if (steps > 0) {
                for (let i = steps; i > 0; i--) {
                    const item = newList.shift();
                    if (!item) return;
                    newList.push({ ...item, tempId: Math.random() });
                }
            } else {
                for (let i = steps; i < 0; i++) {
                    const item = newList.pop();
                    if (!item) return;
                    newList.unshift({ ...item, tempId: Math.random() });
                }
            }
            this.list = newList;
        }
    }'
    x-init="setSize(); window.addEventListener('resize', () => setSize())"
    class="relative w-full overflow-hidden bg-canvas-soft h-[540px] sm:h-[600px]"
>
    <template x-for="(t, index) in list" :key="t.tempId">
        <div
            @click="handleMove(position(index))"
            :class="position(index) === 0
                ? 'z-10 bg-primary text-on-primary border-primary'
                : 'z-0 bg-canvas text-ink border-ink/15 hover:border-primary/50'"
            class="absolute left-1/2 top-1/2 cursor-pointer border-2 p-8 transition-all duration-500 ease-in-out"
            :style="`
                width: ${cardSize}px;
                height: ${cardSize}px;
                clip-path: polygon(50px 0%, calc(100% - 50px) 0%, 100% 50px, 100% 100%, calc(100% - 50px) 100%, 50px 100%, 0 100%, 0 0);
                transform: translate(-50%, -50%)
                    translateX(${(cardSize / 1.5) * position(index)}px)
                    translateY(${position(index) === 0 ? -65 : (position(index) % 2 ? 15 : -15)}px)
                    rotate(${position(index) === 0 ? 0 : (position(index) % 2 ? 2.5 : -2.5)}deg);
                box-shadow: ${position(index) === 0 ? '0px 8px 0px 4px #e7e1d6' : '0px 0px 0px 0px transparent'};
            `"
        >
            {{-- Garis aksen diagonal --}}
            <span class="absolute block origin-top-right rotate-45 bg-ink/15"
                  style="right: -2px; top: 48px; width: 70.71px; height: 2px;"></span>

            {{-- Avatar: foto asli bila ada, jika tidak tampilkan inisial --}}
            <template x-if="t.imgSrc">
                <img :src="t.imgSrc" :alt="t.by"
                     class="mb-4 h-14 w-12 bg-canvas-soft object-cover object-top"
                     style="box-shadow: 3px 3px 0px #e7e1d6;">
            </template>
            <template x-if="!t.imgSrc">
                <div class="mb-4 flex h-14 w-12 items-center justify-center font-display text-lg font-semibold"
                     :class="position(index) === 0 ? 'bg-on-primary text-primary' : 'bg-ink text-on-primary'"
                     style="box-shadow: 3px 3px 0px #e7e1d6;"
                     x-text="t.initials"></div>
            </template>

            <h3 class="text-base font-medium sm:text-xl"
                :class="position(index) === 0 ? 'text-on-primary' : 'text-ink'"
                x-text="'“' + t.testimonial + '”'"></h3>

            <p class="absolute bottom-8 left-8 right-8 mt-2 text-sm italic"
               :class="position(index) === 0 ? 'text-on-primary/80' : 'text-body-mid'"
               x-text="'— ' + t.by"></p>
        </div>
    </template>

    {{-- Tombol navigasi --}}
    <div class="absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 gap-2">
        <button @click="handleMove(-1)" aria-label="Testimoni sebelumnya"
                class="flex h-14 w-14 items-center justify-center border-2 border-ink/20 bg-canvas text-ink transition hover:bg-primary hover:text-on-primary hover:border-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <button @click="handleMove(1)" aria-label="Testimoni berikutnya"
                class="flex h-14 w-14 items-center justify-center border-2 border-ink/20 bg-canvas text-ink transition hover:bg-primary hover:text-on-primary hover:border-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>
    </div>
</div>
