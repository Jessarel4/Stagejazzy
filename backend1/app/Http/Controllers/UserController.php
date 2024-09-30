<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Méthode pour récupérer tous les utilisateurs
    public function index()
    {
        // Récupérer les utilisateurs avec seulement les champs nécessaires
        $users = User::all();
        // Retourner les utilisateurs au format JSON
        return response()->json($users);
    }
}
