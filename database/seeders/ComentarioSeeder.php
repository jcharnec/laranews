<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use App\Models\Comentario;
use App\Models\User;
use Faker\Factory as Faker;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();

        Noticia::all()->each(function ($noticia) use ($faker, $users) {
            $numComentarios = rand(0, 3);

            for ($i = 0; $i < $numComentarios; $i++) {
                Comentario::create([
                    'texto' => $faker->sentence(10),
                    'user_id' => $users->random()->id,
                    'noticia_id' => $noticia->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
