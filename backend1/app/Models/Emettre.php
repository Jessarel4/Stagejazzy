<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Emettre
 * 
 * @property int $id_lp
 * @property int $id_direction
 * @property Carbon|null $date_emission
 * 
 * @property Direction $direction
 * @property LpInfo $lp_info
 *
 * @package App\Models
 */
class Emettre extends Model
{
	protected $table = 'emettre';
	public $timestamps = false;

	protected $casts = [
		'id_direction' => 'int',
		'date_emission' => 'datetime'
	];

	protected $fillable = [
		'date_emission'
	];

	public function direction()
	{
		return $this->belongsTo(Direction::class, 'id_direction');
	}

	public function lp_info()
	{
		return $this->belongsTo(LpInfo::class, 'id_lp');
	}
}
