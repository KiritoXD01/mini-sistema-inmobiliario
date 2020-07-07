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
        $admin = Role::create([
            'name' => strtoupper('admin')
        ]);
        $permissions = Permission::pluck('id')->all();
        $admin->syncPermissions($permissions);
    }
}
