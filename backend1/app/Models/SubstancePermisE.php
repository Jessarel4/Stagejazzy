<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubstancePermisE
 * 
 * @property int $id_permis_e
 * @property int $id_substance
 * 
 * @property PermisE $permis_e
 * @property Substance $substance
 *
 * @package App\Models
 */
class SubstancePermisE extends Model
{
	protected $table = 'substance_permis_e';
	public $timestamps = false;

	protected $casts = [
		'id_substance' => 'int'
	];

	public function permis_e()
	{
		return $this->belongsTo(PermisE::class, 'id_permis_e');
	}

	public function substance()
	{
		return $this->belongsTo(Substance::class, 'id_substance');
	}
}
