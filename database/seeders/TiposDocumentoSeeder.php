<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('tipos_documentos')->insertOrIgnore([
            ['nombre' => 'Cédula de ciudadanía', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Tarjeta de identidad', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
