<?php

namespace App\Models;

use App\Support\UniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ProgramDonasi extends Model
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('program-donasi')
            ->logOnly(['judul', 'target_nominal', 'status', 'is_mendesak', 'tanggal_mulai', 'tanggal_selesai', 'mitra_id'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Program Donasi \"{$this->judul}\" {$event}");
    }

    protected $table = 'program_donasi';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'thumbnail',
        'target_nominal',
        'terkumpul_nominal',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'is_mendesak',
        'urutan',
        'mitra_id',
    ];

    protected function casts(): array
    {
        return [
            'target_nominal' => 'decimal:2',
            'terkumpul_nominal' => 'decimal:2',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_mendesak' => 'boolean',
        ];
    }

    // ── Boot ─────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = UniqueSlug::generate(static::class, (string) $program->judul, withTrashed: true);
            }
        });
    }

    // ── Relationships ────────────────────────

    public function donasi()
    {
        return $this->hasMany(Donasi::class);
    }

    public function donasiSuccess()
    {
        return $this->hasMany(Donasi::class)->where('status_pembayaran', 'success');
    }

    // ── Scopes ───────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    // ── Computed ─────────────────────────────

    public function getPersentaseAttribute(): float
    {
        if ($this->target_nominal <= 0) return 0;
        return min(100, round(($this->terkumpul_nominal / $this->target_nominal) * 100, 1));
    }

    public function getSisaHariAttribute(): ?int
    {
        if (!$this->tanggal_selesai) return null;
        $diff = now()->diffInDays($this->tanggal_selesai, false);
        return (int) max(0, $diff);
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

    public function getJumlahDonaturAttribute(): int
    {
        return $this->donasiSuccess()->count();
    }

    public function updateTerkumpul(): void
    {
        $this->terkumpul_nominal = $this->donasiSuccess()->sum('nominal');
        $this->save();
    }
}
