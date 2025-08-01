<?php

namespace Database\Factories;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticiaFactory extends Factory
{
    protected $model = Noticia::class;

    public function definition(): array
    {
        $temasValidos = [
            'Actualidad',
            'Política',
            'Deportes',
            'Cultura',
            'Tecnología',
            'Economía',
            'Opinión'
        ];

        return [
            'titulo' => $this->faker->sentence,
            'tema' => $this->faker->randomElement($temasValidos),
            'texto' => $this->faker->paragraphs(3, true),
            'imagen' => null, // Puedes usar 'default.jpg' si quieres una imagen por defecto
            'visitas' => 0,
            'user_id' => User::inRandomOrder()->first()?->id,
            'published_at' => $this->faker->optional()->dateTimeThisYear,
            'rejected' => false,
        ];
    }
}
