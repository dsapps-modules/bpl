<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrmPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_contacts_permission_can_open_contacts_page(): void
    {
        $user = $this->userWithPermission('crm.contacts.manage');

        $this->actingAs($user)
            ->get(route('crm.contacts'))
            ->assertOk()
            ->assertSee('Contatos')
            ->assertSee('Novo contato');
    }

    public function test_user_without_contacts_permission_cannot_open_contacts_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('crm.contacts'))
            ->assertForbidden();
    }

    public function test_user_with_companies_permission_can_open_companies_page(): void
    {
        $user = $this->userWithPermission('crm.companies.manage');

        $this->actingAs($user)
            ->get(route('crm.companies'))
            ->assertOk()
            ->assertSee('Empresas')
            ->assertSee('Nova empresa');
    }

    public function test_pipeline_page_requires_opportunity_and_pipeline_permissions(): void
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'pipeline-manager', 'label' => 'Pipeline Manager']);
        $permissions = collect([
            Permission::create(['name' => 'crm.opportunities.manage', 'label' => 'Gerenciar oportunidades', 'page' => 'opportunities']),
            Permission::create(['name' => 'crm.pipelines.manage', 'label' => 'Gerenciar funis', 'page' => 'pipelines']),
        ]);
        $role->permissions()->attach($permissions);
        $user->roles()->attach($role);

        $this->actingAs($user)->get(route('crm.pipeline'))->assertOk()->assertSee('Oportunidades e pipeline');
    }

    public function test_user_with_tasks_permission_can_open_tasks_page(): void
    {
        $user = $this->userWithPermission('crm.tasks.manage');

        $this->actingAs($user)
            ->get(route('crm.tasks'))
            ->assertOk()
            ->assertSee('Tarefas')
            ->assertSee('Nova tarefa');
    }

    public function test_user_with_calendar_permission_can_open_calendar_page(): void
    {
        $user = $this->userWithPermission('crm.calendar.manage');

        $this->actingAs($user)
            ->get(route('crm.calendar'))
            ->assertOk()
            ->assertSee('Agenda')
            ->assertSee('Novo evento');
    }

    public function test_user_with_reports_permission_can_open_reports_page(): void
    {
        $user = $this->userWithPermission('crm.reports.view');

        $this->actingAs($user)->get(route('crm.reports'))->assertOk()->assertSee('Relatórios e indicadores');
    }

    public function test_user_with_inbox_permission_can_open_inbox_page(): void
    {
        $user = $this->userWithPermission('crm.inbox.manage');

        $this->actingAs($user)->get(route('crm.inbox'))->assertOk()->assertSee('Inbox e conversas');
    }

    public function test_user_with_tags_permission_can_open_crm_settings_page(): void
    {
        $user = $this->userWithPermission('crm.tags.manage');

        $this->actingAs($user)->get(route('crm.settings.tags'))->assertOk()->assertSee('Tags');
    }

    private function userWithPermission(string $permissionName): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'crm-manager', 'label' => 'CRM Manager']);
        $permission = Permission::create([
            'name' => $permissionName,
            'label' => 'Gerenciar contatos',
            'page' => 'contacts',
        ]);
        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        return $user;
    }
}
