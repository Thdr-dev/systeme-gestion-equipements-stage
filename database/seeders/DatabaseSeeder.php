<?php

namespace Database\Seeders;

use App\Models\Famille;
use App\Models\SousFamille;
use App\Models\Unite;
use App\Models\User;
use App\Models\Materiel;
use App\Models\Mouvement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder{
    public function run(): void {
        $adminUser = User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'isAdmin' => true,
        ]);

        $operateur = User::create([
            'nom' => 'User',
            'prenom' => 'Operateur',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'isAdmin' => false,
        ]);

        $direction = Unite::create(['nom' => 'Direction Générale', 'ville' => 'Rabat', 'type' => 'Direction']);
        $u1 = Unite::create(['nom' => 'Bureau Informatique', 'ville' => 'Rabat', 'type' => 'Bureau', 'parent_id' => $direction->id]);
        $uLogistique = Unite::create(['nom' => 'Service Logistique', 'ville' => 'Rabat', 'type' => 'Bureau', 'parent_id' => $direction->id]);
        $u2 = Unite::create(['nom' => 'Caserne Centrale Nord', 'ville' => 'Tanger', 'type' => 'Caserne', 'parent_id' => $direction->id]);

        $f1 = Famille::create(['nomFam' => 'Informatique']);
        $sfPc = SousFamille::create(['nomSousFam' => 'PC Portables', 'famille_id' => $f1->id]);
        $sfImp = SousFamille::create(['nomSousFam' => 'Imprimantes', 'famille_id' => $f1->id]);
        
        Materiel::create([
            'nom' => 'Scanner Réseau - TEST NOTIF',
            'description' => 'Test automatique de maintenance',
            'unite_id' => $u1->id,
            'sous_famille_id' => $sfPc->id,
            'status' => 'Disponible',
            'date_maintenance' => now()->addDays(7)->toDateString(), // <--- ICI LE TEST
        ]);

        $dell = Materiel::create([
            'nom' => 'Dell Latitude 5430',
            'description' => 'Ordinateur de gestion',
            'unite_id' => $u1->id,
            'sous_famille_id' => $sfPc->id,
            'status' => 'Sorti'
        ]);

        Mouvement::create([
            'materiel_id' => $dell->id,
            'user_id' => $operateur->id,
            'unite_id' => $u1->id,
            'type' => 'Sortie',
            'commentaire' => 'Attribué au seeder'
        ]);

        Materiel::create([
            'nom' => 'HP Laserjet Pro 400',
            'description' => 'Bourrage papier fréquent',
            'unite_id' => $u2->id,
            'sous_famille_id' => $sfImp->id,
            'status' => 'En panne'
        ]);

        Materiel::create([
            'nom' => 'MacBook Pro M2 - IT01',
            'unite_id' => $u1->id,
            'sous_famille_id' => $sfPc->id,
            'status' => 'Disponible'
        ]);
    }
}