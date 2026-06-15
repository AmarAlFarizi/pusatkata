<?php

namespace App\Filament\Resources;

use App\Enums\IsbnStatus;
use App\Filament\Resources\BookResource\Pages;
use App\Enums\ProductionStage;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Katalog';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Buku';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Buku')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Set $set) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug((string) $state));
                            }
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->helperText('Otomatis dari judul, bisa diubah.')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('author')
                        ->label('Penulis')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, Set $set) => $set('slug', Str::slug((string) $state))),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique(table: 'categories', column: 'slug'),
                        ]),
                ]),

            Forms\Components\Section::make('Status ISBN')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('isbn_status')
                        ->label('Status ISBN')
                        ->options(IsbnStatus::options())
                        ->default(IsbnStatus::Pengajuan->value)
                        ->required()
                        ->live(),

                    Forms\Components\TextInput::make('isbn_number')
                        ->label('Nomor ISBN')
                        ->maxLength(255)
                        ->visible(fn (Get $get): bool => $get('isbn_status') === IsbnStatus::Terbit->value)
                        ->required(fn (Get $get): bool => $get('isbn_status') === IsbnStatus::Terbit->value),
                ]),

            Forms\Components\Section::make('Pelacakan Produksi')
                ->description('Tahap ini ditampilkan ke pengunjung saat melacak naskah berdasarkan judul.')
                ->schema([
                    Forms\Components\Select::make('production_stage')
                        ->label('Tahap Produksi Saat Ini')
                        ->options(ProductionStage::options())
                        ->default(ProductionStage::Registrasi->value)
                        ->required()
                        ->native(false),
                ]),

            Forms\Components\Section::make('Detail & Tampilan')
                ->columns(2)
                ->schema([
                    Forms\Components\FileUpload::make('cover')
                        ->label('Sampul')
                        ->image()
                        ->directory('covers')
                        ->imageEditor()
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('synopsis')
                        ->label('Sinopsis')
                        ->rows(5)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('year')
                        ->label('Tahun Terbit')
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue((int) date('Y') + 1),

                    Forms\Components\TextInput::make('pages')
                        ->label('Jumlah Halaman')
                        ->numeric()
                        ->minValue(1),

                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->minValue(0),

                    Forms\Components\TextInput::make('marketplace_url')
                        ->label('Link Marketplace')
                        ->helperText('Kosongkan untuk memakai tombol WhatsApp.')
                        ->url()
                        ->maxLength(255),

                    Forms\Components\Toggle::make('is_featured')
                        ->label('Tampilkan sebagai buku unggulan')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Sampul')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('isbn_status')
                    ->label('Status ISBN')
                    ->badge()
                    ->formatStateUsing(fn (IsbnStatus $state): string => $state->label())
                    ->color(fn (IsbnStatus $state): string => $state === IsbnStatus::Terbit ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('production_stage')
                    ->label('Tahap Produksi')
                    ->badge()
                    ->formatStateUsing(fn (ProductionStage $state): string => $state->order() . '. ' . $state->label())
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),

                Tables\Filters\SelectFilter::make('isbn_status')
                    ->label('Status ISBN')
                    ->options(IsbnStatus::options()),

                Tables\Filters\SelectFilter::make('production_stage')
                    ->label('Tahap Produksi')
                    ->options(ProductionStage::options()),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Unggulan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
