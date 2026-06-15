@php $stages = \App\Enums\ProductionStage::ordered(); @endphp

<div>
    {{-- Form pencarian (gaya cek resi) --}}
    <form wire:submit="search" class="rounded-xl bg-canvas-soft p-5 sm:p-6">
        <label for="track-q" class="mb-1.5 block text-sm font-semibold text-ink">Judul Buku / Naskah</label>
        <div class="flex flex-col gap-3 sm:flex-row">
            <input id="track-q" type="search" wire:model="query"
                   placeholder="Masukkan judul naskah, mis. Belajar Laravel..."
                   class="field bg-canvas">
            <button type="submit" class="btn-primary shrink-0" wire:loading.attr="disabled" wire:target="search">
                <span wire:loading.remove wire:target="search">Lacak</span>
                <span wire:loading wire:target="search">Mencari...</span>
            </button>
        </div>
        <p class="mt-2 text-sm text-body-mid">Cari berdasarkan judul untuk melihat tahap produksi naskah Anda.</p>
    </form>

    {{-- Hasil --}}
    <div class="mt-8 space-y-6">
        @if ($searched && $results->isEmpty())
            <div class="rounded-xl border border-dashed border-ink/20 p-10 text-center text-body-mid">
                Naskah dengan judul itu tidak ditemukan. Periksa kembali ejaan judulnya, atau hubungi admin kami.
            </div>
        @endif

        @foreach ($results as $book)
            @php $current = $book->production_stage->order(); @endphp
            <article class="rounded-xl bg-canvas ring-1 ring-ink/10 p-6 sm:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-ink/10 pb-5">
                    <div>
                        @if ($book->category)
                            <span class="eyebrow">{{ $book->category->name }}</span>
                        @endif
                        <h3 class="mt-1 font-display text-xl font-semibold text-ink">{{ $book->title }}</h3>
                        <p class="text-sm text-body-mid">oleh {{ $book->author }}</p>
                    </div>
                    <div class="text-right">
                        <span class="badge-pill !bg-primary/10 !text-primary">{{ $book->production_stage->label() }}</span>
                        @if ($book->stage_updated_at)
                            <p class="mt-1 text-xs text-body-mid">Diperbarui {{ $book->stage_updated_at->translatedFormat('d M Y') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Timeline tahapan --}}
                <ol class="mt-6 space-y-0">
                    @foreach ($stages as $stage)
                        @php
                            $order = $stage->order();
                            $done = $order < $current;
                            $now = $order === $current;
                            $last = $loop->last;
                        @endphp
                        <li class="relative flex gap-4 pb-8 last:pb-0">
                            {{-- Garis penghubung --}}
                            @unless ($last)
                                <span class="absolute left-[15px] top-8 h-[calc(100%-2rem)] w-px {{ $done ? 'bg-primary' : 'bg-ink/15' }}"></span>
                            @endunless

                            {{-- Bulatan --}}
                            <span @class([
                                'relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full ring-4',
                                'bg-primary text-on-primary ring-primary/15' => $done,
                                'bg-primary text-on-primary ring-primary/25 animate-pulse' => $now,
                                'bg-canvas-soft text-body-mid ring-canvas' => ! $done && ! $now,
                            ])>
                                @if ($done)
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0L3.3 9.7a1 1 0 011.4-1.4l3.1 3.1 6.8-6.8a1 1 0 011.4 0z" clip-rule="evenodd"/></svg>
                                @else
                                    <span class="text-sm font-semibold">{{ $order }}</span>
                                @endif
                            </span>

                            <div class="pt-1">
                                <p @class([
                                    'font-semibold',
                                    'text-ink' => $done || $now,
                                    'text-body-mid' => ! $done && ! $now,
                                ])>
                                    {{ $stage->label() }}
                                    @if ($now)
                                        <span class="ml-2 rounded-full bg-primary px-2 py-0.5 text-xs font-medium text-on-primary align-middle">Tahap saat ini</span>
                                    @endif
                                </p>
                                <p class="mt-0.5 text-sm text-body">{{ $stage->description() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </article>
        @endforeach
    </div>
</div>
