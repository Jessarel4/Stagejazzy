<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Origine
 * 
 * @property int $id_origine
 * @property int $id_commune
 * 
 * @property Commune $commune
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Origine extends Model
{
	protected $table = 'origine';
	protected $primaryKey = 'id_origine';
	public $timestamps = false;

	protected $casts = [
		'id_commune' => 'int'
	];

	protected $fillable = [
		'id_commune'
	];

	public function commune()
	{
		return $this->belongsTo(Commune::class, 'id_commune');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_origine');
	}
}
