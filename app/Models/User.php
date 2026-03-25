<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    // ── Helpers ──────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role->isAdmin();
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SuperAdmin;
    }

    // ── Relationships ────────────────────────

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class);
    }

    public function perizinan()
    {
        return $this->hasMany(Perizinan::class);
    }

    public function processedPerizinan()
    {
        return $this->hasMany(Perizinan::class, 'processed_by');
    }
}
