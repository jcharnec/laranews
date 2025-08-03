<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear roles
        $this->call([
            RoleSeeder::class,
        ]);

        // 2. Crear usuario administrador fijo
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'], // condición de búsqueda
            [ // solo se usa si no existe
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Asignar el rol de administrador si existe
        $adminRole = Role::where('role', 'administrador')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
        }

        // 4. Crear 50 usuarios más
        User::factory(50)->create();

        // 5. Asignar roles a los usuarios
        $this->call([
            RoleUserSeeder::class,
        ]);

        // 6. Crear noticias (después de tener usuarios)
        $this->call([
            NoticiaSeeder::class,
        ]);

        // 7. Crear comentarios aleatorios (necesita noticias y usuarios)
        $this->call([
            ComentarioSeeder::class,
        ]);
    }
}
