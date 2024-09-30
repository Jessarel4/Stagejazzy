<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tresor
 * 
 * @property int $id_tresor
 * @property string|null $num_quittance_tresor
 * @property Carbon|null $date_paiement_tresor
 * @property string|null $pj_tresor
 * 
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Tresor extends Model
{
	protected $table = 'tresor';
	protected $primaryKey = 'id_tresor';
	public $timestamps = false;

	protected $casts = [
		'date_paiement_tresor' => 'datetime'
	];

	protected $fillable = [
		'num_quittance_tresor',
		'date_paiement_tresor',
		'pj_tresor'
	];

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_tresor');
	}
}
