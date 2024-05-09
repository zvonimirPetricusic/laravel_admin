<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Moderator',
            'email' => 'moderator@moderator.com',
            'password' => Hash::make('moderator'),
            'role_id' => 2
        ]);
    }
}
