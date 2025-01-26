<?php

namespace Database\Seeders;

use App\Models\AdminPermisos;
use App\Models\AdminRole;
use App\Models\AdminUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos básicos
        $permissions = [
            ['name' => 'Ver Dashboard', 'slug' => 'view-dashboard'],
            ['name' => 'Gestionar Usuarios', 'slug' => 'manage-users'],
            ['name' => 'Gestionar Roles', 'slug' => 'manage-roles'],
            ['name' => 'Gestionar Productos', 'slug' => 'manage-products'],
            ['name' => 'Gestionar Pedidos', 'slug' => 'manage-orders'],
            ['name' => 'Ver Reportes', 'slug' => 'view-reports'],
        ];

        foreach ($permissions as $permission) {
            AdminPermisos::create($permission);
        }

        // Crear rol de Super Admin
        $superAdminRole = AdminRole::create([
            'name' => 'Super Admin',
            'description' => 'Rol con acceso completo al sistema'
        ]);

        // Asignar todos los permisos al Super Admin
        $superAdminRole->permissions()->attach(AdminPermisos::all());

        // Crear rol de Gestor
        $managerRole = AdminRole::create([
            'name' => 'Gestor',
            'description' => 'Rol para gestión básica del sistema'
        ]);

        // Asignar permisos específicos al Gestor
        $managerRole->permissions()->attach(
            AdminPermisos::whereIn('slug', [
                'view-dashboard',
                'manage-products',
                'manage-orders',
                'view-reports'
            ])->get()
        );

        // Crear usuario Super Admin por defecto
        AdminUsers::create([
            'role_id' => $superAdminRole->id,
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => Hash::make('admin123'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'is_active' => true
        ]);
    }
}
