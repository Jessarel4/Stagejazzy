<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TitulairePermisE
 * 
 * @property int $id_titulaire_permis_e
 * @property string|null $nom_titulaire_permis_e
 * 
 * @property Collection|PermisE[] $permis_es
 *
 * @package App\Models
 */
class TitulairePermisE extends Model
{
	protected $table = 'titulaire_permis_e';
	protected $primaryKey = 'id_titulaire_permis_e';
	public $timestamps = false;

	protected $fillable = [
		'nom_titulaire_permis_e'
	];

	public function permis_es()
	{
		return $this->hasMany(PermisE::class, 'id_titulaire_permis_e');
	}
}
