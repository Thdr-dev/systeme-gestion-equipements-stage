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
    $admins = User::where('isAdmin', true)->get();
    $today = now()->startOfDay();

    $proches = Materiel::whereDate('date_maintenance', '<=', now()->addDays(7)->toDateString())
                        ->where('status', '!=', 'Maintenance')
                        ->get();

    foreach ($proches as $m) {
        $label = "IMMINENT";
        $color = "#17a2b8";
        
        if( $m->date_maintenance->lt($today) ) { 
            $label = "RETARD"; $color = "#dc3545";
        } elseif ($m->date_maintenance->equalTo($today)) { 
            $label = "AUJOURD'HUI"; $color = "#fd7e14";
        }

        $data = [
            'message' => "<span class='fw-bold' style='color: $color'>[$label] Maintenance : " . $m->nom . " (Échéance : " . $m->date_maintenance->format('d/m/Y') . ")</span>",
            'link' => route('materiels.show', $m),
            'type' => 'maintenance',
            'materiel_id' => $m->id
        ];

        foreach ($admins as $admin) {
            $alreadyNotified = $admin->unreadNotifications()
                ->where('data->materiel_id', $m->id)
                ->where('data->type', 'maintenance')
                ->whereDate('created_at', $today)
                ->exists();

            if (!$alreadyNotified) {
                $admin->notify(new MaterielNotification($data));
            }
        }
    }

    $retardsRetour = Materiel::where('status', 'Maintenance')
                                ->whereDate('delai_maintenance', '<', $today)
                                ->get();
                                
    foreach ($retardsRetour as $m) {
        $data = [
            'message' => "<span class='fw-bold' style='color: #dc3545;'>⚠️ RETARD RETOUR : " . $m->nom . " (Prévu le : " . $m->delai_maintenance->format('d/m/Y') . ")</span>",
            'link' => route('materiels.show', $m),
            'type' => 'retard_maintenance',
            'materiel_id' => $m->id
        ];

        foreach ($admins as $admin) {
             $alreadyNotified = $admin->unreadNotifications()
                ->where('data->materiel_id', $m->id)
                ->where('data->type', 'retard_maintenance')
                ->whereDate('created_at', $today)
                ->exists();

            if (!$alreadyNotified) {
                $admin->notify(new MaterielNotification($data));
            }
        }
    }

})->dailyAt('10:00')->timezone("Africa/Casablanca");