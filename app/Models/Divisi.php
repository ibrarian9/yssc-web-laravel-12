<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisi';

    protected $fillable = [
        'nama',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ── Relationships ────────────────────────

    public function anggota()
    {
        return $this->hasMany(AnggotaDevisi::class);
    }

    public function anggotaAktif()
    {
        return $this->hasMany(AnggotaDevisi::class)->where('is_active', true)->orderBy('urutan');
    }

    // ── Scopes ───────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
