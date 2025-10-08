<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departamentos = [
            ['nombre' => 'Antioquia', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cundinamarca', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Valle del Cauca', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Boyacá', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Atlántico', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('departamentos')->insert($departamentos);
    }
}
