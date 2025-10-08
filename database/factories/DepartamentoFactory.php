<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Departamento;

class DepartamentoFactory extends Factory
{
    protected $model = Departamento::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->state(),
        ];
    }
}
