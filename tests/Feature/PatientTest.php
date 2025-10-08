<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Paciente;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->departamento = Departamento::factory()->create();
        $this->municipio = Municipio::factory()->create([
            'departamento_id' => $this->departamento->id,
        ]);
        $this->tipoDocumento = TipoDocumento::factory()->create();
        $this->genero = Genero::factory()->create();

        // Crear usuario admin para JWT
        $this->user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('1234567890'),
        ]);

        // Obtener token JWT correctamente
        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => '1234567890'
        ]);

        $this->token = $response->json('token');
    }


    /** @test */
    public function puede_crear_un_paciente()
    {
        $data = [
            'tipo_documento_id' => $this->tipoDocumento->id,
            'numero_documento' => '1234567890',
            'nombre1' => 'David',
            'nombre2' => 'Stevens',
            'apellido1' => 'Cartagena',
            'apellido2' => 'Navarro',
            'genero_id' => $this->genero->id,
            'departamento_id' => $this->departamento->id,
            'municipio_id' => $this->municipio->id,
            'correo' => 'david@example.com',
            'foto' => null
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/pacientes', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'msg',
                'data' => [
                    'id',
                    'tipo_documento_id',
                    'numero_documento',
                    'nombre1',
                    'nombre2',
                    'apellido1',
                    'apellido2',
                    'genero_id',
                    'departamento_id',
                    'municipio_id',
                    'correo',
                    'foto',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('pacientes', [
            'numero_documento' => '1234567890',
            'nombre1' => 'David'
        ]);
    }

    /** @test */
    public function puede_listar_pacientes()
    {
        Paciente::factory()->create([
            'tipo_documento_id' => $this->tipoDocumento->id,
            'numero_documento' => '1111111111',
            'nombre1' => 'Test',
            'apellido1' => 'Paciente',
            'genero_id' => $this->genero->id,
            'departamento_id' => $this->departamento->id,
            'municipio_id' => $this->municipio->id,
            'correo' => 'test@paciente.com'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/pacientes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'msg',
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'tipo_documento_id',
                            'numero_documento',
                            'nombre1',
                            'nombre2',
                            'apellido1',
                            'apellido2',
                            'genero_id',
                            'departamento_id',
                            'municipio_id',
                            'correo',
                            'foto',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]
            ]);
    }
    /** @test */
    // En la validacion
    /* public function puede_actualizar_un_paciente()
    {
        $paciente = Paciente::factory()->create([
            'tipo_documento_id' => $this->tipoDocumento->id,
            'numero_documento' => '2222222222',
            'nombre1' => 'Original',
            'apellido1' => 'Paciente',
            'genero_id' => $this->genero->id,
            'departamento_id' => $this->departamento->id,
            'municipio_id' => $this->municipio->id,
            'correo' => 'original@paciente.com'
        ]);

        $data = [
            'nombre1' => 'Actualizado',
            'departamento_id' => $this->departamento->id,
            'municipio_id' => $this->municipio->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->putJson("/api/pacientes/{$paciente->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['nombre1' => 'Actualizado']);

        $this->assertDatabaseHas('pacientes', ['id' => $paciente->id, 'nombre1' => 'Actualizado']);
    } */
    /** @test */
    public function puede_eliminar_un_paciente()
    {
        $paciente = Paciente::factory()->create([
            'tipo_documento_id' => $this->tipoDocumento->id,
            'numero_documento' => '3333333333',
            'nombre1' => 'Eliminar',
            'apellido1' => 'Paciente',
            'genero_id' => $this->genero->id,
            'departamento_id' => $this->departamento->id,
            'municipio_id' => $this->municipio->id,
            'correo' => 'eliminar@paciente.com'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->deleteJson("/api/pacientes/{$paciente->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['msg' => 'Paciente eliminado correctamente']);

        $this->assertDatabaseMissing('pacientes', ['id' => $paciente->id]);
    }
}
