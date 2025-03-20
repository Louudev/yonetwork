<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création de l'utilisateur admin (seulement s'il n'existe pas)
        User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Admin1',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Création du teleconseiller 1 (seulement s'il n'existe pas)
        User::firstOrCreate(
            ['email' => 'teleconseiller1@gmail.com'],
            [
                'name' => 'Teleconseiller1',
                'password' => Hash::make('Teleconseiller123'),
                'role' => 'teleconseillers',
            ]
        );

        // Création du teleconseiller 2 (seulement s'il n'existe pas)
        User::firstOrCreate(
            ['email' => 'teleconseiller2@gmail.com'],
            [
                'name' => 'Teleconseiller2',
                'password' => Hash::make('Teleconseiller223'),
                'role' => 'teleconseillers',
            ]
        );
    }
}
