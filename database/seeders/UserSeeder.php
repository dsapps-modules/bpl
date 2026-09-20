<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::query()->pluck('id', 'name');

        foreach ([
            ['name' => 'Reginaldo do Prado', 'email' => 'reginaldodoprado@gmail.com', 'role' => 'superadmin'],
            ['name' => 'Keila BPL Produtos', 'email' => 'keila@bplprodutos.com.br', 'role' => 'admin'],
            ['name' => 'Ellen BPL Produtos', 'email' => 'ellen@bplprodutos.com.br', 'role' => 'colaborador'],
        ] as $account) {
            $user = User::query()->updateOrCreate(['email' => $account['email']], [
                'name' => $account['name'],
                'password' => Hash::make(Str::random(64)),
                'email_verified_at' => now(),
            ]);

            $user->roles()->sync([$roles[$account['role']]]);
        }
    }
}
