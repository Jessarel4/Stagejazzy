<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id_user
 * @property string|null $nom_user
 * @property string|null $prenom_user
 * @property string|null $status_user
 * @property int|null $status_condition
 * @property Carbon|null $date_acceptation
 * @property int|null $status_politique
 * @property int|null $id_direction
 * @property int $id_groupe
 * 
 * @property Direction|null $direction
 * @property Groupe $groupe
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	protected $primaryKey = 'id_user';
	public $timestamps = false;

	protected $casts = [
		'status_condition' => 'int',
		'date_acceptation' => 'datetime',
		'status_politique' => 'int',
		'id_direction' => 'int',
		'id_groupe' => 'int'
	];

	protected $fillable = [
		'nom_user',
		'prenom_user',
		'status_user',
		'status_condition',
		'date_acceptation',
		'status_politique',
		'id_direction',
		'id_groupe'
	];

	public function direction()
	{
		return $this->belongsTo(Direction::class, 'id_direction');
	}

	public function groupe()
	{
		return $this->belongsTo(Groupe::class, 'id_groupe');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_user_validateur');
	}
}
