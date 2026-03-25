<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Berita extends Model
{
    use SoftDeletes;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'excerpt',
        'thumbnail',
        'kategori_id',
        'user_id',
        'tipe',
        'status',
        'tanggal_kegiatan',
        'lokasi',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
            'views' => 'integer',
        ];
    }

    // ── Boot ─────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
                // Ensure unique slug
                $count = static::withTrashed()->where('slug', $berita->slug)->count();
                if ($count > 0) {
                    $berita->slug .= '-' . ($count + 1);
                }
            }
        });
    }

    // ── Relationships ────────────────────────

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ── Scopes ───────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeBerita($query)
    {
        return $query->where('tipe', 'berita');
    }

    public function scopeKegiatan($query)
    {
        return $query->where('tipe', 'kegiatan');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('konten', 'like', "%{$search}%");
        });
    }

    // ── Helpers ──────────────────────────────

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getExcerptAttribute($value)
    {
        if ($value) return $value;
        return Str::limit(strip_tags($this->konten), 160);
    }
}
