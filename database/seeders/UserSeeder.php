<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin UMKM Kita',
                'password' => Hash::make('12345678'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'penjual@gmail.com'],
            [
                'name'     => 'Penjual Contoh',
                'password' => Hash::make('12345678'),
                'role'     => 'penjual',
            ]
        );
    }
}