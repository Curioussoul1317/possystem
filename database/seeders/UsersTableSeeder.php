<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  // Add this line
use Illuminate\Support\Facades\Hash; 
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'type' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Unknown@1317'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}