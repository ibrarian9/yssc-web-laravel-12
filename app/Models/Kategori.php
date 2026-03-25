<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'slug',
        'warna',
    ];

    // ── Boot ─────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });
    }

    // ── Relationships ────────────────────────

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}
