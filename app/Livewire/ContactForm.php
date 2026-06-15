<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:50')]
    public string $phone = '';

    #[Validate('required|string|max:2000')]
    public string $message = '';

    /**
     * Honeypot — harus tetap kosong. Bila terisi, kemungkinan bot.
     */
    public string $website = '';

    public bool $sent = false;

    public function submit(): void
    {
        // Honeypot: diam-diam abaikan submission yang mencurigakan.
        if (filled($this->website)) {
            $this->reset(['name', 'phone', 'message', 'website']);
            $this->sent = true;

            return;
        }

        $validated = $this->validate();

        ContactMessage::create($validated);

        $this->reset(['name', 'phone', 'message']);
        $this->sent = true;
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
