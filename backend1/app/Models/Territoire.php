<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Territoire
 * 
 * @property int $id_territoire
 * @property string|null $code_alpha_22
 * @property string|null $code_alpha_3
 * @property string|null $code_numerique
 * @property string|null $nom_francais
 * @property string|null $nom_anglais
 * @property string|null $capitale
 * @property string|null $pays_independant
 * @property string|null $continent
 * @property string|null $nationalite
 *
 * @package App\Models
 */
class Territoire extends Model
{
	protected $table = 'territoires';
	protected $primaryKey = 'id_territoire';
	public $timestamps = false;

	protected $fillable = [
		'code_alpha_22',
		'code_alpha_3',
		'code_numerique',
		'nom_francais',
		'nom_anglais',
		'capitale',
		'pays_independant',
		'continent',
		'nationalite'
	];
}
