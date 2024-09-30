<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QualiteDirigeant
 * 
 * @property int $id_qualite_dirigeant
 * @property string|null $option_qualite_dirigeant
 *
 * @package App\Models
 */
class QualiteDirigeant extends Model
{
	protected $table = 'qualite_dirigeant';
	protected $primaryKey = 'id_qualite_dirigeant';
	public $timestamps = false;

	protected $fillable = [
		'option_qualite_dirigeant'
	];
}
