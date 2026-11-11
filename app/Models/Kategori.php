<?php

namespace App\Models;

use App\Support\UniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Kategori extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('kategori')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Kategori \"{$this->nama}\" {$event}");
    }
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
                $kategori->slug = UniqueSlug::generate(static::class, (string) $kategori->nama);
            }
        });
    }

    // ── Relationships ────────────────────────

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}
