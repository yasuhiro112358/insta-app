<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@sample.com',
                'password' => Hash::make('admin'), // Hash
                'role_id' => 1, // admin
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'user31',
                'email' => 'user31@sample.com',
                'password' => Hash::make('11111111'), // Hash
                'role_id' => 2, // user
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'user32',
                'email' => 'user32@sample.com',
                'password' => Hash::make('11111111'), // Hash
                'role_id' => 2, // user
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->user->insert($users);
    }
}
