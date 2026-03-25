<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';

    protected $fillable = [
        'nama_organisasi',
        'tagline',
        'deskripsi',
        'visi',
        'misi',
        'sejarah',
        'alamat',
        'email',
        'telepon',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'logo',
        'foto_kantor',
    ];

    protected function casts(): array
    {
        return [
            'misi' => 'array',
        ];
    }
}
