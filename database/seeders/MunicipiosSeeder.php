<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener los IDs de los departamentos por nombre
        $antioquia    = DB::table('departamentos')->where('nombre', 'Antioquia')->value('id');
        $cundinamarca = DB::table('departamentos')->where('nombre', 'Cundinamarca')->value('id');
        $valle        = DB::table('departamentos')->where('nombre', 'Valle del Cauca')->value('id');
        $boyaca       = DB::table('departamentos')->where('nombre', 'Boyacá')->value('id');
        $atlantico    = DB::table('departamentos')->where('nombre', 'Atlántico')->value('id');

        $municipios = [
            // Antioquia
            ['departamento_id' => $antioquia, 'nombre' => 'Medellín', 'created_at' => now(), 'updated_at' => now()],
            ['departamento_id' => $antioquia, 'nombre' => 'Envigado', 'created_at' => now(), 'updated_at' => now()],

            // Cundinamarca
            ['departamento_id' => $cundinamarca, 'nombre' => 'Bogotá', 'created_at' => now(), 'updated_at' => now()],
            ['departamento_id' => $cundinamarca, 'nombre' => 'Chía', 'created_at' => now(), 'updated_at' => now()],

            // Valle del Cauca
            ['departamento_id' => $valle, 'nombre' => 'Cali', 'created_at' => now(), 'updated_at' => now()],
            ['departamento_id' => $valle, 'nombre' => 'Palmira', 'created_at' => now(), 'updated_at' => now()],

            // Boyacá
            ['departamento_id' => $boyaca, 'nombre' => 'Tunja', 'created_at' => now(), 'updated_at' => now()],
            ['departamento_id' => $boyaca, 'nombre' => 'Duitama', 'created_at' => now(), 'updated_at' => now()],

            // Atlántico
            ['departamento_id' => $atlantico, 'nombre' => 'Barranquilla', 'created_at' => now(), 'updated_at' => now()],
            ['departamento_id' => $atlantico, 'nombre' => 'Soledad', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('municipios')->insert($municipios);
    }
}
