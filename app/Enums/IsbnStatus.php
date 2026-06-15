<?php

namespace App\Enums;

enum IsbnStatus: string
{
    case Pengajuan = 'pengajuan';
    case Terbit = 'terbit';

    public function label(): string
    {
        return match ($this) {
            self::Pengajuan => 'Pengajuan ISBN',
            self::Terbit => 'Terbit',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->label()])
            ->all();
    }
}
