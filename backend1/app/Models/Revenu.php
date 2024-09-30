<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Revenu
 * 
 * @property int $id_revenu
 * @property string|null $assiette_rrm
 * @property float|null $redevance
 * @property float|null $ristourne
 * @property string|null $num_ordre_versement
 * @property Carbon|null $date_emission_ov
 * @property string|null $pj_ov
 * 
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Revenu extends Model
{
	protected $table = 'revenu';
	protected $primaryKey = 'id_revenu';
	public $timestamps = false;

	protected $casts = [
		'redevance' => 'float',
		'ristourne' => 'float',
		'date_emission_ov' => 'datetime'
	];

	protected $fillable = [
		'assiette_rrm',
		'redevance',
		'ristourne',
		'num_ordre_versement',
		'date_emission_ov',
		'pj_ov'
	];

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_revenu');
	}
}
