<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
                'description' => "Listar Usuarios",
                'type'        => "Usuario"
            ],
            [
                'name'        => "user-create",
                'description' => "Crear Usuario",
                'type'        => "Usuario"
            ],
            [
                'name'        => "user-show",
                'description' => "Mostrar Usuario",
                'type'        => "Usuario"
            ],
            [
                'name'        => "user-edit",
                'description' => "Editar Usuario",
                'type'        => "Usuario"
            ],
            [
                'name'        => "user-status",
                'description' => "Cambiar estado de Usuario",
                'type'        => "Usuario"
            ],
            [
                'name'        => "user-delete",
                'description' => "Eliminar Usuario",
                'type'        => "Usuario"
            ],
            // End User permissions /////////////////

            // Role Permission /////////////////////
            [
                'name'        => "user-role-list",
                'description' => "Listar roles de usuario",
                'type'        => "Rol de Usuario"
            ],
            [
                'name'        => "user-role-create",
                'description' => "Crear Rol de Usuario",
                'type'        => "Rol de Usuario"
            ],
            [
                'name'        => "user-role-show",
                'description' => "Mostrar Rol de Usuario",
                'type'        => "Rol de Usuario"
            ],
            [
                'name'        => "user-role-edit",
                'description' => "Editar Rol de Usuario",
                'type'        => "Rol de Usuario"
            ],
            [
                'name'        => "user-role-status",
                'description' => "Cambiar estado de Rol de Usuario",
                'type'        => "Rol de Usuario"
            ],
            [
                'name'        => "user-role-delete",
                'description' => "Eliminar Rol de Usuario",
                'type'        => "Rol de Usuario"
            ],
            // End Role Permission /////////////////////
        ];

        // Take all the permission and loop over them
        foreach ($permissions as $permission) {
            // First verify that the role doesn't exists
            // if it doesn't, create it
            Permission::firstOrCreate([
                'name'        => $permission['name'],
                'description' => $permission['description'],
                'type'        => $permission['type']
            ]);
        }
    }
}
