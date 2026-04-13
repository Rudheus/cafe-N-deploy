<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Owner Cafe',
            'email' => 'owner@owner.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Pegawai Cafe',
            'email' => 'pegawai@pegawai.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'is_active' => true,
        ]);
    }
}
