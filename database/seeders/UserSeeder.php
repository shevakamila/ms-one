<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->name = 'User ' . ($i + 1);
            $user->email = 'user' . ($i + 1) . '@example.com';
            $user->username = 'Username' . ($i + 1);
            $user->password = Hash::make('password');
            $user->role = rand(0, 1) ? 'admin' : 'pengguna';
            $user->save();
        }
    }
}
