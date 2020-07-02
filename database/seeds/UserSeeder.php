<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
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
        $user = User::create([
            'name'              => "Usuario Admin",
            'email'             => "admin@admin.com",
            'email_verified_at' => Carbon::now(),
            'password'          => bcrypt('password'), // password
            'remember_token'    => Str::random(10),
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
