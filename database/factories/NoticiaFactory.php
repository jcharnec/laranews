<?php

namespace Database\Factories;

use App\Models\Noticia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NoticiaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Noticia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'tema' => $this->faker->word,
            'texto' => $this->faker->paragraphs(3, true),
            'imagen' => $this->faker->imageUrl,
            'visitas' => $this->faker->numberBetween(0, 1000),
            'user_id' => \App\Models\User::factory(),
            'published_at' => $this->faker->optional()->dateTimeThisYear,
            'rejected' => $this->faker->boolean(10), // 10% chance of being rejected
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
