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
            //<editor-fold desc="User Permissions">
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
            //</editor-fold>

            //<editor-fold desc="User Role Permission">
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
            //</editor-fold>

            //<editor-fold desc="Country Permission">
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
            //</editor-fold>

            //<editor-fold desc="City Permission">
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
            //</editor-fold>

            //<editor-fold desc="Property Types Permissions">
            [
                'name'        => "property-type-list",
                'description' => "Listar Tipos de Propiedades"
            ],
            [
                'name'        => "property-type-create",
                'description' => "Crear Tipo de Propiedad"
            ],
            [
                'name'        => "property-type-show",
                'description' => "Mostrar Tipo de Propiedad"
            ],
            [
                'name'        => "property-type-edit",
                'description' => "Editar Tipo de Propiedad"
            ],
            [
                'name'        => "property-type-status",
                'description' => "Cambiar Tipo de Propiedad"
            ],
            [
                'name'        => "property-type-delete",
                'description' => "Eliminar Tipo de Propiedad"
            ],
            //</editor-fold>

            //<editor-fold desc="Property Status Permission">
            [
                'name'        => "property-status-list",
                'description' => "Listar Estatus de Propiedades"
            ],
            [
                'name'        => "property-status-create",
                'description' => "Crear Estatus de Propiedad"
            ],
            [
                'name'        => "property-status-show",
                'description' => "Mostrar Estatus de Propiedad"
            ],
            [
                'name'        => "property-status-edit",
                'description' => "Editar Estatus de Propiedad"
            ],
            [
                'name'        => "property-status-status",
                'description' => "Cambiar Estatus de Propiedad"
            ],
            [
                'name'        => "property-status-delete",
                'description' => "Eliminar Estatus de Propiedad"
            ],
            //</editor-fold>

            //<editor-fold desc="Property Legal Conditions Permission">
            [
                'name'        => "property-legal-list",
                'description' => "Listar Condiciones Legales de Propiedades"
            ],
            [
                'name'        => "property-legal-create",
                'description' => "Crear Condicion Legal de Propiedad"
            ],
            [
                'name'        => "property-legal-show",
                'description' => "Mostrar Condicion Legal de Propiedad"
            ],
            [
                'name'        => "property-legal-edit",
                'description' => "Editar Condicion Legal de Propiedad"
            ],
            [
                'name'        => "property-legal-status",
                'description' => "Cambiar ECondicion Legal de Propiedad"
            ],
            [
                'name'        => "property-legal-delete",
                'description' => "Eliminar Condicion Legal de Propiedad"
            ],
            //</editor-fold>

            //<editor-fold desc="Property Permissions">
            [
                'name'        => "property-list",
                'description' => "Listar Propiedades"
            ],
            [
                'name'        => "property-create",
                'description' => "Crear Propiedad"
            ],
            [
                'name'        => "property-show",
                'description' => "Mostrar Propiedad"
            ],
            [
                'name'        => "property-edit",
                'description' => "Editar Propiedad"
            ],
            [
                'name'        => "property-status",
                'description' => "Cambiar Propiedad"
            ],
            [
                'name'        => "property-delete",
                'description' => "Eliminar Propiedad"
            ],
            //</editor-fold>
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

        //Get all the permissions formatted from the database
        $newPermissions = Permission::pluck('name')->all();
        //Get the admin user
        $adminRole = Role::first();
        //Assign all the permissions to the admin user
        $adminRole->syncPermissions($newPermissions);
    }
}
