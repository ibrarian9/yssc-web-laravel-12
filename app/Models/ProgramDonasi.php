<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramDonasi extends Model
{
    use SoftDeletes;

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
                $program->slug = Str::slug($program->judul);
                $count = static::withTrashed()->where('slug', $program->slug)->count();
                if ($count > 0) {
                    $program->slug .= '-' . ($count + 1);
                }
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
        return max(0, $diff);
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
