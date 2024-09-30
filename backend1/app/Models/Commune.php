<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commune
 * 
 * @property int $id_commune
 * @property string|null $nom_commune
 * @property int|null $id_district
 * 
 * @property District|null $district
 * @property Collection|PermisE[] $permis_es
 * @property Collection|CorrespondrePre[] $correspondre_pres
 * @property Collection|Destination[] $destinations
 * @property Collection|Origine[] $origines
 *
 * @package App\Models
 */
class Commune extends Model
{
	protected $table = 'communes';
	protected $primaryKey = 'id_commune';
	public $timestamps = false;

	protected $casts = [
		'id_district' => 'int'
	];

	protected $fillable = [
		'nom_commune',
		'id_district'
	];

	public function district()
	{
		return $this->belongsTo(District::class, 'id_district');
	}

	public function permis_es()
	{
		return $this->belongsToMany(PermisE::class, 'commune_permis_e', 'id_commune', 'id_permis_e');
	}

	public function correspondre_pres()
	{
		return $this->hasMany(CorrespondrePre::class, 'id_commune');
	}

	public function destinations()
	{
		return $this->hasMany(Destination::class, 'id_commune');
	}

	public function origines()
	{
		return $this->hasMany(Origine::class, 'id_commune');
	}
}
