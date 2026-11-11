<?php

namespace Tests\Feature;

use App\Enums\JenisMitra;
use App\Enums\UserRole;
use App\Livewire\Admin\BeritaManager;
use App\Livewire\Admin\KategoriManager;
use App\Livewire\Admin\ProgramDonasiManager;
use App\Livewire\Mitra\MitraBeritaManager;
use App\Livewire\Mitra\MitraDashboard;
use App\Livewire\Mitra\MitraProgramManager;
use App\Livewire\PublicPages\MitraRegistrationForm;
use App\Models\AnggotaDevisi;
use App\Models\Berita;
use App\Models\Divisi;
use App\Models\Donasi;
use App\Models\Kategori;
use App\Models\Mitra;
use App\Models\Perizinan;
use App\Models\Profile;
use App\Models\ProgramDonasi;
use App\Models\Relawan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PublicAndMitraWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(UserRole $role, array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => $role->label() . ' User',
            'email' => $role->value . '.' . uniqid() . '@yssc.test',
            'password' => Hash::make('password'),
            'role' => $role,
            'is_active' => true,
            'must_change_password' => false,
            'email_verified_at' => now(),
        ], $overrides));
    }

    public function test_all_public_routes_render_successfully_and_home_stats_match_db_state(): void
    {
        Profile::create([
            'nama_organisasi' => 'Yayasan Seribu Satu Cita',
            'visi' => 'Menjadi yayasan sosial terdepan.',
            'misi' => ['Meningkatkan pendidikan', 'Memberdayakan masyarakat'],
            'is_donasi_enabled' => true,
        ]);

        $admin = $this->makeUser(UserRole::Admin);
        $divisi = Divisi::create(['nama' => 'Pendidikan', 'is_active' => true]);
        AnggotaDevisi::create(['divisi_id' => $divisi->id, 'nama' => 'Rina', 'jabatan' => 'Ketua', 'is_active' => true]);
        AnggotaDevisi::create(['divisi_id' => $divisi->id, 'nama' => 'Nonaktif', 'jabatan' => 'Staff', 'is_active' => false]);

        Relawan::create(['nama' => 'Relawan Aktif', 'email' => 'r1@yssc.test', 'telepon' => '081', 'motivasi' => 'Membantu sesama secara ikhlas.', 'status' => 'approved']);
        Relawan::create(['nama' => 'Relawan Pending', 'email' => 'r2@yssc.test', 'telepon' => '082', 'motivasi' => 'Menunggu verifikasi.', 'status' => 'pending']);

        Mitra::create(['jenis_mitra' => JenisMitra::Perusahaan, 'nama_perusahaan' => 'PT A', 'email' => 'm1@yssc.test', 'telepon' => '081', 'status' => 'approved']);
        Mitra::create(['jenis_mitra' => JenisMitra::Perusahaan, 'nama_perusahaan' => 'PT B', 'email' => 'm2@yssc.test', 'telepon' => '082', 'status' => 'pending']);

        $berita = Berita::create(['judul' => 'Kabar Terkini', 'konten' => 'Isi berita', 'user_id' => $admin->id, 'tipe' => 'berita', 'status' => 'published', 'thumbnail' => 'berita/sample.jpg']);
        $kegiatan = Berita::create(['judul' => 'Bakti Sosial', 'konten' => 'Isi kegiatan', 'user_id' => $admin->id, 'tipe' => 'kegiatan', 'status' => 'published']);

        $response = $this->get(route('home'))->assertOk();
        $stats = $response->viewData('stats');
        $this->assertSame(1, $stats['anggota_aktif']);
        $this->assertSame(1, $stats['relawan_aktif']);
        $this->assertSame(1, $stats['mitra_aktif']);
        $this->assertSame(1, $stats['kegiatan_selesai']);

        $this->get(route('berita.index'))->assertOk();
        $this->get(route('berita.show', $berita->slug))
            ->assertOk()
            ->assertSee(asset('storage/berita/sample.jpg'));
        $this->get(route('kegiatan.index'))->assertOk();
        $this->get(route('kegiatan.show', $kegiatan->slug))->assertOk();
        $this->get(route('profil.index'))
            ->assertOk()
            ->assertSee('Menjadi yayasan sosial terdepan.')
            ->assertSee('not-italic');
        $this->get(route('anggota.index'))->assertOk()->assertSee('Rina');
        $this->get(route('mitra.index'))->assertOk();
        $this->get(route('relawan.index'))->assertOk()->assertSee('Relawan Aktif');
        $this->get(route('relawan.form'))->assertOk();
        $this->get(route('perizinan.form'))->assertOk();
        $this->get(route('perizinan.cek'))->assertOk();
    }

    public function test_public_perizinan_upload_validates_mime_and_stores_privately_on_local_disk(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        // Reject unsafe executable/script extensions
        $badFile = UploadedFile::fake()->create('shell.php', 10, 'application/x-php');
        $this->post(route('perizinan.submit'), [
            'nama_pemohon' => 'Pemohon Nakal',
            'email_pemohon' => 'bad@yssc.test',
            'jenis_izin' => 'kegiatan',
            'judul_permohonan' => 'Izin Uji Ekstensi',
            'deskripsi' => 'Deskripsi permohonan uji',
            'dokumen_pendukung' => [$badFile],
        ])->assertSessionHasErrors('dokumen_pendukung.0');

        // Accept PDF and store on local disk (NOT public disk)
        $pdf = UploadedFile::fake()->create('proposal.pdf', 100, 'application/pdf');
        $this->post(route('perizinan.submit'), [
            'nama_pemohon' => 'Pemohon Resmi',
            'email_pemohon' => 'resmi@yssc.test',
            'jenis_izin' => 'kegiatan',
            'judul_permohonan' => 'Izin Seminar Sosial',
            'deskripsi' => 'Deskripsi resmi permohonan seminar.',
            'dokumen_pendukung' => [$pdf],
        ])->assertRedirect(route('perizinan.form'));

        $perizinan = Perizinan::where('email_pemohon', 'resmi@yssc.test')->firstOrFail();
        $storedPath = $perizinan->dokumen_pendukung[0];

        Storage::disk('local')->assertExists($storedPath);
        Storage::disk('public')->assertMissing($storedPath);

        // Guest cannot download private perizinan document; Admin can download
        $this->get(route('admin.perizinan.dokumen', [$perizinan->id, 0]))->assertRedirect(route('login'));

        $admin = $this->makeUser(UserRole::Admin);
        $this->actingAs($admin)
            ->get(route('admin.perizinan.dokumen', [$perizinan->id, 0]))
            ->assertOk();
    }

    public function test_public_mitra_registration_stores_private_documents_on_local_disk(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        Mail::fake();

        $this->makeUser(UserRole::SuperAdmin, ['email' => 'sa@yssc.test']);

        $npwp = UploadedFile::fake()->create('npwp.pdf', 120, 'application/pdf');
        $legal = UploadedFile::fake()->create('akta.pdf', 150, 'application/pdf');

        Livewire::test(MitraRegistrationForm::class)
            ->set('jenisMitra', JenisMitra::Perusahaan->value)
            ->set('namaPerusahaan', 'PT Karya Abadi')
            ->set('email', 'karya@yssc.test')
            ->set('telepon', '081234567890')
            ->set('npwp', '01.234.567.8-901.000')
            ->set('dokumenNpwp', $npwp)
            ->set('dokumenLegalitas', $legal)
            ->call('submit')
            ->assertSet('submitted', true);

        $mitra = Mitra::where('email', 'karya@yssc.test')->firstOrFail();
        Storage::disk('local')->assertExists($mitra->dokumen_npwp);
        Storage::disk('local')->assertExists($mitra->dokumen_legalitas);
        Storage::disk('public')->assertMissing($mitra->dokumen_npwp);

        $admin = $this->makeUser(UserRole::Admin);
        $this->actingAs($admin)->get(route('admin.mitra.dokumen', [$mitra->id, 'npwp']))->assertOk();
        $this->actingAs($admin)->get(route('admin.mitra.dokumen', [$mitra->id, 'legalitas']))->assertOk();
    }

    public function test_mitra_dashboard_and_managers_work_with_real_schema_and_ownership(): void
    {
        Storage::fake('public');

        $mitraUser = $this->makeUser(UserRole::Mitra, ['name' => 'PT Mitra Baik']);
        $mitra = Mitra::create([
            'user_id' => $mitraUser->id,
            'jenis_mitra' => JenisMitra::Perusahaan,
            'nama_perusahaan' => 'PT Mitra Baik',
            'email' => $mitraUser->email,
            'telepon' => '0811111111',
            'status' => 'approved',
        ]);

        $program = ProgramDonasi::create([
            'judul' => 'Program Beasiswa Mitra',
            'deskripsi' => 'Untuk pelajar',
            'target_nominal' => 5000000,
            'tanggal_mulai' => now()->toDateString(),
            'status' => 'aktif',
            'mitra_id' => $mitra->id,
        ]);

        Donasi::create([
            'program_donasi_id' => $program->id,
            'nama_donatur' => 'Donatur Asli',
            'email_donatur' => 'secret@yssc.test',
            'nominal' => 150000,
            'is_anonim' => true,
            'status_pembayaran' => 'success',
        ]);

        // MitraDashboard loads without RelationNotFoundException and masks anonymous donor name
        Livewire::actingAs($mitraUser)
            ->test(MitraDashboard::class)
            ->assertSee('Program Beasiswa Mitra')
            ->assertSee('Anonim')
            ->assertDontSee('Donatur Asli');

        // MitraBeritaManager writes tipe & status properly and preserves slug on update
        $kategori = Kategori::create(['nama' => 'Sosial', 'warna' => '#0d9488']);
        $thumb = UploadedFile::fake()->image('cover.jpg');

        Livewire::actingAs($mitraUser)
            ->test(MitraBeritaManager::class)
            ->call('create')
            ->set('judul', 'Aksi Mitra Pertama')
            ->set('konten', 'Dokumentasi lengkap aksi.')
            ->set('kategoriId', (string) $kategori->id)
            ->set('tipe', 'kegiatan')
            ->set('status', 'published')
            ->set('thumbnail', $thumb)
            ->call('save')
            ->assertHasNoErrors();

        $berita = Berita::where('user_id', $mitraUser->id)->firstOrFail();
        $originalSlug = $berita->slug;
        $this->assertSame('kegiatan', $berita->tipe);
        $this->assertSame('published', $berita->status);

        // Update keeps slug intact
        Livewire::actingAs($mitraUser)
            ->test(MitraBeritaManager::class)
            ->call('edit', $berita->id)
            ->set('judul', 'Aksi Mitra Revisi')
            ->call('save')
            ->assertHasNoErrors();
        $this->assertSame($originalSlug, $berita->fresh()->slug);

        // Other mitra cannot hijack or delete first mitra's berita/program
        $otherMitraUser = $this->makeUser(UserRole::Mitra);
        Mitra::create([
            'user_id' => $otherMitraUser->id,
            'jenis_mitra' => JenisMitra::Perusahaan,
            'nama_perusahaan' => 'PT Mitra Lain',
            'email' => $otherMitraUser->email,
            'telepon' => '0899999999',
            'status' => 'approved',
        ]);

        Livewire::actingAs($otherMitraUser)
            ->test(MitraBeritaManager::class)
            ->call('deleteBerita', $berita->id);
        $this->assertNotNull(Berita::find($berita->id));

        // Mitra without Mitra profile record gets 403 when trying to save Program
        $orphanMitra = $this->makeUser(UserRole::Mitra);
        Livewire::actingAs($orphanMitra)
            ->test(MitraProgramManager::class)
            ->call('create')
            ->set('judul', 'Program Tanpa Profil')
            ->set('deskripsi', 'Desc')
            ->set('targetNominal', '500000')
            ->set('thumbnail', UploadedFile::fake()->image('p.jpg'))
            ->call('save')
            ->assertForbidden();
    }

    public function test_admin_managers_allow_duplicate_titles_via_unique_slugs(): void
    {
        $admin = $this->makeUser(UserRole::Admin);

        Livewire::actingAs($admin)->test(KategoriManager::class)->call('create')->set('nama', 'Sosial')->call('save');
        Livewire::actingAs($admin)->test(KategoriManager::class)->call('create')->set('nama', 'Sosial')->call('save');
        $this->assertSame(2, Kategori::where('nama', 'Sosial')->count());

        Livewire::actingAs($admin)->test(BeritaManager::class)
            ->call('create')->set('judul', 'Berita Kembar')->set('konten', 'Isi')->call('save');
        Livewire::actingAs($admin)->test(BeritaManager::class)
            ->call('create')->set('judul', 'Berita Kembar')->set('konten', 'Isi 2')->call('save');
        $this->assertSame(2, Berita::where('judul', 'Berita Kembar')->count());

        Livewire::actingAs($admin)->test(ProgramDonasiManager::class)
            ->call('create')->set('judul', 'Donasi Kembar')->set('deskripsi', 'Desc')->set('target_nominal', 200000)->call('save');
        Livewire::actingAs($admin)->test(ProgramDonasiManager::class)
            ->call('create')->set('judul', 'Donasi Kembar')->set('deskripsi', 'Desc 2')->set('target_nominal', 200000)->call('save');
        $this->assertSame(2, ProgramDonasi::where('judul', 'Donasi Kembar')->count());
    }
}

