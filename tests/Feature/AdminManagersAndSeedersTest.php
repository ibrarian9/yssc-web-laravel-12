<?php

namespace Tests\Feature;

use App\Enums\JenisMitra;
use App\Enums\UserRole;
use App\Livewire\Admin\AnggotaManager;
use App\Livewire\Admin\HeroSectionManager;
use App\Livewire\Admin\PerizinanManager;
use App\Livewire\Admin\ProfilManager;
use App\Livewire\Admin\RelawanManager;
use App\Livewire\Admin\SliderManager;
use App\Livewire\Admin\TransaksiDonasiManager;
use App\Livewire\Mitra\MitraProgramManager;
use App\Models\Divisi;
use App\Models\Donasi;
use App\Models\HeroSection;
use App\Models\Mitra;
use App\Models\Perizinan;
use App\Models\Profile;
use App\Models\ProgramDonasi;
use App\Models\Relawan;
use App\Models\Slider;
use App\Models\User;
use Database\Seeders\MitraSeeder;
use Database\Seeders\PerizinanSeeder;
use Database\Seeders\RelawanSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminManagersAndSeedersTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(UserRole $role, array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => $role->label() . ' Admin',
            'email' => $role->value . '.' . uniqid() . '@yssc.test',
            'password' => Hash::make('password'),
            'role' => $role,
            'is_active' => true,
            'must_change_password' => false,
            'email_verified_at' => now(),
        ], $overrides));
    }

    public function test_admin_dashboard_and_operational_managers_execute_cleanly(): void
    {
        Storage::fake('public');
        $admin = $this->makeUser(UserRole::Admin);

        $program = ProgramDonasi::create([
            'judul' => 'Program Chart Uji',
            'deskripsi' => 'Desc',
            'target_nominal' => 1000000,
            'tanggal_mulai' => now()->toDateString(),
            'status' => 'aktif',
        ]);

        Donasi::create([
            'program_donasi_id' => $program->id,
            'nama_donatur' => 'Ahmad',
            'email_donatur' => 'ahmad@yssc.test',
            'nominal' => 300000,
            'status_pembayaran' => 'success',
            'paid_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Rp 300.000');

        // ProfilManager updates profile and clears cached Profile
        Livewire::actingAs($admin)
            ->test(ProfilManager::class)
            ->set('nama_organisasi', 'YSSC Terpadu')
            ->set('visi', 'Visi baru organisasi.')
            ->set('misi', ['Misi satu', '  ', 'Misi dua'])
            ->call('save')
            ->assertHasNoErrors();

        $cached = Profile::getCached();
        $this->assertSame('YSSC Terpadu', $cached->nama_organisasi);
        $this->assertSame(['Misi satu', 'Misi dua'], $cached->misi);

        // HeroSectionManager syncs defaults and invalidates hero cache on update
        $heroComponent = Livewire::actingAs($admin)->test(HeroSectionManager::class);
        $hero = HeroSection::where('page_key', 'berita')->firstOrFail();

        $heroComponent
            ->call('edit', $hero->id)
            ->set('judul', 'Berita YSSC Terbaru')
            ->set('overlay_opacity', 75)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('Berita YSSC Terbaru', HeroSection::getHero('berita')->judul);

        // SliderManager CRUD
        Livewire::actingAs($admin)
            ->test(SliderManager::class)
            ->call('create')
            ->set('judul', 'Slide Utama')
            ->set('newGambar', UploadedFile::fake()->image('slide.jpg'))
            ->call('save')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('sliders', ['judul' => 'Slide Utama']);

        // AnggotaManager Divisi + Anggota CRUD
        Livewire::actingAs($admin)
            ->test(AnggotaManager::class)
            ->call('createDivisi')
            ->set('namaDivisi', 'Divisi Sosial')
            ->call('saveDivisi')
            ->assertHasNoErrors();

        $divisi = Divisi::where('nama', 'Divisi Sosial')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(AnggotaManager::class)
            ->call('createAnggota')
            ->set('nama', 'Dewi Anggota')
            ->set('jabatan', 'Koordinator')
            ->set('divisiId', (string) $divisi->id)
            ->call('saveAnggota')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('anggota_devisi', ['nama' => 'Dewi Anggota']);

        // PerizinanManager approval update
        $izin = Perizinan::create([
            'nama_pemohon' => 'Budi',
            'email_pemohon' => 'budi.izin@yssc.test',
            'jenis_izin' => 'kegiatan',
            'judul_permohonan' => 'Izin Acara',
            'deskripsi' => 'Desc acara',
            'tanggal_permohonan' => now()->toDateString(),
            'status' => 'pending',
        ]);

        Livewire::actingAs($admin)
            ->test(PerizinanManager::class)
            ->call('openDetail', $izin->id)
            ->set('newStatus', 'selesai')
            ->set('catatanAdmin', 'Disetujui lengkap')
            ->call('updateStatus');
        $this->assertSame('selesai', $izin->fresh()->status);

        // RelawanManager approval update
        $relawan = Relawan::create([
            'nama' => 'Sari Relawan',
            'email' => 'sari@yssc.test',
            'telepon' => '081234',
            'motivasi' => 'Berkontribusi di kegiatan sosial anak.',
            'status' => 'pending',
        ]);

        Livewire::actingAs($admin)
            ->test(RelawanManager::class)
            ->call('openDetail', $relawan->id)
            ->set('catatanAdmin', 'Lolos wawancara')
            ->call('approve');
        $this->assertSame('approved', $relawan->fresh()->status);

        // TransaksiDonasiManager search & detail
        Livewire::actingAs($admin)
            ->test(TransaksiDonasiManager::class)
            ->set('search', 'ahmad@yssc.test')
            ->assertSee('Ahmad');
    }

    public function test_mitra_program_manager_crud_preserves_slug_on_edit(): void
    {
        Storage::fake('public');

        $mitraUser = $this->makeUser(UserRole::Mitra);
        $mitra = Mitra::create([
            'user_id' => $mitraUser->id,
            'jenis_mitra' => JenisMitra::Perusahaan,
            'nama_perusahaan' => 'PT Mitra Program',
            'email' => $mitraUser->email,
            'telepon' => '081222333444',
            'status' => 'approved',
        ]);

        Livewire::actingAs($mitraUser)
            ->test(MitraProgramManager::class)
            ->call('create')
            ->set('judul', 'Beasiswa Sekolah Dasar')
            ->set('deskripsi', 'Program beasiswa SD')
            ->set('targetNominal', '2500000')
            ->set('tanggalSelesai', now()->addDays(30)->format('Y-m-d'))
            ->set('thumbnail', UploadedFile::fake()->image('prog.jpg'))
            ->call('save')
            ->assertHasNoErrors();

        $program = ProgramDonasi::where('mitra_id', $mitra->id)->firstOrFail();
        $originalSlug = $program->slug;

        Livewire::actingAs($mitraUser)
            ->test(MitraProgramManager::class)
            ->call('edit', $program->id)
            ->set('judul', 'Beasiswa Sekolah Dasar Tahap 2')
            ->call('save')
            ->assertHasNoErrors();

        $program->refresh();
        $this->assertSame('Beasiswa Sekolah Dasar Tahap 2', $program->judul);
        $this->assertSame($originalSlug, $program->slug);

        Livewire::actingAs($mitraUser)
            ->test(MitraProgramManager::class)
            ->call('toggleStatus', $program->id);

        $this->assertSame('selesai', $program->fresh()->status);
    }

    public function test_public_register_relawan_and_perizinan_tracking_work(): void
    {
        $this->post('/register', [
            'name' => 'Pengguna Baru',
            'email' => 'baru@yssc.test',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $user = User::where('email', 'baru@yssc.test')->firstOrFail();

        $this->actingAs($user)
            ->post(route('relawan.submit'), [
                'nama' => 'Pengguna Baru',
                'email' => 'baru@yssc.test',
                'telepon' => '0812999888',
                'motivasi' => 'Saya ingin aktif mengajar dan membantu anak-anak yayasan.',
            ])->assertRedirect(route('relawan.form'));

        $this->assertDatabaseHas('relawan', [
            'user_id' => $user->id,
            'email' => 'baru@yssc.test',
            'status' => 'pending',
        ]);

        Perizinan::create([
            'nama_pemohon' => 'Pemohon Track',
            'email_pemohon' => 'track@yssc.test',
            'jenis_izin' => 'rekomendasi',
            'judul_permohonan' => 'Permohonan Riset Lacak',
            'deskripsi' => 'Desc',
            'tanggal_permohonan' => now()->toDateString(),
            'status' => 'diproses',
        ]);

        $this->get(route('perizinan.cek', ['email' => 'track@yssc.test']))
            ->assertOk()
            ->assertSee('Permohonan Riset Lacak');
    }

    public function test_domain_seeders_run_cleanly_and_are_idempotent(): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(MitraSeeder::class);
        $this->seed(PerizinanSeeder::class);
        $this->seed(RelawanSeeder::class);

        // Idempotent re-run for Mitra, Perizinan, Relawan seeders
        $this->seed(MitraSeeder::class);
        $this->seed(PerizinanSeeder::class);
        $this->seed(RelawanSeeder::class);

        $this->assertDatabaseHas('users', ['email' => 'superadmin@yssc.org', 'role' => 'superadmin']);
        $this->assertDatabaseHas('users', ['email' => 'admin1@yssc.org', 'role' => 'admin']);
        $this->assertSame(3, Mitra::count());
        $this->assertSame(3, Perizinan::count());
        $this->assertSame(3, Relawan::count());
    }
}

