<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenLegal extends Model
{
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
