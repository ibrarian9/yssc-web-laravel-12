<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class AnggotaDevisi extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('anggota')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Anggota \"{$this->nama}\" {$event}");
    }
    protected $table = 'anggota_devisi';

    protected $fillable = [
        'divisi_id',
        'nama',
        'jabatan',
        'foto',
        'bio',
        'linkedin',
        'instagram',
        'email',
        'periode_mulai',
        'periode_selesai',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'periode_mulai' => 'date',
            'periode_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // ── Relationships ────────────────────────

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
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
