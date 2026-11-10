<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class HeroSection extends Model
{
    use LogsActivity;

    protected $table = 'hero_sections';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('hero-section')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges()
            ->setDescriptionForEvent(fn (string $event) => "Hero Banner \"{$this->page_name}\" {$event}");
    }

    protected static array $memo = [];

    protected $fillable = [
        'page_key',
        'page_name',
        'route_name',
        'judul',
        'subjudul',
        'gambar',
        'overlay_opacity',
        'is_active',
    ];

    protected $casts = [
        'overlay_opacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public static array $defaultPages = [
        'berita' => [
            'page_name' => 'Berita',
            'route_name' => 'berita.index',
            'judul' => 'Berita & Informasi',
            'subjudul' => 'Ikuti perkembangan terbaru dan artikel seputar program yayasan kami',
        ],
        'kegiatan' => [
            'page_name' => 'Kegiatan',
            'route_name' => 'kegiatan.index',
            'judul' => 'Kegiatan Yayasan',
            'subjudul' => 'Dokumentasi kegiatan dan aksi nyata yayasan di lapangan',
        ],
        'profil' => [
            'page_name' => 'Profil Yayasan',
            'route_name' => 'profil.index',
            'judul' => 'Profil Organisasi',
            'subjudul' => 'Bersama membangun masa depan yang lebih baik',
        ],
        'anggota' => [
            'page_name' => 'Struktur Anggota',
            'route_name' => 'anggota.index',
            'judul' => 'Struktur Anggota & Divisi',
            'subjudul' => 'Mengenal tim dan pengurus yang berdedikasi di balik setiap program kebaikan yayasan',
        ],
        'donasi' => [
            'page_name' => 'Program Donasi',
            'route_name' => 'donasi.index',
            'judul' => 'Salurkan Kebaikan Anda',
            'subjudul' => 'Setiap donasi Anda adalah harapan baru bagi masa depan mereka yang membutuhkan',
        ],
        'mitra' => [
            'page_name' => 'Mitra & Kolaborasi',
            'route_name' => 'mitra.index',
            'judul' => 'Kemitraan & Kolaborasi',
            'subjudul' => 'Bersama-sama menciptakan dampak yang lebih besar melalui kemitraan strategis',
        ],
        'relawan' => [
            'page_name' => 'Relawan',
            'route_name' => 'relawan.index',
            'judul' => 'Bergabung Menjadi Relawan',
            'subjudul' => 'Ambil bagian dalam aksi nyata. Jadilah jembatan harapan untuk sesama yang membutuhkan',
        ],
        'perizinan' => [
            'page_name' => 'Layanan Perizinan',
            'route_name' => 'perizinan.form',
            'judul' => 'Layanan Perizinan',
            'subjudul' => 'Pengajuan izin kegiatan, kerja sama, dan permohonan surat rekomendasi resmi',
        ],
    ];

    protected static function booted(): void
    {
        static::saved(function (self $hero) {
            unset(static::$memo[$hero->page_key]);
            Cache::forget("hero_section_{$hero->page_key}");
        });
        static::deleted(function (self $hero) {
            unset(static::$memo[$hero->page_key]);
            Cache::forget("hero_section_{$hero->page_key}");
        });
    }

    /**
     * Get or create hero configuration for a page key.
     */
    public static function getHero(string $pageKey): ?self
    {
        if (array_key_exists($pageKey, static::$memo)) {
            return static::$memo[$pageKey];
        }

        return static::$memo[$pageKey] = Cache::remember("hero_section_{$pageKey}", 3600, function () use ($pageKey) {
            $hero = static::where('page_key', $pageKey)->first();

            if (!$hero && isset(static::$defaultPages[$pageKey])) {
                $def = static::$defaultPages[$pageKey];
                $hero = static::create([
                    'page_key' => $pageKey,
                    'page_name' => $def['page_name'],
                    'route_name' => $def['route_name'],
                    'judul' => $def['judul'],
                    'subjudul' => $def['subjudul'],
                    'overlay_opacity' => 60,
                    'is_active' => true,
                ]);
            }

            return $hero;
        });
    }

    /**
     * Seed all default pages if missing.
     */
    public static function syncDefaults(): void
    {
        foreach (static::$defaultPages as $key => $def) {
            static::firstOrCreate(
                ['page_key' => $key],
                [
                    'page_name' => $def['page_name'],
                    'route_name' => $def['route_name'],
                    'judul' => $def['judul'],
                    'subjudul' => $def['subjudul'],
                    'overlay_opacity' => 60,
                    'is_active' => true,
                ]
            );
        }
    }
}

