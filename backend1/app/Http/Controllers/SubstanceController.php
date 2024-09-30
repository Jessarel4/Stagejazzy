<?php

namespace App\Http\Controllers;

use App\Models\TypeSubstance;
use Illuminate\Http\Request;
use App\Models\Origine;

class SubstanceController extends Controller
{

    public function getExploitationByOrigine()
    {
        $data = Origine::with(['commune', 'lp_infos.produit.substance'])
            ->get()
            ->map(function ($origine) {
                $totalQuantities = $origine->lp_infos->groupBy('produit.id_substance')->map(function ($group) {
                    $substance = $group->first()->produit->substance;
                    $totalQuantity = $group->sum(function ($item) {
                        return (int) $item->produit->quantite_en_chiffre; // Assurez-vous que c'est le bon champ
                    });

                    return [
                        'id_substance' => $substance->id_substance,
                        'nom_substance' => $substance->nom_substance,
                        'quantite' => $totalQuantity,
                    ];
                });

                return [
                    'id_origine' => $origine->id_origine,
                    'nom_commune' => $origine->commune->nom_commune,
                    'substances' => $totalQuantities->values(),
                ];
            });

        return response()->json($data);
    }







    public function getTopSubstances()
{
    $typeSubstances = TypeSubstance::with(['substances' => function ($query) {
        // Correction du nom de la table
        $query->select('substance.*')
            ->leftJoin('substance_permis_e', 'substance_permis_e.id_substance', '=', 'substance.id_substance')
            ->leftJoin('permis_e', 'substance_permis_e.id_permis_e', '=', 'permis_e.id_permis_e')
            ->selectRaw('SUM(permis_e.quantite_exploitee) as total_exploitation')
            ->groupBy('substance.id_substance')
            ->orderBy('total_exploitation', 'desc')
            ->take(3); // Récupérer les 3 substances les plus exploitées
    }])->get();

    return response()->json($typeSubstances);
}

public function getAllTypeSubstances()
{
    try {
        $typeSubstances = TypeSubstance::with('substances')->get();

        // Retourner les données en format JSON
        return response()->json($typeSubstances, 200);
    } catch (\Exception $e) {
        // Gérer les erreurs en cas de problème lors de la récupération des données
        return response()->json(['error' => 'Erreur lors de la récupération des données'], 500);
    }
}


public function getTopSubstancesWithCommune() {
    $types = ['Pierres précieuses', 'Pierres fines', 'Métaux Précieux', 'Pierres industrielles'];

    $data = [];

    foreach ($types as $type) {
        $substances = Substance::select('substance.nom_substance', 'produits.quantite_en_chiffre', 'produits.unite', 'communes.nom_commune')
            ->join('produits', 'substance.id_substance', '=', 'produits.id_substance')
            ->join('lp_info', 'produits.id_produit', '=', 'lp_info.id_produit')
            ->join('origine', 'lp_info.id_origine', '=', 'origine.id_origine')
            ->join('communes', 'origine.id_commune', '=', 'communes.id_commune')
            ->join('type_substance', 'substance.id_type_substance', '=', 'type_substance.id_type_substance')
            ->where('type_substance.nom_type_substance', $type)
            ->orderByDesc('produits.quantite_en_chiffre')
            ->limit(4)
            ->get();

        $data[$type] = $substances;
    }

    return response()->json($data);
}


public function getTopSubstance()
{
    // Récupérer les 4 substances les plus exploitées pour chaque type de substance
    $topSubstances = TypeSubstance::with(['substances' => function ($query) {
        $query->join('produits', 'substance.id_substance', '=', 'produits.id_substance')
              ->select('substance.nom_substance', 'produits.quantite_en_chiffre', 'produits.unite', 'substance.id_type_substance')
              ->orderBy('produits.quantite_en_chiffre', 'desc')
              ->limit(4);
    }])->get();

    return response()->json($topSubstances);
}



}
