<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_page_permission_can_access_page(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'colaborador', 'label' => 'Colaborador']);
        $permission = Permission::create(['name' => 'dashboard.view', 'label' => 'Ver dashboard', 'page' => 'dashboard']);
        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        $this->actingAs($user)->get(route('dashboard'))->assertOk();
    }

    public function test_user_without_page_permission_is_forbidden(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('dashboard'))->assertForbidden();
    }

    public function test_superadmin_bypasses_page_permission(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'superadmin', 'label' => 'Superadmin']);
        $user->roles()->attach($role);

        $this->actingAs($user)->get(route('dashboard'))->assertOk();
    }
}
