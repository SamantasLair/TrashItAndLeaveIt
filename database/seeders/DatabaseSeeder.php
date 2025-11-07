<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lab;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Bansus Admin',
            'email' => 'bansus@ilkom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'bansus',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'mahasiswa@ilkom.ac.id',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'nim' => '2021001',
            'jurusan' => 'Ilmu Komputer',
        ]);

        Lab::create([
            'nama' => 'RPL',
            'kapasitas' => 30,
            'deskripsi' => 'Lab Rekayasa Perangkat Lunak'
        ]);
        
        Lab::create([
            'nama' => 'R1',
            'kapasitas' => 32,
            'deskripsi' => 'Lab Ruang 1'
        ]);

        Lab::create([
            'nama' => 'R2',
            'kapasitas' => 32,
            'deskripsi' => 'Lab Ruang 2'
        ]);

        Lab::create([
            'nama' => 'R3',
            'kapasitas' => 32,
            'deskripsi' => 'Lab Ruang 1'
        ]);

        Lab::create([
            'nama' => 'R4',
            'kapasitas' => 24,
            'deskripsi' => 'Lab Ruang 2'
        ]);
    }
}