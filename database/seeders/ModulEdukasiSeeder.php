<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModulEdukasi;
use App\Models\User;
use Carbon\Carbon;

class ModulEdukasiSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('peran', 'edukator')->first();
        $userId = $user ? $user->id : 1;

        ModulEdukasi::create([
            'judul' => 'Modul Tenun Uis Nipes',
            'penulis_id' => $userId,
            'status' => 'diterbitkan',
            'created_at' => Carbon::create(2023, 10, 12),
            'updated_at' => Carbon::create(2023, 10, 12),
        ]);

        ModulEdukasi::create([
            'judul' => 'Filosofi Ukiran Gerga',
            'penulis_id' => $userId,
            'status' => 'menunggu_persetujuan',
            'created_at' => Carbon::create(2023, 10, 15),
            'updated_at' => Carbon::create(2023, 10, 15),
        ]);

        ModulEdukasi::create([
            'judul' => 'Pengenalan Aksara Karo',
            'penulis_id' => $userId,
            'status' => 'draf',
            'created_at' => Carbon::create(2023, 10, 18),
            'updated_at' => Carbon::create(2023, 10, 18),
        ]);
    }
}
