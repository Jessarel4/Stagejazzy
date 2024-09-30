<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Substance
 * 
 * @property int $id_substance
 * @property string|null $nom_substance
 * @property int|null $limite_production_substance
 * @property int $id_type_substance
 * 
 * @property TypeSubstance $type_substance
 * @property Collection|PermisE[] $permis_es
 *
 * @package App\Models
 */
class Substance extends Model
{
	protected $table = 'substance';
	protected $primaryKey = 'id_substance';
	public $timestamps = false;

	protected $casts = [
		'limite_production_substance' => 'int',
		'id_type_substance' => 'int'
	];

	protected $fillable = [
		'nom_substance',
		'limite_production_substance',
		'id_type_substance'
	];

	public function type_substance()
	{
		return $this->belongsTo(TypeSubstance::class, 'id_type_substance');
	}

	public function permis_es()
	{
		return $this->belongsToMany(PermisE::class, 'substance_permis_e', 'id_substance', 'id_permis_e');
	}

	

}
