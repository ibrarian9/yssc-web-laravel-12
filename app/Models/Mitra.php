<?php

namespace App\Models;

use App\Enums\JenisMitra;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';

    protected $fillable = [
        'user_id',
        'jenis_mitra',
        'nama_perusahaan',
        'email',
        'telepon',
        'npwp',
        'dokumen_npwp',
        'dokumen_legalitas',
        'logo',
        'deskripsi',
        'status',
        'catatan_admin',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'jenis_mitra' => JenisMitra::class,
            'approved_at' => 'datetime',
        ];
    }

    // ── Relationships ──

    public function user() { return $this->belongsTo(\App\Models\User::class); }

    // ── Scopes ──

    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeRejected($query) { return $query->where('status', 'rejected'); }

    // ── Helpers ──

    public function isPending(): bool { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
}
