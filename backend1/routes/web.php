<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RevenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LpController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubstanceController;


Route::get('/api/users', [UserController::class, 'index']);

Route::get('/test-cors', function () {
    return response()->json(['message' => 'CORS is working!']);
});


Route::get('/api/ristournes-data', [RevenuController::class, 'getRistournesData']);
Route::get('/api/lp-stats', [LpController::class, 'getLpStats']);
Route::get('api/lpinfo', [LpController::class, 'getLpInfo']);

Route::get('api/revenus', [RevenuController::class, 'getRevenus']);
Route::get('api/revenus/current', [RevenuController::class, 'getCurrentMonthRevenus']);
Route::get('api/revenus/previous', [RevenuController::class, 'getPreviousMonthRevenus']);
Route::get('api/ristournes', [RevenuController::class, 'getRistourne']);
Route::get('api/redevances', [RevenuController::class, 'getRedevances']);
Route::get('api/top-ze/{periode}', [RevenuController::class, 'getTopZeByRevenus']);
Route::get('api/ze', [RevenuController::class, 'getTopZe']);
Route::get('api/ze/top5-semaine', [RevenuController::class, 'getTop5ZeParSemaine']);
Route::get('api/ze/top-5-ristournes-redevances', [RevenuController::class, 'getTop5RistournesAndRedevancesByZe']);
Route::get('api/top-ze/{year}/{week}', [RevenuController::class, 'getTopZeByWeek']);
Route::get('api/top-ze-mois/{year}/{month}', [RevenuController::class, 'getTopZeByMonth']);
Route::get('api/top-ze-annee/{year}', [RevenuController::class, 'getTopZeByYear']);
Route::get('api/revenus/this-week', [RevenuController::class, 'getRevenusThisWeek']);
Route::get('api/revenus/this-month', [RevenuController::class, 'getRevenusThisMonth']);
Route::get('api/top-permis', [RevenuController::class, 'getTopPermis']);



//Route::get('/api/top-substances', [SubstanceController::class, 'getTopSubstances']);
// Route pour récupérer toutes les informations des types de substances
Route::get('api/type-substances', [SubstanceController::class, 'getAllTypeSubstances']);
Route::get('api/getTopSubstance', [SubstanceController::class, 'getTopSubstance']);
Route::get('api/top-substancesWithCommune', [SubstanceController::class, 'getTopSubstancesWithCommune']);
Route::get('api/exploitation-by-origine', [SubstanceController::class, 'getExploitationByOrigine']);




Route::post('api/login', [AuthController::class, 'login']);




Route::get('/api/top-revenus', [RevenuController::class, 'getTopRevenus']);



Route::get('/api/getTopDirections', [RevenuController::class, 'getTopDirections']);
Route::get('/api/getTopDirectionsByPeriod', [RevenuController::class, 'getTopDirectionsByPeriod']);
Route::get('/api/getTopZeData', [RevenuController::class, 'getTopZeData']);
Route::get('/api/top-permis', [RevenuController::class, 'getTopPermisByrevenu']);


Route::get('/', function () {
    return view('welcome');
});
