<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo',
        'logo_footer',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'about_content',
        'services_content',
        'contact_address',
        'contact_email',
        'contact_phone',
        'whatsapp_number',
        'social_instagram',
        'social_facebook',
        'social_twitter',
    ];

    /**
     * Ambil satu-satunya baris pengaturan (buat bila belum ada).
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
