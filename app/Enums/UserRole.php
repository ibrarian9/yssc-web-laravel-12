<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'superadmin';
    case Admin = 'admin';
    case Mitra = 'mitra';
    case Member = 'member';
    case Guest = 'guest';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::Mitra => 'Mitra',
            self::Member => 'Member',
            self::Guest => 'Guest',
        };
    }

    public function isAdmin(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Admin]);
    }

    public function isMitra(): bool
    {
        return $this === self::Mitra;
    }
}
