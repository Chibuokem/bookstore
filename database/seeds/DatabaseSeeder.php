<?php

use Illuminate\Database\Seeder;
use App\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->createUser();
        $this->createAdminUser();
    }

    public function createUser()
    { 
        $user = User::create([
            'name' => 'Test user',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('testuserpassword'),
        ]);
    }

    public function createAdminUser(){
        
        $user = User::create([
            'name' => 'Test admin user',
            'email' => 'testadminuser@gmail.com',
            'admin_level' => 1,
            'password' => Hash::make('testadminpassword'),
        ]);
    }
}