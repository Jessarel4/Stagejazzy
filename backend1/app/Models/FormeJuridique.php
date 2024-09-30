<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FormeJuridique
 * 
 * @property int $id_forme_juridique
 * @property string|null $option_forme_juridique
 *
 * @package App\Models
 */
class FormeJuridique extends Model
{
	protected $table = 'forme_juridique';
	protected $primaryKey = 'id_forme_juridique';
	public $timestamps = false;

	protected $fillable = [
		'option_forme_juridique'
	];
}
