<?php

namespace App\Enums;

enum JenisMitra: string
{
    case Perusahaan = 'perusahaan';
    case Organisasi = 'organisasi';
    case Perorangan = 'perorangan';
    case Lembaga = 'lembaga';

    public function label(): string
    {
        return match ($this) {
            self::Perusahaan => 'Perusahaan',
            self::Organisasi => 'Organisasi',
            self::Perorangan => 'Perorangan',
            self::Lembaga => 'Lembaga',
        };
    }
}
