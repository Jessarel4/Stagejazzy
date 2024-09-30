<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 * 
 * @property int $id_district
 * @property string|null $nom_district
 * @property int $id_region
 * 
 * @property Region $region
 * @property Collection|Commune[] $communes
 *
 * @package App\Models
 */
class District extends Model
{
	protected $table = 'districts';
	protected $primaryKey = 'id_district';
	public $timestamps = false;

	protected $casts = [
		'id_region' => 'int'
	];

	protected $fillable = [
		'nom_district',
		'id_region'
	];

	public function region()
	{
		return $this->belongsTo(Region::class, 'id_region');
	}

	public function communes()
	{
		return $this->hasMany(Commune::class, 'id_district');
	}
}
