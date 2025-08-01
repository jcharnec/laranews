<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::where('id', '>', 1)->get(); // Excluye al admin
        $roles = \App\Models\Role::all();

        foreach ($users as $user) {
            $roleIds = $roles->random(rand(1, 3))->pluck('id')->toArray();
            $user->roles()->attach($roleIds);

            echo "Assigned roles " . implode(', ', $roleIds) . " to user " . $user->id . "\n";
        }
    }
}
