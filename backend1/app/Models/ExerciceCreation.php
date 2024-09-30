<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExerciceCreation
 * 
 * @property int $id_exercice
 * @property string|null $nom_exercice
 *
 * @package App\Models
 */
class ExerciceCreation extends Model
{
	protected $table = 'exercice_creation';
	protected $primaryKey = 'id_exercice';
	public $timestamps = false;

	protected $fillable = [
		'nom_exercice'
	];
}
