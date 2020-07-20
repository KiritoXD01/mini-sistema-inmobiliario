<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Role
        if (!Role::where('name', strtoupper('admin'))->exists()) {
            $admin = Role::create([
                'name' => strtoupper('admin')
            ]);
            $permissions = Permission::pluck('id')->all();
            $admin->syncPermissions($permissions);
        }

        //Buyer Role
        if (!Role::where('name', strtoupper('buyer'))->exists()) {
            Role::create([
                'name' => strtoupper('buyer')
            ]);
        }

        //seller Role
        if (!Role::where('name', strtoupper('seller'))->exists()) {
            Role::create([
                'name' => strtoupper('seller')
            ]);
        }
    }
}
