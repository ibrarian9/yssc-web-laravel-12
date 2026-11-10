<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class DokumenLegal extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('dokumen')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Dokumen Legal \"{$this->nama}\" {$event}");
    }
    protected $table = 'dokumen_legal';

    protected $fillable = [
        'nama',
        'nomor',
        'tanggal_terbit',
        'jenis',
        'file_path',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_terbit' => 'date',
            'is_public' => 'boolean',
        ];
    }
}
