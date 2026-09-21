<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = collect([
            ['name' => 'superadmin', 'label' => 'Superadmin'],
            ['name' => 'admin', 'label' => 'Administrador'],
            ['name' => 'colaborador', 'label' => 'Colaborador'],
        ])->mapWithKeys(fn (array $role): array => [
            $role['name'] => Role::updateOrCreate(['name' => $role['name']], $role),
        ]);

        $permissions = collect([
            ['name' => 'dashboard.view', 'label' => 'Visualizar dashboard', 'page' => 'dashboard'],
            ['name' => 'crm.contacts.manage', 'label' => 'Gerenciar contatos', 'page' => 'contacts'],
            ['name' => 'crm.companies.manage', 'label' => 'Gerenciar empresas', 'page' => 'companies'],
            ['name' => 'crm.pipelines.manage', 'label' => 'Gerenciar funis', 'page' => 'pipelines'],
            ['name' => 'crm.opportunities.manage', 'label' => 'Gerenciar oportunidades', 'page' => 'opportunities'],
            ['name' => 'crm.tasks.manage', 'label' => 'Gerenciar tarefas', 'page' => 'tasks'],
            ['name' => 'crm.calendar.manage', 'label' => 'Gerenciar agenda', 'page' => 'calendar'],
            ['name' => 'crm.teams.manage', 'label' => 'Gerenciar equipes', 'page' => 'teams'],
            ['name' => 'crm.tags.manage', 'label' => 'Gerenciar tags', 'page' => 'tags'],
            ['name' => 'crm.fields.manage', 'label' => 'Gerenciar campos personalizados', 'page' => 'custom-fields'],
            ['name' => 'crm.segments.manage', 'label' => 'Gerenciar segmentos', 'page' => 'segments'],
            ['name' => 'crm.inbox.manage', 'label' => 'Gerenciar inbox', 'page' => 'inbox'],
            ['name' => 'crm.automations.manage', 'label' => 'Gerenciar automações', 'page' => 'automations'],
            ['name' => 'crm.reports.view', 'label' => 'Visualizar relatórios', 'page' => 'reports'],
            ['name' => 'crm.email_marketing.manage', 'label' => 'Gerenciar campanhas de e-mail', 'page' => 'email-campaigns'],
        ])->mapWithKeys(fn (array $permission): array => [
            $permission['name'] => Permission::updateOrCreate(['name' => $permission['name']], $permission),
        ]);

        $roles->each(fn (Role $role) => $role->permissions()->syncWithoutDetaching([$permissions['dashboard.view']->id]));
        $roles['admin']->permissions()->syncWithoutDetaching($permissions->except('dashboard.view')->pluck('id')->all());
        $this->call(GrantCrmPermissionsToCollaboratorsSeeder::class);

        $this->call(UserSeeder::class);
    }
}
