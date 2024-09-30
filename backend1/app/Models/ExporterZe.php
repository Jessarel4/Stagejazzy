<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExporterZe
 * 
 * @property int $id_substance
 * @property int $id_ze
 *
 * @package App\Models
 */
class ExporterZe extends Model
{
	protected $table = 'exporter_ze';
	public $timestamps = false;

	protected $casts = [
		'id_ze' => 'int'
	];
}
