<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $dashboardPermission = Permission::updateOrCreate(['name' => 'dashboard.view'], [
            'label' => 'Visualizar dashboard',
            'page' => 'dashboard',
        ]);

        $roles->each(fn (Role $role) => $role->permissions()->syncWithoutDetaching([$dashboardPermission->id]));

        foreach ([
            ['name' => 'Reginaldo do Prado', 'email' => 'reginaldodoprado@gmail.com', 'role' => 'superadmin'],
            ['name' => 'Keila BPL Produtos', 'email' => 'keila@bplprodutos.com.br', 'role' => 'admin'],
            ['name' => 'Ellen BPL Produtos', 'email' => 'ellen@bplprodutos.com.br', 'role' => 'colaborador'],
        ] as $account) {
            $user = User::updateOrCreate(['email' => $account['email']], [
                'name' => $account['name'],
                'password' => Hash::make(Str::random(64)),
                'email_verified_at' => now(),
            ]);

            $user->roles()->sync([$roles[$account['role']]->id]);
        }
    }
}
