<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Perizinan extends Model
{
    use LogsActivity;

    protected $table = 'perizinan';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('perizinan')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Perizinan \"{$this->judul_permohonan}\" {$event}");
    }

    protected $fillable = [
        'user_id',
        'nama_pemohon',
        'email_pemohon',
        'phone_pemohon',
        'jenis_izin',
        'judul_permohonan',
        'deskripsi',
        'dokumen_pendukung',
        'status',
        'catatan_admin',
        'tanggal_permohonan',
        'tanggal_proses',
        'processed_by',
    ];

    protected function casts(): array
    {
        return [
            'dokumen_pendukung' => 'array',
            'tanggal_permohonan' => 'date',
            'tanggal_proses' => 'date',
        ];
    }

    // ── Relationships ────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // ── Scopes ───────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
