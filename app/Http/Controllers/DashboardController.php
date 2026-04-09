<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Unite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{
    
    public function index(){
        $user = Auth::user();
        $unitId = $user->unite_id;

        $totalMateriels = Materiel::where('unite_id', $unitId)->count();
        $totalUnites = Unite::count();
        $enPanne = Materiel::where('unite_id', $unitId)->where('status', 'En panne')->count();
        $enMaintenance = Materiel::where('unite_id', $unitId)->where('status', 'Maintenance')->count();


        $statusDistribution = Materiel::where('unite_id', $unitId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topUnites = Unite::withCount('materiels')
            ->orderBy('materiels_count', 'desc')
            ->take(5)
            ->get();

        $maintenancesUrgent = Materiel::where('unite_id', $unitId)
            ->whereDate('date_maintenance', '<=', now()->addDays(7))
            ->where('status', '!=', 'Maintenance')
            ->orderBy('date_maintenance')
            ->get();

        $pannesFrequentes = DB::table('mouvements')
            ->join('materiels', 'mouvements.materiel_id', '=', 'materiels.id')
            ->select('materiel_id', DB::raw('COUNT(*) as total_pannes'))
            ->where('materiels.unite_id', $unitId)
            ->where('mouvements.type', 'Panne')
            ->groupBy('materiel_id')
            ->orderByDesc('total_pannes')
            ->limit(5)
            ->get();

        $pannesFrequentes = $pannesFrequentes->map(function ($item) {
                                $materiel = Materiel::find($item->materiel_id);
                                return [
                                    'nom' => $materiel ? $materiel->nom : 'N/A',
                                    'total' => $item->total_pannes
                                ];
                            });


        $frequenceUsage = DB::table('mouvements')
            ->join('materiels', 'mouvements.materiel_id', '=', 'materiels.id')
            ->select('materiel_id', DB::raw('COUNT(*) as total_usage'))
            ->where('materiels.unite_id', $unitId)
            ->where('mouvements.type', 'Sortie')
            ->groupBy('materiel_id')
            ->orderByDesc('total_usage')
            ->limit(5)
            ->get();

        $frequenceUsage = $frequenceUsage->map(function ($item) {
                            $materiel = Materiel::find($item->materiel_id);
                            return [
                                'nom' => $materiel ? $materiel->nom : 'N/A',
                                'total' => $item->total_usage
                            ];
                        });                                    

        return view('dashboard', compact(
            'totalMateriels',
            'totalUnites',
            'enPanne', 
            'enMaintenance', 
            'statusDistribution', 
            'topUnites',
            'maintenancesUrgent',
            'pannesFrequentes',
            'frequenceUsage'
        ));

    }
    
}