<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            NoticiaSeeder::class,
            RoleSeeder::class,
        ]);

        // Crear usuario administrador fijo
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Asignar el rol de administrador si existe
        $adminRole = \App\Models\Role::where('role', 'administrador')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        User::factory(50)->create();

        $this->call([
            RoleUserSeeder::class,
        ]);
    }
}
