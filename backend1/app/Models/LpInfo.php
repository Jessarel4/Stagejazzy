<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LpInfo
 * 
 * @property int $id_lp
 * @property string|null $num_LP
 * @property int|null $anne_lp
 * @property int $mois_lp
 * @property int $compteur_lp
 * @property string|null $nom_demandeur
 * @property Carbon|null $date_arrive_destination
 * @property string|null $pj_scan_demande
 * @property Carbon|null $date_insertion
 * @property Carbon|null $date_modification
 * @property int $id_direction
 * @property int $id_produit
 * @property int $id_origine
 * @property int|null $id_user
 * @property int|null $id_user_validateur
 * @property int|null $id_user_direction
 * @property int $id_destination
 * @property int $id_convoyeur
 * @property int|null $id_revenu
 * @property int|null $id_tresor
 * @property int|null $id_pre
 * @property int|null $id_ze
 * @property int|null $id_permis_e
 * 
 * @property Convoyeur $convoyeur
 * @property Destination $destination
 * @property Direction $direction
 * @property Origine $origine
 * @property PermisE|null $permis_e
 * @property Pre|null $pre
 * @property Produit $produit
 * @property Revenu|null $revenu
 * @property Tresor|null $tresor
 * @property User|null $user
 * @property Ze|null $ze
 * @property Collection|Correspondre[] $correspondres
 * @property Collection|Emettre[] $emettres
 *
 * @package App\Models
 */
class LpInfo extends Model
{
	protected $table = 'lp_info';
	protected $primaryKey = 'id_lp';
	public $timestamps = false;

	protected $casts = [
		'anne_lp' => 'int',
		'mois_lp' => 'int',
		'compteur_lp' => 'int',
		'date_arrive_destination' => 'datetime',
		'date_insertion' => 'datetime',
		'date_modification' => 'datetime',
		'id_direction' => 'int',
		'id_produit' => 'int',
		'id_origine' => 'int',
		'id_user' => 'int',
		'id_user_validateur' => 'int',
		'id_user_direction' => 'int',
		'id_destination' => 'int',
		'id_convoyeur' => 'int',
		'id_revenu' => 'int',
		'id_tresor' => 'int',
		'id_pre' => 'int',
		'id_ze' => 'int',
		'id_permis_e' => 'int'
	];

	protected $fillable = [
		'num_LP',
		'anne_lp',
		'mois_lp',
		'compteur_lp',
		'nom_demandeur',
		'date_arrive_destination',
		'pj_scan_demande',
		'date_insertion',
		'date_modification',
		'id_direction',
		'id_produit',
		'id_origine',
		'id_user',
		'id_user_validateur',
		'id_user_direction',
		'id_destination',
		'id_convoyeur',
		'id_revenu',
		'id_tresor',
		'id_pre',
		'id_ze',
		'id_permis_e'
	];

	public function convoyeur()
	{
		return $this->belongsTo(Convoyeur::class, 'id_convoyeur');
	}

	public function destination()
	{
		return $this->belongsTo(Destination::class, 'id_destination');
	}

	public function direction()
	{
		return $this->belongsTo(Direction::class, 'id_direction');
	}

	public function origine()
	{
		return $this->belongsTo(Origine::class, 'id_origine');
	}

	public function permis_e()
	{
		return $this->belongsTo(PermisE::class, 'id_permis_e');
	}

	public function pre()
	{
		return $this->belongsTo(Pre::class, 'id_pre');
	}

	public function produit()
	{
		return $this->belongsTo(Produit::class, 'id_produit');
	}

	public function revenu()
	{
		return $this->belongsTo(Revenu::class, 'id_revenu');
	}

	public function tresor()
	{
		return $this->belongsTo(Tresor::class, 'id_tresor');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user_validateur');
	}

	public function ze()
	{
		return $this->belongsTo(Ze::class, 'id_ze');
	}

	public function correspondres()
	{
		return $this->hasMany(Correspondre::class, 'id_lp');
	}

	public function emettres()
	{
		return $this->hasMany(Emettre::class, 'id_lp');
	}
}
