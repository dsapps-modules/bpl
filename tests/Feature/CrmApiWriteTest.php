<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrmApiWriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_create_contact_through_crm_api(): void
    {
        $user = $this->userWithPermission('crm.contacts.manage');

        $this->actingAs($user)
            ->postJson('/api/crm/v1/contacts', [
                'first_name' => 'Ana',
                'last_name' => 'Silva',
                'email' => 'ana@example.test',
            ])
            ->assertCreated()
            ->assertJsonPath('data.first_name', 'Ana');

        $this->assertDatabaseHas('crm_contacts', ['email' => 'ana@example.test']);
    }

    public function test_crm_api_rejects_contact_creation_without_permission(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson('/api/crm/v1/contacts', ['first_name' => 'Sem acesso'])
            ->assertForbidden();
    }

    public function test_authorized_user_can_create_and_complete_task_through_crm_api(): void
    {
        $user = $this->userWithPermission('crm.tasks.manage');

        $response = $this->actingAs($user)->postJson('/api/crm/v1/tasks', [
            'title' => 'Retornar para cliente',
            'priority' => 'high',
            'timezone' => 'America/Sao_Paulo',
        ])->assertCreated();

        $taskId = $response->json('data.id');

        $this->actingAs($user)
            ->postJson("/api/crm/v1/tasks/{$taskId}/complete")
            ->assertOk()
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('crm_tasks', ['id' => $taskId, 'status' => 'completed']);
    }

    public function test_authorized_user_can_update_and_delete_a_pipeline(): void
    {
        $user = $this->userWithPermission('crm.pipelines.manage');
        $pipeline = $this->actingAs($user)->postJson('/api/crm/v1/pipelines', [
            'name' => 'Vendas',
            'active' => true,
            'stages' => [
                ['name' => 'Novo', 'position' => 0],
                ['name' => 'Proposta', 'position' => 1],
            ],
        ])->assertCreated()->json('data');

        $this->actingAs($user)->putJson("/api/crm/v1/pipelines/{$pipeline['id']}", [
            'name' => 'Vendas B2B',
            'active' => true,
            'stages' => [
                ['id' => $pipeline['stages'][1]['id'], 'name' => 'Proposta comercial', 'position' => 0],
                ['id' => $pipeline['stages'][0]['id'], 'name' => 'Novo lead', 'position' => 1],
            ],
        ])->assertOk()->assertJsonPath('data.name', 'Vendas B2B')->assertJsonPath('data.stages.0.name', 'Proposta comercial');

        $this->actingAs($user)->deleteJson("/api/crm/v1/pipelines/{$pipeline['id']}")
            ->assertOk()
            ->assertJsonPath('message', 'Funil excluído com sucesso.');
        $this->assertDatabaseMissing('crm_pipelines', ['id' => $pipeline['id']]);
    }

    private function userWithPermission(string $permissionName): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'api-manager-'.$permissionName, 'label' => 'API Manager']);
        $permission = Permission::create(['name' => $permissionName, 'label' => $permissionName, 'page' => null]);
        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        return $user;
    }
}
