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
    $proches = Materiel::whereDate('date_maintenance', now()->addDays(7))->get();

    foreach ($proches as $m) {
        $admins = User::where('isAdmin', true)->get(); 
        
        foreach ($admins as $admin) {
            $admin->notify(new MaterielNotification([
                'message' => "Maintenance proche (7j) : " . $m->nom,
                'link' => route('materiels.index'), 
                'type' => 'maintenance'
            ]));
        }
    }
})->daily();