<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Livewire\Admin\ProgramDonasiManager;
use App\Livewire\PublicPages\DonasiForm;
use App\Models\Donasi;
use App\Models\Profile;
use App\Models\ProgramDonasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class DonationAndMidtransTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Admin Donasi',
            'email' => 'admin.donasi@yssc.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
            'is_active' => true,
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);
    }

    private function createProgram(array $overrides = []): ProgramDonasi
    {
        return ProgramDonasi::create(array_merge([
            'judul' => 'Program Pendidikan Harapan',
            'deskripsi' => '<p>Membantu biaya sekolah.</p>',
            'thumbnail' => 'https://example.com/donasi.jpg',
            'target_nominal' => 10000000,
            'terkumpul_nominal' => 0,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(14)->toDateString(),
            'status' => 'aktif',
            'is_mendesak' => false,
        ], $overrides));
    }

    public function test_toggling_donation_menu_hides_and_shows_public_donation_pages(): void
    {
        $admin = $this->createAdmin();
        $profile = Profile::create([
            'nama_organisasi' => 'Yayasan Seribu Satu Cita',
            'is_donasi_enabled' => true,
        ]);
        $program = $this->createProgram();

        // Enabled: home and /donasi show program
        $this->get(route('home'))->assertOk()->assertSee($program->judul);
        $this->get(route('donasi.index'))->assertOk()->assertSee($program->judul);
        $this->get(route('donasi.show', $program->slug))->assertOk()->assertSee($program->judul);

        // Toggle off via ProgramDonasiManager
        Livewire::actingAs($admin)
            ->test(ProgramDonasiManager::class)
            ->call('toggleMenuDonasi')
            ->assertSet('isMenuDonasiActive', false);

        $this->assertFalse($profile->fresh()->is_donasi_enabled);

        // Disabled: home hides section, /donasi shows disabled notice, /donasi/{slug} redirects
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee($program->judul);

        $this->get(route('donasi.index'))
            ->assertOk()
            ->assertSee('Layanan Donasi Sedang Dinonaktifkan Sementara')
            ->assertDontSee($program->judul);

        $this->get(route('donasi.show', $program->slug))
            ->assertRedirect(route('donasi.index'));

        // Livewire DonasiForm also rejects submissions while disabled
        Livewire::test(DonasiForm::class, ['programId' => $program->id])
            ->set('nominal', 50000)
            ->set('namaCustom', 'Donatur Tes')
            ->set('emailCustom', 'donatur@yssc.test')
            ->call('submit')
            ->assertSet('errorMsg', 'Layanan donasi saat ini sedang dinonaktifkan sementara.');

        $this->assertDatabaseCount('donasi', 0);
    }

    public function test_donation_form_rejects_non_active_programs_and_submits_active_donation_via_midtrans(): void
    {
        Profile::create([
            'nama_organisasi' => 'Yayasan Seribu Satu Cita',
            'is_donasi_enabled' => true,
        ]);

        $draftProgram = $this->createProgram(['judul' => 'Program Draft', 'status' => 'draft']);
        $finishedProgram = $this->createProgram(['judul' => 'Program Selesai', 'status' => 'selesai']);
        $activeProgram = $this->createProgram(['judul' => 'Program Aktif', 'thumbnail' => 'program-donasi/sample.jpg']);

        // Show page renders uploaded local thumbnail via storage URL
        $this->get(route('donasi.show', $activeProgram->slug))
            ->assertOk()
            ->assertSee(asset('storage/program-donasi/sample.jpg'));

        foreach ([$draftProgram, $finishedProgram] as $closedProgram) {
            Livewire::test(DonasiForm::class, ['programId' => $closedProgram->id])
                ->set('nominal', 50000)
                ->set('namaCustom', 'Donatur')
                ->set('emailCustom', 'donatur@yssc.test')
                ->call('submit')
                ->assertSet('errorMsg', 'Program donasi ini sudah tidak menerima donasi baru.');
        }

        // Mock Midtrans Snap API success
        Http::fake([
            'https://app.sandbox.midtrans.com/snap/v1/transactions' => Http::response([
                'token' => 'snap-token-12345',
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/snap-token-12345',
            ], 201),
        ]);

        Livewire::test(DonasiForm::class, ['programId' => $activeProgram->id])
            ->set('nominal', 100000)
            ->set('namaCustom', 'Budi Dermawan')
            ->set('emailCustom', 'budi@yssc.test')
            ->set('isAnonim', false)
            ->call('submit')
            ->assertSet('snapToken', 'snap-token-12345')
            ->assertDispatched('open-snap', token: 'snap-token-12345');

        $this->assertDatabaseHas('donasi', [
            'program_donasi_id' => $activeProgram->id,
            'email_donatur' => 'budi@yssc.test',
            'nominal' => 100000.00,
            'status_pembayaran' => 'pending',
            'midtrans_snap_token' => 'snap-token-12345',
        ]);
    }

    public function test_midtrans_callback_verifies_signature_and_updates_collected_total(): void
    {
        config(['midtrans.server_key' => 'test-server-key']);

        $program = $this->createProgram();
        $donasi = Donasi::create([
            'program_donasi_id' => $program->id,
            'nama_donatur' => 'Siti',
            'email_donatur' => 'siti@yssc.test',
            'nominal' => 250000,
            'status_pembayaran' => 'pending',
            'midtrans_order_id' => 'YSSC-TEST-99',
        ]);

        // Reject invalid signature
        $this->postJson(route('midtrans.callback'), [
            'order_id' => 'YSSC-TEST-99',
            'status_code' => '200',
            'gross_amount' => '250000.00',
            'transaction_status' => 'settlement',
            'signature_key' => 'forged-signature',
        ])->assertForbidden();

        $this->assertSame('pending', $donasi->fresh()->status_pembayaran);

        // Accept valid signature
        $validSignature = hash('sha512', 'YSSC-TEST-99' . '200' . '250000.00' . 'test-server-key');

        $this->postJson(route('midtrans.callback'), [
            'order_id' => 'YSSC-TEST-99',
            'status_code' => '200',
            'gross_amount' => '250000.00',
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'signature_key' => $validSignature,
        ])->assertOk();

        $donasi->refresh();
        $program->refresh();

        $this->assertSame('success', $donasi->status_pembayaran);
        $this->assertSame('qris', $donasi->midtrans_payment_type);
        $this->assertNotNull($donasi->paid_at);
        $this->assertSame('250000.00', $program->terkumpul_nominal);
    }
}

