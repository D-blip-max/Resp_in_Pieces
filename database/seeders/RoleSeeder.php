<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::create(['name' => 'ADMINISTRADOR']);
        $administrativo = Role::create(['name' => 'ADMINISTRATIVO']);    
        $docente = Role::create(['name' => 'DOCENTE']);
        $estudiante = Role::create(['name' => 'ESTUDIANTE']);

         // --- PERMISOS PARA LA CONFIGURACIÓN DEL SISTEMA ---
        Permission::create(['name' => 'admin.configuracion.index'])->syncRoles($admin);
        Permission::create(['name' => 'admin.configuracion.crear'])->syncRoles($admin);

         // --- PERMISOS PARA NIVELES ---
        Permission::create(['name' => 'admin.niveles.index'])->syncRoles($admin);
        Permission::create(['name' => 'admin.niveles.create'])->syncRoles($admin);
        Permission::create(['name' => 'admin.niveles.update'])->syncRoles($admin);
        Permission::create(['name' => 'admin.niveles.destroy'])->syncRoles($admin);

        // --- PERMISOS PARA ROLES ---
        Permission::create(['name' => 'admin.roles.index'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.create'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.store'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.edit'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.update'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.destroy'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.permisos'])->syncRoles($admin);
        Permission::create(['name' => 'admin.roles.update_permisos'])->syncRoles($admin);

          // --- PERMISOS PARA ESTUDIANTES ---
        Permission::create(['name' => 'admin.estudiantes.index'])->syncRoles($admin);
        Permission::create(['name' => 'admin.estudiantes.create'])->syncRoles($admin);
        Permission::create(['name' => 'admin.estudiantes.store'])->syncRoles($admin);
        Permission::create(['name' => 'admin.estudiantes.show'])->syncRoles($admin);
        Permission::create(['name' => 'admin.estudiantes.edit'])->syncRoles($admin);
        Permission::create(['name' => 'admin.estudiantes.update'])->syncRoles($admin);
        Permission::create(['name' => 'admin.estudiantes.destroy'])->syncRoles($admin);

        
    }
}
