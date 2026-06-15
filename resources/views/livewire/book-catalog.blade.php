<div>
    <div class="mb-8 grid gap-4 rounded-xl bg-canvas-soft p-5 sm:grid-cols-[1fr_auto] sm:items-end">
        <div>
            <label for="catalog-search" class="mb-1.5 block text-sm font-semibold text-ink">Cari buku</label>
            <input id="catalog-search" type="search" wire:model.live.debounce.400ms="search"
                   placeholder="Judul, penulis, atau ISBN..." class="field bg-canvas">
        </div>
        <div class="sm:w-56">
            <label for="catalog-category" class="mb-1.5 block text-sm font-semibold text-ink">Kategori</label>
            <select id="catalog-category" wire:model.live="category" class="field bg-canvas">
                <option value="">Semua kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($search !== '' || $category)
        <div class="mb-5 flex items-center gap-3 text-sm text-body">
            <span>{{ $books->total() }} hasil ditemukan</span>
            <button wire:click="clearFilters" class="font-bold text-ink hover:text-primary">Reset filter</button>
        </div>
    @endif

    <div wire:loading.class="opacity-50" class="transition">
        @if ($books->isEmpty())
            <div class="rounded-xl bg-canvas-soft p-12 text-center text-body-mid">
                Tidak ada buku yang cocok dengan pencarian Anda.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($books as $book)
                    <x-book-card :book="$book" />
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-10">
        {{ $books->links() }}
    </div>
</div>
