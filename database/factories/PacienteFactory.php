<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Paciente;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Departamento;
use App\Models\Municipio;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition()
    {
        $departamento = Departamento::factory()->create();
        $municipio = Municipio::factory()->create(['departamento_id' => $departamento->id]);

        return [
            'tipo_documento_id' => TipoDocumento::factory(),
            'numero_documento' => $this->faker->unique()->randomNumber(8),
            'nombre1' => $this->faker->firstName(),
            'nombre2' => $this->faker->firstName(),
            'apellido1' => $this->faker->lastName(),
            'apellido2' => $this->faker->lastName(),
            'genero_id' => Genero::factory(),
            'departamento_id' => $departamento->id,
            'municipio_id' => $municipio->id,
            'correo' => $this->faker->unique()->safeEmail(),
            'foto' => '',
        ];
    }
}
