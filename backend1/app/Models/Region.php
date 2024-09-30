<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 * 
 * @property int $id_region
 * @property string|null $nom_region
 * @property int|null $id_direction
 * 
 * @property Direction|null $direction
 * @property Collection|District[] $districts
 * @property Collection|TitulairePre[] $titulaire_pres
 *
 * @package App\Models
 */
class Region extends Model
{
	protected $table = 'regions';
	protected $primaryKey = 'id_region';
	public $timestamps = false;

	protected $casts = [
		'id_direction' => 'int'
	];

	protected $fillable = [
		'nom_region',
		'id_direction'
	];

	public function direction()
	{
		return $this->belongsTo(Direction::class, 'id_direction');
	}

	public function districts()
	{
		return $this->hasMany(District::class, 'id_region');
	}

	public function titulaire_pres()
	{
		return $this->hasMany(TitulairePre::class, 'id_region');
	}
}
