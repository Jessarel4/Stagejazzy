<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Revenu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LpInfo;



class RevenuController extends Controller
{


    









    public function getRevenusThisWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
    
        $revenus = DB::table('revenu')
            ->selectRaw('DATE(lp_info.date_arrive_destination) as date, SUM(revenu.redevance) as total_revenus') // Utiliser `redevance` ici
            ->join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
            ->whereBetween('lp_info.date_arrive_destination', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->get();
    
        return response()->json($revenus);
    }
    

    public function getRevenusThisMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    $revenus = DB::table('revenu')
        ->selectRaw('DATE(lp_info.date_arrive_destination) as date, SUM(revenu.redevance) as total_revenus') // Utiliser `redevance` ou `ristourne` selon ton besoin
        ->join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->whereBetween('lp_info.date_arrive_destination', [$startOfMonth, $endOfMonth])
        ->groupBy('date')
        ->get();

    return response()->json($revenus);
}








      // Méthode pour obtenir les redevances avec les dates d'émission
      public function getRedevances()
      {
          try {
              // Récupérer les redevances et les dates d'émission
              $redevances = Revenu::select('date_emission_ov as date', 'redevance')
                                  ->whereNotNull('redevance') // S'assurer qu'il y a des redevances
                                  ->get();
  
              // Retourner les données sous forme de JSON
              return response()->json($redevances, 200);
          } catch (\Exception $e) {
              return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);
          }
      }





    // Méthode pour obtenir les ristournes avec les dates d'émission
    public function getRistourne()
    {
        try {
            // Récupérer les ristournes et les dates d'émission
            $ristournes = Revenu::select('date_emission_ov as date', 'ristourne')
                                ->whereNotNull('ristourne') // S'assurer qu'il y a des ristournes
                                ->get();

            // Retourner les données sous forme de JSON
            return response()->json($ristournes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);
        }
    }

    





    public function getCurrentMonthRevenus()
{
    $currentMonth = now()->month;
    $revenus = Revenu::whereMonth('date_emission_ov', $currentMonth)->get();
    return response()->json($revenus);
}

public function getPreviousMonthRevenus()
{
    $previousMonth = now()->subMonth()->month;
    $revenus = Revenu::whereMonth('date_emission_ov', $previousMonth)->get();
    return response()->json($revenus);
}

    public function getRevenus()
    {
        try {
            $revenus = Revenu::selectRaw('
                DATE_FORMAT(date_emission_ov, "%Y-%m-%d") as date,
                SUM(redevance) as redevance,
                SUM(ristourne) as ristourne
            ')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

            // Transforme les données pour qu'elles correspondent au format attendu par le frontend
            $formattedData = $revenus->map(function ($revenu) {
                return [
                    'date' => $revenu->date,
                    'revenue' => $revenu->redevance + $revenu->ristourne,
                ];
            });

            return response()->json($formattedData, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);
        }
    }





   public function getTopRevenus(Request $request)
{
    $period = $request->input('period', 'week');
    $weekOffset = (int)$request->input('weekOffset', 0);
    $monthOffset = (int)$request->input('monthOffset', 0);
    $yearOffset = (int)$request->input('yearOffset', 0);

    $query = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('origine', 'lp_info.id_origine', '=', 'origine.id_origine')
        ->join('communes', 'origine.id_commune', '=', 'communes.id_commune');

    $startDate = null;
    $endDate = null;

    if ($period === 'week') {
        $startDate = now()->addWeeks($weekOffset)->startOfWeek()->format('Y-m-d');
        $endDate = now()->addWeeks($weekOffset)->endOfWeek()->format('Y-m-d');
        $query->whereRaw('YEARWEEK(lp_info.date_arrive_destination) = YEARWEEK(CURDATE() + INTERVAL ? WEEK)', [$weekOffset]);
    } elseif ($period === 'month') {
        $startDate = now()->addMonths($monthOffset)->startOfMonth()->format('Y-m-d');
        $endDate = now()->addMonths($monthOffset)->endOfMonth()->format('Y-m-d');
        $query->whereRaw('MONTH(lp_info.date_arrive_destination) = MONTH(CURDATE() + INTERVAL ? MONTH)', [$monthOffset]);
    } elseif ($period === 'year') {
        $startDate = now()->addYears($yearOffset)->startOfYear()->format('Y-m-d');
        $endDate = now()->addYears($yearOffset)->endOfYear()->format('Y-m-d');
        $query->whereRaw('YEAR(lp_info.date_arrive_destination) = YEAR(CURDATE() + INTERVAL ? YEAR)', [$yearOffset]);
    }

    $topRevenus = $query->orderBy('redevance', 'desc')
        ->orderBy('ristourne', 'desc')
        ->take(5)
        ->get(['communes.nom_commune as assiette_rrm', 'redevance', 'ristourne']);

    return response()->json([
        'topRevenus' => $topRevenus,
        'startDate' => $startDate,
        'endDate' => $endDate,
    ]);
}




public function getTopDirections()
{
    $topDirections = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('directions', 'lp_info.id_direction', '=', 'directions.id_direction')
        ->selectRaw('directions.nom_direction, SUM(revenu.redevance) as total_redevance, SUM(revenu.ristourne) as total_ristourne, (SUM(revenu.redevance) + SUM(revenu.ristourne)) as total_revenu')
        ->groupBy('directions.nom_direction')
        ->orderByDesc('total_revenu')
        ->take(3)
        ->get();

    return response()->json($topDirections);
}



public function getTopDirectionsByPeriod(Request $request)
{
    $period = $request->input('period', 'week'); // par défaut, semaine
    $offset = $request->input('offset', 0); // Décalage par rapport à la période actuelle

    $query = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('directions', 'lp_info.id_direction', '=', 'directions.id_direction')
        ->join('produits', 'lp_info.id_produit', '=', 'produits.id_produit') // Ajuste la jointure avec "produits"
        ->selectRaw('directions.nom_direction, SUM(revenu.redevance) as total_redevance, 
            SUM(revenu.ristourne) as total_ristourne, 
            (SUM(revenu.redevance) + SUM(revenu.ristourne)) as total_revenu,
            produits.quantite_en_lettre') // Ajoute la colonne quantite_en_lettre
        ->groupBy('directions.nom_direction')
        ->orderByDesc('total_revenu')
        ->take(3);

    // Calcul des dates de début et de fin de la période
    $startDate = null;
    $endDate = null;

    if ($period === 'week') {
        $startDate = now()->startOfWeek()->addWeeks($offset)->format('Y-m-d');
        $endDate = now()->endOfWeek()->addWeeks($offset)->format('Y-m-d');
        $query->whereRaw('YEARWEEK(lp_info.date_arrive_destination) = YEARWEEK(CURDATE() + INTERVAL ? WEEK)', [$offset]);
    } elseif ($period === 'month') {
        $startDate = now()->startOfMonth()->addMonths($offset)->format('Y-m-d');
        $endDate = now()->endOfMonth()->addMonths($offset)->format('Y-m-d');
        $query->whereRaw('MONTH(lp_info.date_arrive_destination) = MONTH(CURDATE() + INTERVAL ? MONTH)', [$offset]);
    } elseif ($period === 'year') {
        $startDate = now()->startOfYear()->addYears($offset)->format('Y-m-d');
        $endDate = now()->endOfYear()->addYears($offset)->format('Y-m-d');
        $query->whereRaw('YEAR(lp_info.date_arrive_destination) = YEAR(CURDATE() + INTERVAL ? YEAR)', [$offset]);
    }

    $topDirections = $query->get();

    // Ajoute les dates dans les données
    $topDirections->transform(function($item) use ($startDate, $endDate) {
        $item->startDate = $startDate;
        $item->endDate = $endDate;
        return $item;
    });

    return response()->json($topDirections);
}






// public function getTopDirectionsByPeriod(Request $request)
// {
//     $period = $request->input('period', 'week'); // par défaut, semaine
//     $offset = $request->input('offset', 0); // Décalage par rapport à la période actuelle

//     $query = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
//         ->join('directions', 'lp_info.id_direction', '=', 'directions.id_direction')
//         ->selectRaw('directions.nom_direction, SUM(revenu.redevance) as total_redevance, SUM(revenu.ristourne) as total_ristourne, (SUM(revenu.redevance) + SUM(revenu.ristourne)) as total_revenu')
//         ->groupBy('directions.nom_direction')
//         ->orderByDesc('total_revenu')
//         ->take(3);

//     // Calcul des dates de début et de fin de la période
//     $startDate = null;
//     $endDate = null;

//     if ($period === 'week') {
//         $startDate = now()->startOfWeek()->addWeeks($offset)->format('Y-m-d');
//         $endDate = now()->endOfWeek()->addWeeks($offset)->format('Y-m-d');
//         $query->whereRaw('YEARWEEK(lp_info.date_arrive_destination) = YEARWEEK(CURDATE() + INTERVAL ? WEEK)', [$offset]);
//     } elseif ($period === 'month') {
//         $startDate = now()->startOfMonth()->addMonths($offset)->format('Y-m-d');
//         $endDate = now()->endOfMonth()->addMonths($offset)->format('Y-m-d');
//         $query->whereRaw('MONTH(lp_info.date_arrive_destination) = MONTH(CURDATE() + INTERVAL ? MONTH)', [$offset]);
//     } elseif ($period === 'year') {
//         $startDate = now()->startOfYear()->addYears($offset)->format('Y-m-d');
//         $endDate = now()->endOfYear()->addYears($offset)->format('Y-m-d');
//         $query->whereRaw('YEAR(lp_info.date_arrive_destination) = YEAR(CURDATE() + INTERVAL ? YEAR)', [$offset]);
//     }

//     $topDirections = $query->get();

//     // Ajoute les dates dans les données
//     $topDirections->transform(function($item) use ($startDate, $endDate) {
//         $item->startDate = $startDate;
//         $item->endDate = $endDate;
//         return $item;
//     });

//     return response()->json($topDirections);
// }


    
    public function getRistournesData()
    {
        $totalRistournes = Revenu::sum('ristourne');
    
        $chartData = Revenu::selectRaw('DAYNAME(date_emission_ov) as day, DAYOFWEEK(date_emission_ov) as dayOfWeek, SUM(ristourne) as total')
            ->groupBy('day', 'dayOfWeek')
            ->orderBy('dayOfWeek')
            ->get();
    
        return response()->json([
            'totalRistournes' => $totalRistournes,
            'chartData' => $chartData
        ]);
    }


    public function getTopZeByPeriod(Request $request)
{
    $period = $request->input('period', 'week'); // par défaut, semaine

    $query = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze') // Join avec la table ze
        ->selectRaw('ze.nom_ze, SUM(revenu.redevance) as total_redevance, SUM(revenu.ristourne) as total_ristourne')
        ->groupBy('ze.nom_ze')
        ->orderByDesc('total_redevance')
        ->orderByDesc('total_ristourne')
        ->take(5);

    // Calcul des dates de début et de fin de la période
    $startDate = null;
    $endDate = null;

    if ($period === 'week') {
        $startDate = now()->startOfWeek()->format('Y-m-d');
        $endDate = now()->endOfWeek()->format('Y-m-d');
        $query->whereRaw('YEARWEEK(revenu.date_emission_ov) = YEARWEEK(CURDATE())');
    } elseif ($period === 'month') {
        $startDate = now()->startOfMonth()->format('Y-m-d');
        $endDate = now()->endOfMonth()->format('Y-m-d');
        $query->whereRaw('MONTH(revenu.date_emission_ov) = MONTH(CURDATE())');
    } elseif ($period === 'year') {
        $startDate = now()->startOfYear()->format('Y-m-d');
        $endDate = now()->endOfYear()->format('Y-m-d');
        $query->whereRaw('YEAR(revenu.date_emission_ov) = YEAR(CURDATE())');
    }

    $topZeRevenus = $query->get();

    return response()->json([
        'topZeRevenus' => $topZeRevenus,
        'startDate' => $startDate,
        'endDate' => $endDate,
    ]);
}



public function getTopZeData()
{
    $topZeData = DB::table('lp_info')
        ->join('revenu', 'lp_info.id_revenu', '=', 'revenu.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->select('ze.nom_ze', DB::raw('SUM(ristourne) as total_ristourne'), DB::raw('SUM(redevance) as total_redevance'))
        ->groupBy('ze.id_ze', 'ze.nom_ze')
        ->orderByDesc('total_ristourne') // Ou autre critère de tri si nécessaire
        ->take(5) // Limiter à 5 résultats si souhaité
        ->get();

    return response()->json([
        'topZeData' => $topZeData
    ]);
}

public function getTopZeByRevenus($periode)
{
    $topZeData = Revenu::join('lp_info', 'revenu.lp_id', '=', 'lp_info.id_lp') // Utiliser le bon nom de colonne
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->select(
            'ze.nom_ze as name',
            DB::raw('SUM(revenu.redevance) as redevance'),
            DB::raw('SUM(revenu.ristourne) as ristourne'),
            DB::raw('SUM(revenu.redevance + revenu.ristourne) as revenu')
        )
        ->groupBy('ze.id_ze', 'ze.nom_ze')
        ->orderByDesc('revenu') // Tri par le revenu total
        ->take(5) // Limiter à 5 résultats
        ->get();

    return response()->json($topZeData);
}



public function getTopZe(Request $request)
{
    $weekOffset = (int)$request->input('weekOffset', 0);
    $startDate = now()->addWeeks($weekOffset)->startOfWeek()->format('Y-m-d');
    $endDate = now()->addWeeks($weekOffset)->endOfWeek()->format('Y-m-d');

    $query = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->whereBetween('lp_info.date_arrive_destination', [$startDate, $endDate]);

    $topZe = $query->select('ze.nom_ze', DB::raw('SUM(revenu.redevance) as total_redevance'), DB::raw('SUM(revenu.ristourne) as total_ristourne'))
        ->groupBy('ze.id_ze', 'ze.nom_ze')
        ->orderBy('total_redevance', 'desc')
        ->orderBy('total_ristourne', 'desc')
        ->take(5)
        ->get();

    return response()->json(['topZe' => $topZe, 'startDate' => $startDate, 'endDate' => $endDate]);
}

public function getTop5RistournesAndRedevancesByZe()
{
    $topZe = Revenu::join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->select(
            'ze.nom_ze', 
            DB::raw('SUM(revenu.redevance) as total_redevance'), 
            DB::raw('SUM(revenu.ristourne) as total_ristourne'),
            DB::raw('YEAR(lp_info.date_arrive_destination) as year'),  // Année
            DB::raw('WEEK(lp_info.date_arrive_destination) as week'),  // Semaine
            DB::raw('DATE_SUB(lp_info.date_arrive_destination, INTERVAL WEEKDAY(lp_info.date_arrive_destination) DAY) as start_of_week'),  // Début de la semaine
            DB::raw('DATE_ADD(DATE_SUB(lp_info.date_arrive_destination, INTERVAL WEEKDAY(lp_info.date_arrive_destination) DAY), INTERVAL 6 DAY) as end_of_week')  // Fin de la semaine
        )
        ->groupBy(
            'ze.id_ze', 
            'ze.nom_ze', 
            'year', 
            'week', 
            'lp_info.date_arrive_destination'  // Ajout de ce champ
        )
        ->orderBy('total_ristourne', 'desc')
        ->orderBy('total_redevance', 'desc')
        ->take(5)
        ->get();

    return response()->json(['topZe' => $topZe]);
}


public function getTopZeByWeek($year, $week)
{
    $topZe = DB::table('revenu')
        ->join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->select(
            'ze.nom_ze',
            DB::raw('SUM(revenu.redevance) as total_redevance'),
            DB::raw('SUM(revenu.ristourne) as total_ristourne'),
            DB::raw('YEAR(lp_info.date_arrive_destination) as year'),
            DB::raw('WEEK(lp_info.date_arrive_destination) as week'),
            DB::raw('DATE_SUB(lp_info.date_arrive_destination, INTERVAL WEEKDAY(lp_info.date_arrive_destination) DAY) as start_of_week'),
            DB::raw('DATE_ADD(DATE_SUB(lp_info.date_arrive_destination, INTERVAL WEEKDAY(lp_info.date_arrive_destination) DAY), INTERVAL 6 DAY) as end_of_week')
        )
        ->whereYear('lp_info.date_arrive_destination', '=', $year)
        ->whereRaw('WEEK(lp_info.date_arrive_destination) = ?', [$week])
        ->groupBy('ze.id_ze', 'ze.nom_ze', 'year', 'week')
        ->orderBy('total_ristourne', 'desc')
        ->orderBy('total_redevance', 'desc')
        ->limit(5)
        ->get();

    return response()->json(['topZe' => $topZe]);
}


// Pour récupérer les données par mois
public function getTopZeByMonth($year, $month)
{
    $topZe = DB::table('revenu')
        ->join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->select(
            'ze.nom_ze',
            DB::raw('SUM(revenu.redevance) as total_redevance'),
            DB::raw('SUM(revenu.ristourne) as total_ristourne'),
            DB::raw('YEAR(lp_info.date_arrive_destination) as year'),
            DB::raw('MONTH(lp_info.date_arrive_destination) as month')
        )
        ->whereYear('lp_info.date_arrive_destination', '=', $year)
        ->whereMonth('lp_info.date_arrive_destination', '=', $month)
        ->groupBy('ze.id_ze', 'ze.nom_ze', 'year', 'month')
        ->orderBy('total_ristourne', 'desc')
        ->orderBy('total_redevance', 'desc')
        ->limit(5)
        ->get();

    return response()->json(['topZe' => $topZe]);
}

// Pour récupérer les données par année
public function getTopZeByYear($year)
{
    $topZe = DB::table('revenu')
        ->join('lp_info', 'revenu.id_revenu', '=', 'lp_info.id_revenu')
        ->join('ze', 'lp_info.id_ze', '=', 'ze.id_ze')
        ->join('produits', 'lp_info.id_produit', '=', 'produits.id_produit') // Ajuste la jointure avec "produits"
       
        ->select(
            'ze.nom_ze',
            DB::raw('SUM(revenu.redevance) as total_redevance'),
            DB::raw('SUM(revenu.ristourne) as total_ristourne'),
            'produits.quantite_en_lettre'
        )
        
        ->whereYear('lp_info.date_arrive_destination', '=', $year)
        ->groupBy('ze.id_ze', 'ze.nom_ze')
        ->orderBy('total_ristourne', 'desc')
        ->orderBy('total_redevance', 'desc')
        ->limit(5)
        ->get();

    return response()->json(['topZe' => $topZe]);
}


public function getTopPermis()
{
    $revenus = Revenu::join('lp_info', 'revenu.id_lp_info', '=', 'lp_info.id_lp_info')
        ->join('permis_e', 'lp_info.id_permis_e', '=', 'permis_e.id_permis_e') // Jointure avec la table `permis_e`
        ->selectRaw('permis_e.id_permis_e, permis_e.titre_permis_e, SUM(redevance) as total_redevance, SUM(ristourne) as total_ristourne, WEEK(date_emission_ov) as semaine')
        ->groupBy('permis_e.id_permis_e', 'permis_e.titre_permis_e', 'semaine') // Ajoutez les autres colonnes de sélection dans le group by
        ->orderBy('total_redevance', 'DESC')
        ->take(5)
        ->get();

    return response()->json($revenus);
}


public function getTopPermisByrevenu(Request $request)
{
    $periode = $request->input('periode', 'semaine'); // par défaut, la semaine
    $dateRange = $this->getDateRangeForPeriode($periode);

    // Définir les variables $startDate et $endDate
    $startDate = $dateRange['start'];
    $endDate = $dateRange['end'];

    // Récupérer les 5 meilleurs PermisE par ristourne et redevance
    $topPermis = DB::table('lp_info')
        ->join('revenu', 'lp_info.id_revenu', '=', 'revenu.id_revenu') // Ajustez cette ligne en fonction de vos colonnes
        ->join('permis_e', 'lp_info.id_permis_e', '=', 'permis_e.id_permis_e')
        ->whereBetween('lp_info.date_insertion', [$startDate, $endDate])
        ->orderBy('revenu.redevance', 'desc')
        ->orderBy('revenu.ristourne', 'desc')
        ->limit(5)
        ->get();
    
    return response()->json($topPermis);
}

private function getDateRangeForPeriode($periode)
{
    $now = Carbon::now();

    switch ($periode) {
        case 'semaine':
            $start = $now->startOfWeek();
            $end = $now->endOfWeek();
            break;
        case 'mois':
            $start = $now->startOfMonth();
            $end = $now->endOfMonth();
            break;
        case 'annee':
            $start = $now->startOfYear();
            $end = $now->endOfYear();
            break;
        default:
            $start = $now->startOfWeek();
            $end = $now->endOfWeek();
    }

    return ['start' => $start, 'end' => $end];
}






}
