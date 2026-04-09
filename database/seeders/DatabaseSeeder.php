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


        $direction = Unite::create([
            'nom' => 'Direction Générale de la Protection Civile',
            'ville' => 'Rabat',
            'type' => 'Direction',
            'description' => 'Siège central de la Protection Civile du Maroc'
        ]);

        $etatMajor = Unite::create([
            'nom' => 'Etat-Major Opérationnel',
            'ville' => 'Rabat',
            'type' => 'Commandement',
            'parent_id' => $direction->id,
            'description' => 'Coordination nationale des interventions'
        ]);

        $logistique = Unite::create([
            'nom' => 'Service Logistique et Matériel',
            'ville' => 'Salé',
            'type' => 'Service',
            'parent_id' => $direction->id,
            'description' => 'Gestion du matériel et des équipements'
        ]);

        $caserneCasa = Unite::create([
            'nom' => 'Caserne Régionale Casablanca',
            'ville' => 'Casablanca',
            'type' => 'Caserne',
            'parent_id' => $direction->id,
            'description' => 'Intervention régionale Grand Casablanca'
        ]);

        $centreFormation = Unite::create([
            'nom' => 'Centre de Formation de la Protection Civile',
            'ville' => 'Kénitra',
            'type' => 'Centre',
            'parent_id' => $etatMajor->id,
            'description' => 'Formation des agents et officiers'
        ]);

        User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'isAdmin' => true,
            'unite_id' => 1
        ]);

        User::create([
            'nom' => 'User',
            'prenom' => 'Operateur',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'isAdmin' => false,
            'unite_id' => 1
        ]);




        $data = json_decode(file_get_contents(database_path('data/materiels.json')), true);

        $familles = [];
        $sousFamilles = [];

        foreach ($data as $item) {


            $famName = trim($item['Famille']);

            if (!isset($familles[$famName])) {
                $familles[$famName] = Famille::create([
                    'nomFam' => $famName
                ]);
            }

            $famille = $familles[$famName];


            $sfName = trim($item['Sous famille']);
            $key = $famName . '|' . $sfName;

            if (!isset($sousFamilles[$key])) {
                $sousFamilles[$key] = SousFamille::create([
                    'nomSousFam' => $sfName,
                    'famille_id' => $famille->id
                ]);
            }

            $sousFamille = $sousFamilles[$key];


            $unite = collect([$direction, $logistique, $etatMajor, $caserneCasa, $centreFormation])->random();

            Materiel::create([
                'nom' => trim($item['Article']),
                'description' => 'Matériel opérationnel',
                'unite_id' => $unite->id,
                'sous_famille_id' => $sousFamille->id,
                'status' => 'Disponible'
            ]);
        }
    }

}