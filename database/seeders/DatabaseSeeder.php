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

        $direction = Unite::create([
            'nom' => 'Direction Générale', 
            'ville' => 'Rabat', 
            'type' => 'Direction',
            'description' => 'Siège principal'
        ]);

        // Unités rattachées à la direction
        $u1 = Unite::create([
            'nom' => 'Bureau Informatique', 
            'ville' => 'Rabat', 
            'type' => 'Bureau',
            'parent_id' => $direction->id,
            'description' => 'Gestion du parc IT'
        ]);

        $u2 = Unite::create([
            'nom' => 'Caserne Centrale', 
            'ville' => 'Casablanca', 
            'type' => 'Caserne',
            'parent_id' => $direction->id,
            'description' => 'Dépôt principal du matériel'
        ]);

        // --- SEEDER FAMILLES & SOUS-FAMILLES (Identique à ton style) ---

        $f1 = Famille::create(['nomFam' => 'Informatique']);
        SousFamille::create([
            'nomSousFam' => 'PC Portables', 
            'famille_id' => $f1->id
        ]);
        SousFamille::create([
            'nomSousFam' => 'Écrans', 
            'famille_id' => $f1->id
        ]);
        
        $f2 = Famille::create(['nomFam' => 'Mobilier']);
        SousFamille::create([
            'nomSousFam' => 'Chaises Ergonomiques', 
            'famille_id' => $f2->id
        ]);
        SousFamille::create([
            'nomSousFam' => 'Bureaux', 
            'famille_id' => $f2->id
        ]);
    }
}