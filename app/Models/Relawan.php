<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Relawan extends Model
{
    use LogsActivity;

    protected $table = 'relawan';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('relawan')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Relawan \"{$this->nama}\" {$event}");
    }

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'pekerjaan',
        'motivasi',
        'keahlian',
        'foto',
        'status',
        'catatan_admin',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ──

    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeRejected($query) { return $query->where('status', 'rejected'); }

    // ── Helpers ──

    public function isPending(): bool { return $this->status === 'pending'; }
    public function isApproved(): bool { return $this->status === 'approved'; }
}
