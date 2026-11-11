<?php

namespace Tests\Feature;

use App\Enums\JenisMitra;
use App\Enums\UserRole;
use App\Livewire\Admin\AuditLogManager;
use App\Livewire\Admin\MitraManager;
use App\Livewire\Admin\UserManager;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class RbacAndMiddlewareTest extends TestCase
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

    public function test_guests_are_redirected_from_protected_panels(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.users.index'))->assertRedirect(route('login'));
        $this->get(route('admin.audit-log.index'))->assertRedirect(route('login'));
        $this->get(route('mitra.dashboard'))->assertRedirect(route('login'));
    }

    public function test_guest_and_member_roles_cannot_access_admin_or_mitra_panels(): void
    {
        foreach ([UserRole::Guest, UserRole::Member] as $role) {
            $user = $this->makeUser($role);

            $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
            $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
            $this->actingAs($user)->get(route('admin.audit-log.index'))->assertForbidden();
            $this->actingAs($user)->get(route('mitra.dashboard'))->assertForbidden();
        }
    }

    public function test_operational_admin_accesses_operational_routes_but_is_forbidden_from_superadmin_routes(): void
    {
        $admin = $this->makeUser(UserRole::Admin, ['name' => 'Admin Operasional']);

        $operationalRoutes = [
            'admin.dashboard',
            'admin.berita.index',
            'admin.kategori.index',
            'admin.profil.index',
            'admin.anggota.index',
            'admin.program-donasi.index',
            'admin.transaksi-donasi.index',
            'admin.perizinan.index',
            'admin.mitra.index',
            'admin.relawan.index',
            'admin.sliders.index',
            'admin.hero-sections.index',
            'admin.tutorial.index',
        ];

        foreach ($operationalRoutes as $routeName) {
            $this->actingAs($admin)->get(route($routeName))->assertOk();
        }

        // SuperAdmin-exclusive routes return 403
        $this->actingAs($admin)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.audit-log.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('mitra.dashboard'))->assertForbidden();

        // Sidebar and tutorial hide SuperAdmin-only items
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('Sistem (Super Admin)')
            ->assertDontSee(route('admin.users.index'))
            ->assertDontSee(route('admin.audit-log.index'));

        $this->actingAs($admin)
            ->get(route('admin.tutorial.index'))
            ->assertOk()
            ->assertSee('Pembagian Hak Akses (Role Sistem)')
            ->assertDontSee('12. Pengguna & Role Akun')
            ->assertDontSee('13. Audit Log (Riwayat Sistem)');
    }

    public function test_superadmin_has_full_access_and_sees_system_menus(): void
    {
        $superadmin = $this->makeUser(UserRole::SuperAdmin, ['name' => 'Super Admin YSSC']);

        $this->actingAs($superadmin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Manajemen Pengguna');

        $this->actingAs($superadmin)
            ->get(route('admin.audit-log.index'))
            ->assertOk()
            ->assertSee('Audit Log');

        $this->actingAs($superadmin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Sistem (Super Admin)')
            ->assertSee(route('admin.users.index'))
            ->assertSee(route('admin.audit-log.index'));

        $this->actingAs($superadmin)
            ->get(route('admin.tutorial.index'))
            ->assertOk()
            ->assertSee('12. Pengguna & Role Akun')
            ->assertSee('13. Audit Log (Riwayat Sistem)');
    }

    public function test_livewire_components_enforce_superadmin_authorization_directly(): void
    {
        $admin = $this->makeUser(UserRole::Admin);

        Livewire::actingAs($admin)
            ->test(UserManager::class)
            ->assertForbidden();

        Livewire::actingAs($admin)
            ->test(AuditLogManager::class)
            ->assertForbidden();
    }

    public function test_superadmin_cannot_demote_deactivate_or_delete_self(): void
    {
        $superadmin = $this->makeUser(UserRole::SuperAdmin);

        Livewire::actingAs($superadmin)
            ->test(UserManager::class)
            ->call('edit', $superadmin->id)
            ->set('role', UserRole::Admin->value)
            ->call('save')
            ->assertHasErrors(['role']);

        Livewire::actingAs($superadmin)
            ->test(UserManager::class)
            ->call('edit', $superadmin->id)
            ->set('is_active', false)
            ->call('save')
            ->assertHasErrors(['is_active']);

        Livewire::actingAs($superadmin)
            ->test(UserManager::class)
            ->call('toggleActive', $superadmin->id)
            ->call('confirmDelete', $superadmin->id);

        $superadmin->refresh();
        $this->assertSame(UserRole::SuperAdmin, $superadmin->role);
        $this->assertTrue($superadmin->is_active);
        $this->assertNotNull(User::find($superadmin->id));
    }

    public function test_mitra_manager_cannot_overwrite_admin_account_role_via_email_collision(): void
    {
        $superadmin = $this->makeUser(UserRole::SuperAdmin, ['email' => 'boss@yssc.test']);

        Livewire::actingAs($superadmin)
            ->test(MitraManager::class)
            ->call('create')
            ->set('jenis_mitra', JenisMitra::Perusahaan->value)
            ->set('nama_perusahaan', 'PT Hijack')
            ->set('email', 'boss@yssc.test')
            ->set('telepon', '08123456789')
            ->set('createUserAccount', true)
            ->call('save')
            ->assertHasErrors(['email']);

        $superadmin->refresh();
        $this->assertSame(UserRole::SuperAdmin, $superadmin->role);
        $this->assertDatabaseMissing('mitra', ['email' => 'boss@yssc.test']);
    }

    public function test_inactive_admin_and_inactive_mitra_sessions_are_terminated_by_middleware(): void
    {
        $admin = $this->makeUser(UserRole::Admin, ['is_active' => false]);
        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
        $this->assertGuest();

        $mitra = $this->makeUser(UserRole::Mitra, ['is_active' => false]);
        $this->actingAs($mitra)
            ->get(route('mitra.dashboard'))
            ->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_must_change_password_middleware_redirects_and_updates_password(): void
    {
        $admin = $this->makeUser(UserRole::Admin, ['must_change_password' => true]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('password.force-change'));

        $this->actingAs($admin)
            ->put(route('password.force-change'), [
                'current_password' => 'wrongpass',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ])
            ->assertSessionHasErrors('current_password');

        $this->actingAs($admin)
            ->put(route('password.force-change'), [
                'current_password' => 'password',
                'password' => 'NewPassword123!',
                'password_confirmation' => 'NewPassword123!',
            ])
            ->assertRedirect(route('admin.dashboard'));

        $admin->refresh();
        $this->assertFalse($admin->must_change_password);
        $this->assertTrue(Hash::check('NewPassword123!', $admin->password));
    }

    public function test_active_mitra_accesses_mitra_panel_but_cannot_access_admin(): void
    {
        $mitraUser = $this->makeUser(UserRole::Mitra);
        Mitra::create([
            'user_id' => $mitraUser->id,
            'jenis_mitra' => JenisMitra::Perusahaan,
            'nama_perusahaan' => 'PT Mitra Sejahtera',
            'email' => $mitraUser->email,
            'telepon' => '0811111111',
            'status' => 'approved',
        ]);

        $this->actingAs($mitraUser)->get(route('mitra.dashboard'))->assertOk();
        $this->actingAs($mitraUser)->get(route('mitra.program-donasi.index'))->assertOk();
        $this->actingAs($mitraUser)->get(route('mitra.berita.index'))->assertOk();
        $this->actingAs($mitraUser)->get(route('admin.dashboard'))->assertForbidden();
    }
}

