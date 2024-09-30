<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Illuminate\Http\Request;

class LpController extends Controller
{
    // Méthode pour obtenir le nombre total de LP Info
    public function getLpInfo()
    {
        try {
            // Récupérer le nombre total de LP Info avec la date d'insertion
            $totalLpInfos = LpInfo::count();

            // Retourner le total sous forme de JSON
            return response()->json(['total' => $totalLpInfos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);
        }
    }





    
    public function getLpStats()
    {
        // Récupérer les statistiques par semaine
        $lpPerWeek = DB::table('lp_info')
            ->select(DB::raw('WEEK(date_arrive_destination) as week, COUNT(*) as total'))
            ->groupBy('week')
            ->get();
    
        // Récupérer les statistiques par mois
        $lpPerMonth = DB::table('lp_info')
            ->select(DB::raw('MONTH(date_arrive_destination) as month, COUNT(*) as total'))
            ->groupBy('month')
            ->get();
    
        // Récupérer les statistiques par année
        $lpPerYear = DB::table('lp_info')
            ->select(DB::raw('YEAR(date_arrive_destination) as year, COUNT(*) as total'))
            ->groupBy('year')
            ->get();
    
        return response()->json([
            'lpPerWeek' => $lpPerWeek,
            'lpPerMonth' => $lpPerMonth,
            'lpPerYear' => $lpPerYear,
        ]);
    }
    

}
