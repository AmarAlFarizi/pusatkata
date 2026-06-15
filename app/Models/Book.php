<?php

namespace App\Models;

use App\Enums\IsbnStatus;
use App\Enums\ProductionStage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category_id',
        'isbn_status',
        'isbn_number',
        'production_stage',
        'stage_updated_at',
        'cover',
        'synopsis',
        'year',
        'pages',
        'price',
        'marketplace_url',
        'is_featured',
    ];

    protected $casts = [
        'isbn_status' => IsbnStatus::class,
        'production_stage' => ProductionStage::class,
        'stage_updated_at' => 'datetime',
        'is_featured' => 'boolean',
        'year' => 'integer',
        'pages' => 'integer',
        'price' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isPublished(): bool
    {
        return $this->isbn_status === IsbnStatus::Terbit;
    }

    /**
     * Tujuan tombol beli: marketplace bila ada, jika tidak fallback ke WhatsApp.
     */
    public function buyUrl(?string $whatsappNumber): ?string
    {
        if (filled($this->marketplace_url)) {
            return $this->marketplace_url;
        }

        if (blank($whatsappNumber)) {
            return null;
        }

        $number = preg_replace('/\D+/', '', $whatsappNumber);
        $isbn = filled($this->isbn_number) ? " (ISBN: {$this->isbn_number})" : '';
        $message = "Halo, saya tertarik dengan buku \"{$this->title}\"{$isbn}.";

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }

    public function buysViaMarketplace(): bool
    {
        return filled($this->marketplace_url);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Pencarian berdasarkan judul, penulis, atau ISBN.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        return $query->where(function (Builder $query) use ($term) {
            $query->where('title', 'like', "%{$term}%")
                ->orWhere('author', 'like', "%{$term}%")
                ->orWhere('isbn_number', 'like', "%{$term}%");
        });
    }

    protected static function booted(): void
    {
        static::saving(function (Book $book) {
            if (blank($book->slug) && filled($book->title)) {
                $book->slug = static::uniqueSlug($book->title, $book->id);
            }

            // Catat waktu saat tahap produksi berubah.
            if ($book->isDirty('production_stage')) {
                $book->stage_updated_at = now();
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . (++$suffix);
        }

        return $slug;
    }
}
