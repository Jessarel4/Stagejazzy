<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TitulairePre
 * 
 * @property int $id_titulaire_pre
 * @property string|null $nom_titulaire_pre
 * @property int|null $id_region
 * 
 * @property Region|null $region
 *
 * @package App\Models
 */
class TitulairePre extends Model
{
	protected $table = 'titulaire_pre';
	protected $primaryKey = 'id_titulaire_pre';
	public $timestamps = false;

	protected $casts = [
		'id_region' => 'int'
	];

	protected $fillable = [
		'nom_titulaire_pre',
		'id_region'
	];

	public function region()
	{
		return $this->belongsTo(Region::class, 'id_region');
	}
}
