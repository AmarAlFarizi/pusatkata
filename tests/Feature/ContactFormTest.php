<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_submission_is_stored(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Budi')
            ->set('phone', '08123456789')
            ->set('message', 'Saya ingin menerbitkan buku.')
            ->call('submit')
            ->assertSet('sent', true)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi',
            'phone' => '08123456789',
            'is_read' => false,
        ]);
    }

    public function test_validation_errors_are_shown(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '')
            ->set('phone', '')
            ->set('message', '')
            ->call('submit')
            ->assertHasErrors(['name', 'phone', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_honeypot_blocks_bot_submission(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Bot')
            ->set('phone', '08123456789')
            ->set('message', 'spam')
            ->set('website', 'http://spam.example')
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
