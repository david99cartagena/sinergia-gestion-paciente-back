<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tipos = DB::table('tipos_documentos')->pluck('id')->toArray();
        $generos = DB::table('generos')->pluck('id')->toArray();
        $departamentos = DB::table('departamentos')->pluck('id')->toArray();
        $municipios = DB::table('municipios')->pluck('id')->toArray();

        DB::table('pacientes')->insertOrIgnore([
            [
                'tipo_documento_id' => $tipos[0],
                'numero_documento' => '100000001',
                'nombre1' => 'Juan',
                'nombre2' => 'Carlos',
                'apellido1' => 'Pérez',
                'apellido2' => 'Gómez',
                'genero_id' => $generos[0],
                'departamento_id' => $departamentos[0],
                'municipio_id' => $municipios[0],
                'correo' => 'juan.perez@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tipo_documento_id' => $tipos[0],
                'numero_documento' => '100000002',
                'nombre1' => 'María',
                'nombre2' => null,
                'apellido1' => 'López',
                'apellido2' => 'Ruiz',
                'genero_id' => $generos[1],
                'departamento_id' => $departamentos[1],
                'municipio_id' => $municipios[2],
                'correo' => 'maria.lopez@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tipo_documento_id' => $tipos[1],
                'numero_documento' => '200000001',
                'nombre1' => 'Carlos',
                'nombre2' => 'Andrés',
                'apellido1' => 'Santos',
                'apellido2' => null,
                'genero_id' => $generos[0],
                'departamento_id' => $departamentos[2],
                'municipio_id' => $municipios[4],
                'correo' => 'carlos.santos@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tipo_documento_id' => $tipos[0],
                'numero_documento' => '100000003',
                'nombre1' => 'Luisa',
                'nombre2' => 'Fernanda',
                'apellido1' => 'Martínez',
                'apellido2' => 'Paz',
                'genero_id' => $generos[1],
                'departamento_id' => $departamentos[3],
                'municipio_id' => $municipios[6],
                'correo' => 'luisa.martinez@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'tipo_documento_id' => $tipos[1],
                'numero_documento' => '200000002',
                'nombre1' => 'Andrés',
                'nombre2' => null,
                'apellido1' => 'García',
                'apellido2' => 'Lozano',
                'genero_id' => $generos[2],
                'departamento_id' => $departamentos[4],
                'municipio_id' => $municipios[8],
                'correo' => 'andres.garcia@example.com',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
