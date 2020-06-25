<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        $user = factory(User::class)->create([
            'email'       => 'admin@admin.com',
            'firstname'   => "Usuario",
            'lastname'    => "Admin",
            'phonenumber' => ""
        ]);

        //Asign role to user
        $user->assignRole(strtoupper('admin'));

        // Get all the roles created except the admin role
        $roles = Role::where('name', '<>', strtoupper('admin'))->get();

        foreach ($roles as $role) {
            $user = factory(User::class)->create();
            $user->assignRole($role['name']);
        }
    }
}
