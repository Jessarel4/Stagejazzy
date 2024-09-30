<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeSubstance
 * 
 * @property int $id_type_substance
 * @property string|null $nom_type_substance
 * @property string $sigle_type_substance
 * @property int|null $limite_production_type_substance
 * @property string|null $unite_limite_type_substance
 * 
 * @property Collection|Substance[] $substances
 *
 * @package App\Models
 */
class TypeSubstance extends Model
{
	protected $table = 'type_substance';
	protected $primaryKey = 'id_type_substance';
	public $timestamps = false;

	protected $casts = [
		'limite_production_type_substance' => 'int'
	];

	protected $fillable = [
		'nom_type_substance',
		'sigle_type_substance',
		'limite_production_type_substance',
		'unite_limite_type_substance'
	];

	public function substances()
	{
		return $this->hasMany(Substance::class, 'id_type_substance');
	}
}
