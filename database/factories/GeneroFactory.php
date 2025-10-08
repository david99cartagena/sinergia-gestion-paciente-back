<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Genero;

class GeneroFactory extends Factory
{
    protected $model = Genero::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->randomElement(['Masculino', 'Femenino']),
        ];
    }
}
