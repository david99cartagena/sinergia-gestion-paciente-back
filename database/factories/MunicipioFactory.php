<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Municipio;
use App\Models\Departamento;

class MunicipioFactory extends Factory
{
    protected $model = Municipio::class;

    public function definition()
    {
        return [
            'departamento_id' => Departamento::factory(),
            'nombre' => $this->faker->city(),
        ];
    }
}
