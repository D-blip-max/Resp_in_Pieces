<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nivel;

class NivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nivel::create(['nombre' => 'Basico']);
        Nivel::create(['nombre' => 'Intermedio']);
        Nivel::create(['nombre' => 'Avanzado']);
    }
}
