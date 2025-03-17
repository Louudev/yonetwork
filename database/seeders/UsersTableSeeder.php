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
    {  User::create([
        'name' => 'Super Admin',
        'email' => 'super-admin@example.com',
        'password' => Hash::make('password123'),
        'role' => 'super-admin',
    ]);

    // Créer trois utilisateurs pour le centre d'appel
    User::create([
        'name' => 'Conseiller 1',
        'email' => 'conseiller1@example.com',
        'password' => Hash::make('agent1pass'),
        'role' => 'user',
    ]);

    User::create([
        'name' => 'Conseiller 2',
        'email' => 'conseiller2@example.com',
        'password' => Hash::make('agent2pass'),
        'role' => 'user',
    ]);

    User::create([
        'name' => 'Conseiller 3',
        'email' => 'conseiller3@example.com',
        'password' => Hash::make('agent3pass'),
        'role' => 'user',
    ]);

        //
    }
}
