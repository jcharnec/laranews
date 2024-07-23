<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'lector',
            'redactor',
            'editor',
            'administrador',
            'bloqueado'
        ];

        foreach ($roles as $role) {
            Role::create(['role' => $role]);
        }
    }
}

