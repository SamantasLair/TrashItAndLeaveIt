<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Bansus (Admin)
        User::create([
            'name' => 'Bansus Admin',
            'email' => 'bansus@ilkom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'bansus',
        ]);

        // Create Sample Mahasiswa
        User::create([
            'name' => 'John Doe',
            'email' => 'mahasiswa@ilkom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '2021001',
            'jurusan' => 'Ilmu Komputer',
        ]);
    }
}