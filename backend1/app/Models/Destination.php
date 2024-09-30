<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Destination
 * 
 * @property int $id_destination
 * @property Carbon|null $date_arrive
 * @property int $id_commune
 * 
 * @property Commune $commune
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Destination extends Model
{
	protected $table = 'destinations';
	protected $primaryKey = 'id_destination';
	public $timestamps = false;

	protected $casts = [
		'date_arrive' => 'datetime',
		'id_commune' => 'int'
	];

	protected $fillable = [
		'date_arrive',
		'id_commune'
	];

	public function commune()
	{
		return $this->belongsTo(Commune::class, 'id_commune');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_destination');
	}
}
