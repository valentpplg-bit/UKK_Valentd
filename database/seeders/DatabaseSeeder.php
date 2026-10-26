<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'adminperpustakaan@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin@2026'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mimin@gmail.com'],
            [
                'name' => 'Mimin',
                'password' => Hash::make('Mimin321'),
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );

    }
}
