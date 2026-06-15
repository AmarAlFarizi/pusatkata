<div>
    @if ($sent)
        <div class="mb-5 rounded-xl bg-primary/10 px-4 py-3 text-ink">
            Terima kasih! Pesan Anda sudah kami terima dan akan segera ditindaklanjuti.
        </div>
    @endif

    <form wire:submit="submit" class="space-y-4">
        {{-- Honeypot: disembunyikan dari pengguna --}}
        <div class="hidden" aria-hidden="true">
            <label>Website
                <input type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </label>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="cf-name" class="mb-1.5 block text-sm font-semibold text-ink">Nama Lengkap</label>
                <input id="cf-name" type="text" wire:model="name" class="field">
                @error('name') <p class="mt-1 text-sm text-primary">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="cf-phone" class="mb-1.5 block text-sm font-semibold text-ink">WhatsApp</label>
                <input id="cf-phone" type="text" wire:model="phone" placeholder="08xxxxxxxxxx" class="field">
                @error('phone') <p class="mt-1 text-sm text-primary">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="cf-message" class="mb-1.5 block text-sm font-semibold text-ink">Pesan</label>
            <textarea id="cf-message" rows="5" wire:model="message" class="field"></textarea>
            @error('message') <p class="mt-1 text-sm text-primary">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto disabled:opacity-60" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Kirim Pesan</span>
            <span wire:loading wire:target="submit">Mengirim...</span>
        </button>
    </form>
</div>
