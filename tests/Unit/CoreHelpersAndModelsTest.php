<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\Berita;
use App\Models\HeroSection;
use App\Models\Kategori;
use App\Models\Profile;
use App\Models\ProgramDonasi;
use App\Models\User;
use App\Support\UniqueSlug;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CoreHelpersAndModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_role_enum_helpers_return_expected_flags_and_labels(): void
    {
        $this->assertTrue(UserRole::SuperAdmin->isAdmin());
        $this->assertTrue(UserRole::Admin->isAdmin());
        $this->assertFalse(UserRole::Mitra->isAdmin());
        $this->assertFalse(UserRole::Member->isAdmin());
        $this->assertFalse(UserRole::Guest->isAdmin());

        $this->assertTrue(UserRole::Mitra->isMitra());
        $this->assertFalse(UserRole::Admin->isMitra());

        $this->assertSame('Super Admin', UserRole::SuperAdmin->label());
        $this->assertSame('Admin', UserRole::Admin->label());
        $this->assertSame('Mitra', UserRole::Mitra->label());
        $this->assertSame('Member', UserRole::Member->label());
        $this->assertSame('Guest', UserRole::Guest->label());
    }

    public function test_unique_slug_handles_duplicates_soft_deletes_and_empty_input(): void
    {
        $author = User::create([
            'name' => 'Author Test',
            'email' => 'author@yssc.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
        ]);

        $first = Kategori::create(['nama' => 'Pendidikan Anak', 'warna' => '#0d9488']);
        $this->assertSame('pendidikan-anak', $first->slug);

        $second = Kategori::create(['nama' => 'Pendidikan Anak', 'warna' => '#0d9488']);
        $this->assertSame('pendidikan-anak-2', $second->slug);

        $third = Kategori::create(['nama' => 'Pendidikan Anak', 'warna' => '#0d9488']);
        $this->assertSame('pendidikan-anak-3', $third->slug);

        // Editing self should ignore own id cleanly
        $this->assertSame('pendidikan-anak-2', UniqueSlug::generate(Kategori::class, 'Pendidikan Anak', $second->id));

        // Empty / symbol-only falls back to 'item'
        $this->assertSame('item', UniqueSlug::generate(Kategori::class, '!!!'));

        // Soft-deleted Berita slugs remain reserved when withTrashed = true
        $berita1 = Berita::create([
            'judul' => 'Program Literasi Desa',
            'konten' => 'Konten',
            'user_id' => $author->id,
            'tipe' => 'berita',
            'status' => 'published',
        ]);
        $this->assertSame('program-literasi-desa', $berita1->slug);
        $berita1->delete();

        $berita2 = Berita::create([
            'judul' => 'Program Literasi Desa',
            'konten' => 'Konten',
            'user_id' => $author->id,
            'tipe' => 'berita',
            'status' => 'published',
        ]);
        $this->assertSame('program-literasi-desa-2', $berita2->slug);
    }

    public function test_thumbnail_url_accessors_handle_null_http_and_local_storage_paths(): void
    {
        $beritaNull = new Berita(['thumbnail' => null]);
        $beritaExternal = new Berita(['thumbnail' => 'https://example.com/photo.jpg']);
        $beritaLocal = new Berita(['thumbnail' => 'berita/local.jpg']);

        $this->assertNull($beritaNull->thumbnail_url);
        $this->assertSame('https://example.com/photo.jpg', $beritaExternal->thumbnail_url);
        $this->assertSame(asset('storage/berita/local.jpg'), $beritaLocal->thumbnail_url);

        $programNull = new ProgramDonasi(['thumbnail' => null]);
        $programExternal = new ProgramDonasi(['thumbnail' => 'http://example.com/campaign.png']);
        $programLocal = new ProgramDonasi(['thumbnail' => 'program-donasi/campaign.png']);

        $this->assertNull($programNull->thumbnail_url);
        $this->assertSame('http://example.com/campaign.png', $programExternal->thumbnail_url);
        $this->assertSame(asset('storage/program-donasi/campaign.png'), $programLocal->thumbnail_url);
    }

    public function test_program_donasi_computed_persentase_and_integer_sisa_hari(): void
    {
        $this->travelTo(now()->startOfDay());

        $program = new ProgramDonasi([
            'target_nominal' => 1000000,
            'terkumpul_nominal' => 1500000,
            'tanggal_selesai' => now()->addDays(5),
        ]);

        // Persentase is capped at 100%
        $this->assertSame(100.0, $program->persentase);
        $this->assertIsInt($program->sisa_hari);
        $this->assertSame(5, $program->sisa_hari);

        $pastProgram = new ProgramDonasi([
            'target_nominal' => 0,
            'terkumpul_nominal' => 50000,
            'tanggal_selesai' => now()->subDays(3),
        ]);

        $this->assertSame(0.0, $pastProgram->persentase);
        $this->assertSame(0, $pastProgram->sisa_hari);
    }

    public function test_profile_and_hero_section_cache_invalidate_on_save(): void
    {
        $profile = Profile::create([
            'nama_organisasi' => 'YSSC Awal',
            'is_donasi_enabled' => true,
        ]);

        $this->assertTrue(Profile::getCached()->is_donasi_enabled);

        $profile->update(['is_donasi_enabled' => false, 'nama_organisasi' => 'YSSC Baru']);
        $cachedProfile = Profile::getCached();
        $this->assertFalse($cachedProfile->is_donasi_enabled);
        $this->assertSame('YSSC Baru', $cachedProfile->nama_organisasi);

        $hero = HeroSection::getHero('berita');
        $this->assertNotNull($hero);
        $this->assertSame('Berita & Informasi', $hero->judul);

        $hero->update(['judul' => 'Judul Berita Updated']);
        $this->assertSame('Judul Berita Updated', HeroSection::getHero('berita')->judul);
    }
}
