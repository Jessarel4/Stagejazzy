<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Correspondre
 * 
 * @property int $id_lp
 * @property int $id_pre
 * @property int $id_ze
 * 
 * @property LpInfo $lp_info
 * @property Pre $pre
 * @property Ze $ze
 *
 * @package App\Models
 */
class Correspondre extends Model
{
	protected $table = 'correspondre';
	public $timestamps = false;

	protected $casts = [
		'id_pre' => 'int',
		'id_ze' => 'int'
	];

	public function lp_info()
	{
		return $this->belongsTo(LpInfo::class, 'id_lp');
	}

	public function pre()
	{
		return $this->belongsTo(Pre::class, 'id_pre');
	}

	public function ze()
	{
		return $this->belongsTo(Ze::class, 'id_ze');
	}
}
