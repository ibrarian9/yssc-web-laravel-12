<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Donasi extends Model
{
    protected $table = 'donasi';

    protected $fillable = [
        'program_donasi_id',
        'user_id',
        'nama_donatur',
        'email_donatur',
        'phone',
        'nominal',
        'pesan',
        'is_anonim',
        'metode_pembayaran',
        'status_pembayaran',
        'kode_unik',
        'bukti_transfer',
        'midtrans_order_id',
        'midtrans_snap_token',
        'midtrans_payment_type',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'is_anonim' => 'boolean',
            'paid_at' => 'datetime',
        ];
    }

    // ── Boot ─────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($donasi) {
            if (empty($donasi->kode_unik)) {
                $donasi->kode_unik = 'DON-' . strtoupper(Str::random(8)) . '-' . time();
            }
        });
    }

    // ── Relationships ────────────────────────

    public function program()
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ───────────────────────────────

    public function scopeSuccess($query)
    {
        return $query->where('status_pembayaran', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status_pembayaran', 'pending');
    }

    // ── Helpers ──────────────────────────────

    public function getNamaTampilAttribute(): string
    {
        if ($this->is_anonim) {
            return 'Anonim';
        }
        return $this->nama_donatur;
    }
}
