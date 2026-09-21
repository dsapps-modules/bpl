<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class GrantCrmPermissionsToCollaboratorsSeeder extends Seeder
{
    public function run(): void
    {
        $crmPermissionIds = Permission::query()
            ->where('name', 'like', 'crm.%')
            ->pluck('id')
            ->all();

        Role::query()
            ->where('name', 'colaborador')
            ->each(function (Role $role) use ($crmPermissionIds): void {
                $role->permissions()->syncWithoutDetaching($crmPermissionIds);
            });
    }
}
