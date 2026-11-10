<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Profile extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('profil')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Profil Organisasi {$event}");
    }
    protected $table = 'profile';

    protected static ?self $cachedInstance = null;
    protected static bool $hasFetchedCache = false;

    protected $fillable = [
        'nama_organisasi',
        'tagline',
        'deskripsi',
        'is_donasi_enabled',
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
            'is_donasi_enabled' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }

    public static function getCached(): ?self
    {
        if (static::$hasFetchedCache) {
            return static::$cachedInstance;
        }

        static::$hasFetchedCache = true;
        static::$cachedInstance = Cache::remember('site_profile', 3600, fn () => static::first());

        return static::$cachedInstance;
    }

    public static function clearCache(): void
    {
        static::$cachedInstance = null;
        static::$hasFetchedCache = false;
        Cache::forget('site_profile');
    }
}
