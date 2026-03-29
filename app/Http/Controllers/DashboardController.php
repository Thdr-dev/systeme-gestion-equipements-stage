<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Unite;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{
    
    public function index(){

        $totalMateriels = Materiel::count();
        $totalUnites = Unite::count();
        $enPanne = Materiel::where('status', 'En panne')->count();
        $enMaintenance = Materiel::where('status', 'Maintenance')->count();


        $statusDistribution = Materiel::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topUnites = Unite::withCount('materiels')
            ->orderBy('materiels_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalMateriels',
            'totalUnites',
            'enPanne', 
            'enMaintenance', 
            'statusDistribution', 
            'topUnites'
        ));

    }
    
}