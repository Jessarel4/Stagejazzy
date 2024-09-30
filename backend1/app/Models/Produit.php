<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Produit
 * 
 * @property int $id_produit
 * @property string|null $quantite_en_chiffre
 * @property string|null $unite
 * @property string|null $quantite_en_lettre
 * @property int $id_substance
 * 
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Produit extends Model
{
	protected $table = 'produits';
	protected $primaryKey = 'id_produit';
	public $timestamps = false;

	protected $casts = [
		'id_substance' => 'int'
	];

	protected $fillable = [
		'quantite_en_chiffre',
		'unite',
		'quantite_en_lettre',
		'id_substance'
	];

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_produit');
	}

	// Dans le modèle Produit.php
public function substance()
{
    return $this->belongsTo(Substance::class, 'id_substance', 'id_substance');
}


	
}
