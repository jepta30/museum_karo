<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Staf Registrar',
            'email' => 'registrar@museum.com',
            'password' => Hash::make('password123'),
            'peran' => 'pendaftar',
        ]);

        User::create([
            'name' => 'Staf Kurator',
            'email' => 'kurator@museum.com',
            'password' => Hash::make('password123'),
            'peran' => 'kurator',
        ]);

        User::create([
            'name' => 'Kepala Museum',
            'email' => 'pimpinan@museum.com',
            'password' => Hash::make('password123'),
            'peran' => 'pimpinan',
        ]);

        User::create([
            'name' => 'Staf Edukator',
            'email' => 'edukator@museum.com',
            'password' => Hash::make('password123'),
            'peran' => 'edukator',
        ]);
    }
}
