<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        $this->call(RoleSeeder::class);
        $this->call(NivelSeeder::class);
  
        Configuracion::create([
            'nombre' => 'Cei',
            'descripcion' => 'Curso de Extension de Idiomas',
            'direccion' => 'Ñuflo de Chavez',
            'telefono' => '75657007 - 54646787',
            'divisa' => 'Bs',
            'correo_electronico' => 'cei@gmail.com',
            'web' => 'https://cei.com',
            'logo' => 'uploads/logos/1776896008_Logo_cei.jpg'
        ]);
        
        

    }
}
