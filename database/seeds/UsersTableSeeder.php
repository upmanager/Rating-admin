<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'admin',
            'email' => 'admin@rating.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'role' => 0,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'client',
            'email' => 'client@rating.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'role' => 1,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        User::create([
            'name' => 'worker',
            'email' => 'worker@rating.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'role' => 2,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
