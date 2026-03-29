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

    public function run(): void{
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

        $u1 = Unite::create([
            'nom' => 'Bureau Informatique',
            'ville' => 'Rabat',
            'type' => 'Bureau',
            'parent_id' => $direction->id,
            'description' => 'Gestion du parc IT'
        ]);

        $uLogistique = Unite::create([
            'nom' => 'Service Logistique',
            'ville' => 'Rabat',
            'type' => 'Bureau',
            'parent_id' => $direction->id,
        ]);

        $u2 = Unite::create([
            'nom' => 'Caserne Centrale Nord',
            'ville' => 'Tanger',
            'type' => 'Caserne',
            'parent_id' => $direction->id,
            'description' => 'Dépôt principal du Nord'
        ]);

        $u3 = Unite::create([
            'nom' => 'Centre de Formation',
            'ville' => 'Kenitra',
            'type' => 'Centre',
            'parent_id' => $u1->id,
        ]);


        $f1 = Famille::create(['nomFam' => 'Informatique']);
        $sfPc = SousFamille::create(['nomSousFam' => 'PC Portables', 'famille_id' => $f1->id]);
        $sfEcran = SousFamille::create(['nomSousFam' => 'Écrans', 'famille_id' => $f1->id]);
        $sfImp = SousFamille::create(['nomSousFam' => 'Imprimantes', 'famille_id' => $f1->id]);

        $f2 = Famille::create(['nomFam' => 'Mobilier']);
        $sfChaise = SousFamille::create(['nomSousFam' => 'Chaises Ergonomiques', 'famille_id' => $f2->id]);
        $sfBureau = SousFamille::create(['nomSousFam' => 'Bureaux', 'famille_id' => $f2->id]);

        $f3 = Famille::create(['nomFam' => 'Transport']);
        $sfAuto = SousFamille::create(['nomSousFam' => 'Véhicules Légers', 'famille_id' => $f3->id]);


        Materiel::create([
            'nom' => 'MacBook Pro M2 - IT01',
            'description' => 'Poste développeur principal',
            'unite_id' => $u1->id,
            'sous_famille_id' => $sfPc->id,
            'status' => 'Disponible',
            'date_maintenance' => now()->addDays(7)->toDateString()
        ]);

        Materiel::create([
            'nom' => 'Dell Latitude 5430',
            'description' => 'Ordinateur de gestion',
            'unite_id' => $u1->id,
            'sous_famille_id' => $sfPc->id,
            'status' => 'Sorti',
            'date_maintenance' => now()->addMonths(6)->toDateString()
        ]);

        Materiel::create([
            'nom' => 'HP Laserjet Pro 400',
            'description' => 'Bourrage papier fréquent',
            'unite_id' => $u2->id,
            'sous_famille_id' => $sfImp->id,
            'status' => 'En panne',
            'date_maintenance' => now()->subDays(5)->toDateString()
        ]);

        Materiel::create([
            'nom' => 'Table de réunion Oval',
            'description' => 'Salle de conférence A',
            'unite_id' => $direction->id,
            'sous_famille_id' => $sfBureau->id,
            'status' => 'Disponible'
        ]);

        for ($i = 1; $i <= 6; $i++) {
            Materiel::create([
                'nom' => "Chaise Herman Miller #0$i",
                'description' => "Lot de chaises confort luxe",
                'unite_id' => $direction->id,
                'sous_famille_id' => $sfChaise->id,
                'status' => 'Disponible'
            ]);
        }

        Materiel::create([
            'nom' => 'Dacia Duster - Service',
            'description' => 'Révision des 50.000 km',
            'unite_id' => $uLogistique->id,
            'sous_famille_id' => $sfAuto->id,
            'status' => 'Maintenance',
            'date_maintenance' => now()->addDays(7)->toDateString()
        ]);
    }

}