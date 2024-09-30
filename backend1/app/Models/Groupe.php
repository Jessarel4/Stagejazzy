<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Groupe
 * 
 * @property int $id_groupe
 * @property string|null $nom_groupe
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Groupe extends Model
{
	protected $table = 'groupes';
	protected $primaryKey = 'id_groupe';
	public $timestamps = false;

	protected $fillable = [
		'nom_groupe'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'id_groupe');
	}
}
