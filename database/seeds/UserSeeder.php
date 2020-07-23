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
            'firstname'         => "Usuario",
            'lastname'          => "Admin",
            'email'             => "admin@admin.com",
            'email_verified_at' => Carbon::now(),
            'password'          => bcrypt('password'), // password
            'remember_token'    => Str::random(10),
            'code'              => Str::random(8)
        ]);

        // Assign role to user
        $user->assignRole(strtoupper('admin'));
    }
}
