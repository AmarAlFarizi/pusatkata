@props([
    'items' => [],
    'direction' => 'left',   // 'left' | 'right'
    'duration' => '32s',
])

{{-- Marquee teks berjalan (CSS murni, jeda saat di-hover) --}}
<div {{ $attributes->merge(['class' => 'marquee-mask relative flex w-full max-w-[100vw] flex-nowrap overflow-hidden']) }}>
    <div class="marquee-track {{ $direction === 'right' ? 'marquee-reverse' : '' }} items-center"
         style="animation-duration: {{ $duration }};">
        {{-- Dua salinan agar loop mulus --}}
        @for ($copy = 0; $copy < 2; $copy++)
            @foreach ($items as $item)
                <span class="me-10 flex items-center gap-10 whitespace-nowrap font-display text-3xl font-bold uppercase tracking-tight sm:text-4xl lg:text-5xl">
                    {{ $item }}
                    <svg class="h-4 w-4 shrink-0 opacity-60" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.5 7.5H22l-6 4.5 2.3 7.5L12 17l-6.3 4.5L8 14 2 9.5h7.5z"/></svg>
                </span>
            @endforeach
        @endfor
    </div>
</div>
