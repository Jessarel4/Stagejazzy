<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Convoyeur
 * 
 * @property int $id_convoyeur
 * @property string|null $nom_convoyeur
 * @property string|null $cin_convoyeur
 * @property Carbon|null $date_cin
 * @property int|null $contact_convoyeur
 * 
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Convoyeur extends Model
{
	protected $table = 'convoyeurs';
	protected $primaryKey = 'id_convoyeur';
	public $timestamps = false;

	protected $casts = [
		'date_cin' => 'datetime',
		'contact_convoyeur' => 'int'
	];

	protected $fillable = [
		'nom_convoyeur',
		'cin_convoyeur',
		'date_cin',
		'contact_convoyeur'
	];

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_convoyeur');
	}
}
