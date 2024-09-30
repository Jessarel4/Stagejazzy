<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Direction
 * 
 * @property int $id_direction
 * @property string|null $nom_direction
 * @property string $type_direction
 * @property string|null $type_directeur
 * @property string|null $sigle_direction
 * @property string|null $lieu_emission
 * @property string|null $circonscription
 * 
 * @property Collection|Emettre[] $emettres
 * @property Collection|LpInfo[] $lp_infos
 * @property Collection|Region[] $regions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Direction extends Model
{
	protected $table = 'directions';
	protected $primaryKey = 'id_direction';
	public $timestamps = false;

	protected $fillable = [
		'nom_direction',
		'type_direction',
		'type_directeur',
		'sigle_direction',
		'lieu_emission',
		'circonscription'
	];

	public function emettres()
	{
		return $this->hasMany(Emettre::class, 'id_direction');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_direction');
	}

	public function regions()
	{
		return $this->hasMany(Region::class, 'id_direction');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'id_direction');
	}
}
