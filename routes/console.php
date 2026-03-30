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
    // On prend tout ce qui est <= J+7 (Retards inclus)
    $proches = Materiel::whereDate('date_maintenance', '<=', now()->addDays(7)->toDateString())
                        ->where('status', '!=', 'Maintenance')
                        ->get();

    if ($proches->isNotEmpty()) {
        $admins = User::where('isAdmin', true)->get(); 
        
        foreach ($proches as $m) {
            $dateMaint = $m->date_maintenance;
            $today = now()->startOfDay();
            
            $label = "PROCHE";
            $color = "blue";
            if ($dateMaint->lt($today)) {
                $label = "RETARD";
                $color = "red";
            } elseif ($dateMaint->equalTo($today)) {
                $label = "AUJOURD'HUI";
                $color = "orange";
            } 
            
            $data = [
                'message' => "<span class='fw-bold' style='color: $color'>[$label] Maintenance : " . $m->nom . " (Échéance : " . $dateMaint->format('d/m/Y') . ")</span>",
                'link' => route('materiels.show', $m), 
                'type' => 'maintenance',
                'color' => $color
            ];

            foreach ($admins as $admin) {
                // $dejaNotifie = $admin->unreadNotifications()
                //                      ->where('data->message', 'like', "%".$m->nom."%")
                //                      ->exists();
                                     
                // if (!$dejaNotifie) {
                    $admin->notify(new MaterielNotification($data));
                // }
            }
        }
    }
})->dailyAt('10:00')->timezone("Africa/Casablanca");