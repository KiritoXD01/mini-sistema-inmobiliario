<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission array list
        $permissions = [
            // User permissions /////////////////
            [
                'name'        => "user-list",
                'description' => "Listar Usuarios"
            ],
            [
                'name'        => "user-create",
                'description' => "Crear Usuario"
            ],
            [
                'name'        => "user-show",
                'description' => "Mostrar Usuario"
            ],
            [
                'name'        => "user-edit",
                'description' => "Editar Usuario"
            ],
            [
                'name'        => "user-status",
                'description' => "Cambiar estado de Usuario"
            ],
            [
                'name'        => "user-delete",
                'description' => "Eliminar Usuario"
            ],
            // End User permissions /////////////////

            // Role Permission /////////////////////
            [
                'name'        => "user-role-list",
                'description' => "Listar roles de usuario"
            ],
            [
                'name'        => "user-role-create",
                'description' => "Crear Rol de Usuario"
            ],
            [
                'name'        => "user-role-show",
                'description' => "Mostrar Rol de Usuario"
            ],
            [
                'name'        => "user-role-edit",
                'description' => "Editar Rol de Usuario"
            ],
            [
                'name'        => "user-role-status",
                'description' => "Cambiar estado de Rol de Usuario"
            ],
            [
                'name'        => "user-role-delete",
                'description' => "Eliminar Rol de Usuario"
            ],
            // End Role Permission /////////////////////

            // Country Permission /////////////////////
            [
                'name'        => "country-list",
                'description' => "Listar Paises"
            ],
            [
                'name'        => "country-create",
                'description' => "Crear Pais"
            ],
            [
                'name'        => "country-show",
                'description' => "Mostrar Pais"
            ],
            [
                'name'        => "country-edit",
                'description' => "Editar Pais"
            ],
            [
                'name'        => "country-status",
                'description' => "Cambiar estado de Pais"
            ],
            [
                'name'        => "country-delete",
                'description' => "Eliminar Pais"
            ],
            // End Country Permission /////////////////////

            // City Permission //////////////////////////
            [
                'name'        => "city-list",
                'description' => "Listar Ciudades"
            ],
            [
                'name'        => "city-create",
                'description' => "Crear Ciudad"
            ],
            [
                'name'        => "city-show",
                'description' => "Mostrar Ciudad"
            ],
            [
                'name'        => "city-edit",
                'description' => "Editar Ciudad"
            ],
            [
                'name'        => "city-status",
                'description' => "Cambiar estado de Ciudad"
            ],
            [
                'name'        => "city-delete",
                'description' => "Eliminar Ciudad"
            ],
            // End City Permission //////////////////////////
        ];

        // Take all the permission and loop over them
        foreach ($permissions as $permission) {
            // First verify that the role doesn't exists
            // if it doesn't, create it
            Permission::firstOrCreate([
                'name'        => $permission['name'],
                'description' => $permission['description']
            ]);
        }

        $newPermissions = Permission::pluck('name')->all();
        $adminRole = Role::first();
        $adminRole->syncPermissions($newPermissions);
    }
}
