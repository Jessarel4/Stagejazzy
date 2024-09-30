<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExporterPre
 * 
 * @property int $id_pre
 * @property int $id_substance
 *
 * @package App\Models
 */
class ExporterPre extends Model
{
	protected $table = 'exporter_pre';
	public $timestamps = false;

	protected $casts = [
		'id_substance' => 'int'
	];
}
