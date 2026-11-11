<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Livewire\Admin\AuditLogManager;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Profile;
use App\Models\ProgramDonasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(UserRole $role, array $overrides = []): User
    {
        return User::create(array_merge([
            'name' => $role->label() . ' Test',
            'email' => $role->value . '.' . uniqid() . '@yssc.test',
            'password' => Hash::make('password'),
            'role' => $role,
            'is_active' => true,
            'must_change_password' => false,
            'email_verified_at' => now(),
        ], $overrides));
    }

    public function test_login_logout_and_failed_login_events_are_recorded_safely(): void
    {
        RateLimiter::clear('wrong@yssc.test|127.0.0.1');

        // 1. Failed login records 1 anonymous 'failed' entry without password
        $this->post('/login', [
            'email' => 'wrong@yssc.test',
            'password' => 'SecretBadPassword123',
        ])->assertSessionHasErrors('email');

        $failedLog = Activity::where('log_name', 'auth')
            ->where('event', 'failed')
            ->latest('id')
            ->first();

        $this->assertNotNull($failedLog);
        $this->assertNull($failedLog->causer_id);
        $this->assertStringContainsString('wrong@yssc.test', $failedLog->description);
        $this->assertSame('wrong@yssc.test', $failedLog->properties->get('email'));
        $this->assertStringNotContainsString('SecretBadPassword123', json_encode($failedLog->toArray()));

        // 2. Inactive user login records 'failed' and terminates session
        $inactiveAdmin = $this->createUser(UserRole::Admin, [
            'email' => 'inactive@yssc.test',
            'is_active' => false,
        ]);

        $this->post('/login', [
            'email' => $inactiveAdmin->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        $inactiveLog = Activity::where('log_name', 'auth')
            ->where('event', 'failed')
            ->where('causer_id', $inactiveAdmin->id)
            ->first();
        $this->assertNotNull($inactiveLog);
        $this->assertStringContainsString('nonaktif', $inactiveLog->description);

        // 3. Valid login records 'login' and logout records 'logout'
        $admin = $this->createUser(UserRole::Admin, ['email' => 'active.admin@yssc.test']);

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $loginLog = Activity::where('log_name', 'auth')
            ->where('event', 'login')
            ->where('causer_id', $admin->id)
            ->first();
        $this->assertNotNull($loginLog);
        $this->assertSame('admin', $loginLog->properties->get('role'));
        $this->assertNotEmpty($loginLog->properties->get('ip'));

        $this->post('/logout')->assertRedirect(route('home'));

        $logoutLog = Activity::where('log_name', 'auth')
            ->where('event', 'logout')
            ->where('causer_id', $admin->id)
            ->first();
        $this->assertNotNull($logoutLog);
    }

    public function test_domain_models_log_dirty_changes_and_exclude_sensitive_or_noisy_fields(): void
    {
        $superadmin = $this->createUser(UserRole::SuperAdmin);
        $this->actingAs($superadmin);

        // Password change does not appear in User attribute_changes
        $member = $this->createUser(UserRole::Member, ['email' => 'member.audit@yssc.test']);
        $member->update(['password' => Hash::make('BrandNewSecret!')]);

        $pwdUpdateLogs = Activity::where('subject_type', User::class)
            ->where('subject_id', $member->id)
            ->where('event', 'updated')
            ->get();
        $this->assertCount(0, $pwdUpdateLogs);

        // Non-sensitive User updates ARE logged with attribute_changes
        $member->update(['name' => 'Member Baru']);
        $userLog = Activity::where('subject_type', User::class)
            ->where('subject_id', $member->id)
            ->where('event', 'updated')
            ->latest('id')
            ->first();
        $this->assertNotNull($userLog);
        $this->assertSame('Member Baru', $userLog->attribute_changes['attributes']['name'] ?? null);

        // Kategori CRUD
        $kat = Kategori::create(['nama' => 'Lingkungan Hidup', 'warna' => '#10b981']);
        $kat->update(['nama' => 'Lingkungan Asri']);
        $kat->delete();

        $this->assertSame(
            ['created', 'updated', 'deleted'],
            Activity::where('subject_type', Kategori::class)
                ->where('subject_id', $kat->id)
                ->orderBy('id')
                ->pluck('event')
                ->all()
        );

        // Berita view increment does NOT spam audit log
        $berita = Berita::create([
            'judul' => 'Kabar Kebun',
            'konten' => 'Isi konten berita',
            'user_id' => $superadmin->id,
            'tipe' => 'berita',
            'status' => 'published',
        ]);
        $countBeforeView = Activity::where('subject_type', Berita::class)->where('subject_id', $berita->id)->count();
        $berita->incrementViews();
        $this->assertSame(
            $countBeforeView,
            Activity::where('subject_type', Berita::class)->where('subject_id', $berita->id)->count()
        );

        // Profile and ProgramDonasi log dirty attribute changes
        $profile = Profile::create(['nama_organisasi' => 'YSSC', 'is_donasi_enabled' => true]);
        $profile->update(['is_donasi_enabled' => false]);
        $profileLog = Activity::where('subject_type', Profile::class)->where('event', 'updated')->latest('id')->first();
        $this->assertFalse($profileLog->attribute_changes['attributes']['is_donasi_enabled']);

        $program = ProgramDonasi::create([
            'judul' => 'Program Uji Log',
            'deskripsi' => 'Desc',
            'target_nominal' => 500000,
            'tanggal_mulai' => now()->toDateString(),
            'status' => 'aktif',
        ]);
        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'program-donasi',
            'subject_type' => ProgramDonasi::class,
            'subject_id' => $program->id,
            'event' => 'created',
        ]);
    }

    public function test_audit_log_manager_filters_searches_and_displays_v5_attribute_changes(): void
    {
        $superadmin = $this->createUser(UserRole::SuperAdmin, ['name' => 'Bos Audit']);
        $this->actingAs($superadmin);

        $kat = Kategori::create(['nama' => 'Audit Filter Tag', 'warna' => '#0d9488']);
        $kat->update(['nama' => 'Audit Filter Edited']);

        $updatedLog = Activity::where('subject_type', Kategori::class)
            ->where('subject_id', $kat->id)
            ->where('event', 'updated')
            ->firstOrFail();

        Livewire::actingAs($superadmin)
            ->test(AuditLogManager::class)
            ->set('filterEvent', 'updated')
            ->assertSee('Audit Filter Edited')
            ->set('filterEvent', 'created')
            ->assertDontSee('Audit Filter Edited')
            ->set('filterEvent', '')
            ->set('search', 'Audit Filter Edited')
            ->call('openDetail', $updatedLog->id)
            ->assertSet('showDetail', true)
            ->assertSee('Perubahan Data')
            ->assertSee('Audit Filter Tag')
            ->assertSee('Audit Filter Edited');
    }
}

