<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CommunePermisE
 * 
 * @property int $id_permis_e
 * @property int $id_commune
 * 
 * @property Commune $commune
 * @property PermisE $permis_e
 *
 * @package App\Models
 */
class CommunePermisE extends Model
{
	protected $table = 'commune_permis_e';
	public $timestamps = false;

	protected $casts = [
		'id_commune' => 'int'
	];

	public function commune()
	{
		return $this->belongsTo(Commune::class, 'id_commune');
	}

	public function permis_e()
	{
		return $this->belongsTo(PermisE::class, 'id_permis_e');
	}
}
