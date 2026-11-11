<?php

namespace App\Models;

use App\Support\UniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Berita extends Model
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('berita')
            ->logOnly(['judul', 'tipe', 'status', 'kategori_id', 'tanggal_kegiatan', 'lokasi', 'thumbnail'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => ucfirst($this->tipe ?? 'berita') . " \"{$this->judul}\" {$event}");
    }

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
                $berita->slug = UniqueSlug::generate(static::class, (string) $berita->judul, withTrashed: true);
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

    public function getThumbnailUrlAttribute(): ?string
    {
        if (empty($this->thumbnail)) {
            return null;
        }

        return str_starts_with($this->thumbnail, 'http')
            ? $this->thumbnail
            : asset('storage/' . $this->thumbnail);
    }
}
