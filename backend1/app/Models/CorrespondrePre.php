<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CorrespondrePre
 * 
 * @property int $id_pre
 * @property int $id_commune
 * 
 * @property Commune $commune
 * @property Pre $pre
 *
 * @package App\Models
 */
class CorrespondrePre extends Model
{
	protected $table = 'correspondre_pre';
	public $timestamps = false;

	protected $casts = [
		'id_commune' => 'int'
	];

	public function commune()
	{
		return $this->belongsTo(Commune::class, 'id_commune');
	}

	public function pre()
	{
		return $this->belongsTo(Pre::class, 'id_pre');
	}
}
