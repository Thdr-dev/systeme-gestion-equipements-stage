<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Materiel;
use App\Models\User;
use App\Notifications\MaterielNotification;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');




Schedule::call(function () {
    // 1. Récupérer les matériels qui expirent dans exactement 7 jours
    $proches = Materiel::whereDate('date_maintenance', now()->addDays(7))->get();

    foreach ($proches as $m) {
        // 2. Récupérer les admins (vérifie si ta colonne est 'role' ou 'isAdmin')
        $admins = User::where('role', 'admin')->get(); 
        
        foreach ($admins as $admin) {
            $admin->notify(new MaterielNotification([
                'message' => "Maintenance proche (7j) : " . $m->nom,
                'link' => route('materiels.index'), // On a dit qu'on utilisait l'index
                'type' => 'maintenance'
            ]));
        }
    }
})->daily(); // Exécuté une fois par jour