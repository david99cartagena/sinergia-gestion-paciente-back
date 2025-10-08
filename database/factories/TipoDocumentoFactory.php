<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoDocumento;

class TipoDocumentoFactory extends Factory
{
    protected $model = TipoDocumento::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->randomElement(['CC', 'TI']),
        ];
    }
}
