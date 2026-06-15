<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static string $view = 'filament.pages.manage-site-settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Pengaturan')
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Beranda')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Section::make('Logo & Identitas')
                                    ->description('Logo tampil di navbar dan footer. Jika kosong, dipakai inisial + nama situs.')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo')
                                            ->label('Logo')
                                            ->image()
                                            ->directory('site')
                                            ->imageEditor()
                                            ->helperText('Disarankan PNG transparan, tinggi ± 64px. Logo memanjang (landscape) paling pas.'),

                                        Forms\Components\FileUpload::make('logo_footer')
                                            ->label('Logo Footer (opsional)')
                                            ->image()
                                            ->directory('site')
                                            ->imageEditor()
                                            ->helperText('Khusus footer yang berlatar gelap — pakai versi logo terang/putih. Jika kosong, footer memakai logo utama.'),
                                    ]),

                                Forms\Components\Section::make('Hero Section')
                                    ->description('Teks Beranda')
                                    ->icon('heroicon-o-sparkles')
                                    ->columns(1)
                                    ->schema([
                                        Forms\Components\TextInput::make('hero_title')
                                            ->label('Judul Hero')
                                            ->placeholder('Menerbitkan karya, satu naskah satu cerita')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('hero_subtitle')
                                            ->label('Subjudul Hero')
                                            ->placeholder('Dari naskah hingga buku ber-ISBN di tangan pembaca...')
                                            ->rows(2)
                                            ->maxLength(255),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Tentang Kami')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Halaman Tentang Kami')
                                    ->description('Tampil di halaman /tentang.')
                                    ->schema([
                                        Forms\Components\RichEditor::make('about_content')
                                            ->label('Konten Tentang Kami')
                                            ->hiddenLabel(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Layanan')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Forms\Components\Section::make('Halaman Layanan Penerbitan')
                                    ->description('Tampil di halaman /layanan.')
                                    ->schema([
                                        Forms\Components\RichEditor::make('services_content')
                                            ->label('Konten Layanan')
                                            ->hiddenLabel(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Kontak & Sosial')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\Section::make('Info Kontak')
                                    ->description('Tampil di footer (semua halaman) dan halaman Kontak.')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\Textarea::make('contact_address')
                                            ->label('Alamat')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        Forms\Components\TextInput::make('contact_email')
                                            ->label('Email')
                                            ->email(),
                                        Forms\Components\TextInput::make('contact_phone')
                                            ->label('Telepon'),
                                    ]),

                                Forms\Components\Section::make('WhatsApp')
                                    ->description('Dipakai untuk tombol "Beli via WhatsApp" di detail buku (saat link marketplace kosong) dan tombol Chat WhatsApp.')
                                    ->schema([
                                        Forms\Components\TextInput::make('whatsapp_number')
                                            ->label('Nomor WhatsApp')
                                            ->placeholder('6281234567890')
                                            ->helperText('Format internasional tanpa tanda +, spasi, atau strip. Contoh: 6281234567890.'),
                                    ]),

                                Forms\Components\Section::make('Media Sosial')
                                    ->description('Tautan di footer. Kosongkan bila tidak ada.')
                                    ->columns(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('social_instagram')
                                            ->label('Instagram')
                                            ->placeholder('https://instagram.com/...')
                                            ->url(),
                                        Forms\Components\TextInput::make('social_facebook')
                                            ->label('Facebook')
                                            ->placeholder('https://facebook.com/...')
                                            ->url(),
                                        Forms\Components\TextInput::make('social_twitter')
                                            ->label('Twitter / X')
                                            ->placeholder('https://x.com/...')
                                            ->url(),
                                    ]),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Pengaturan disimpan')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Simpan')
                ->submit('save'),
        ];
    }
}
