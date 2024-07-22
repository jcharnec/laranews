<?php

namespace Database\Seeders;

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

        User::factory(50)->create();

        $this->call([
            RoleUserSeeder::class,
        ]);
    }
}
