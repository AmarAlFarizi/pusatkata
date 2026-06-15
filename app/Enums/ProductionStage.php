<?php

namespace App\Enums;

enum ProductionStage: string
{
    case Registrasi = 'registrasi';
    case Penyuntingan = 'penyuntingan';
    case Desain = 'desain';
    case Cetak = 'cetak';

    public function label(): string
    {
        return match ($this) {
            self::Registrasi => 'Registrasi & Pengiriman Naskah',
            self::Penyuntingan => 'Penyuntingan & Persetujuan',
            self::Desain => 'Desain & Produksi',
            self::Cetak => 'Cetak & Publikasi',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Registrasi => 'Naskah dan dokumen pendukung diterima penerbit.',
            self::Penyuntingan => 'Naskah disunting / proofreading hingga disetujui penulis (ACC).',
            self::Desain => 'Layout isi & desain cover dikerjakan, ISBN diajukan.',
            self::Cetak => 'Buku dicetak, dikirim, dan dipasarkan.',
        };
    }

    /**
     * Urutan tahap (1-based) untuk timeline.
     */
    public function order(): int
    {
        return match ($this) {
            self::Registrasi => 1,
            self::Penyuntingan => 2,
            self::Desain => 3,
            self::Cetak => 4,
        };
    }

    /**
     * @return array<int, self> Tahap berurutan.
     */
    public static function ordered(): array
    {
        return [self::Registrasi, self::Penyuntingan, self::Desain, self::Cetak];
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::ordered())
            ->mapWithKeys(fn (self $s) => [$s->value => $s->order() . '. ' . $s->label()])
            ->all();
    }
}
