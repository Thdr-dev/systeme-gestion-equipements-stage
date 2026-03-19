<?php

namespace Database\Seeders;

use App\Models\Famille;
use App\Models\SousFamille;
use App\Models\Unite;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'isAdmin' => true,
        ]);

        User::create([
            'nom' => 'User',
            'prenom' => 'Operateur',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'isAdmin' => false,
        ]);

        $u1 = Unite::create(['nom' => 'Bureau Rabat', 'ville' => 'Rabat']);
        $u2 = Unite::create(['nom' => 'Dépôt Casa', 'ville' => 'Casablanca']);

        $f1 = Famille::create(['nomFam' => 'Informatique']);
        SousFamille::create(['nomSousFam' => 'PC Portables', 'famille_id' => $f1->id]);
        SousFamille::create(['nomSousFam' => 'Écrans', 'famille_id' => $f1->id]);
        
        $f2 = Famille::create(['nomFam' => 'Mobilier']);
        SousFamille::create(['nomSousFam' => 'Chaises Ergonomiques', 'famille_id' => $f2->id]);
    }
}