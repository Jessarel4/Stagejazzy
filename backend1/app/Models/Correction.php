<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Correction
 * 
 * @property int $id_correction
 * @property Carbon|null $date_correction
 * @property string|null $motif_correction
 * @property string|null $demande_correction
 * @property int|null $id_user
 * @property int|null $id_lp
 * @property int|null $id_lp3c
 * @property int|null $correction_fait
 *
 * @package App\Models
 */
class Correction extends Model
{
	protected $table = 'correction';
	protected $primaryKey = 'id_correction';
	public $timestamps = false;

	protected $casts = [
		'date_correction' => 'datetime',
		'id_user' => 'int',
		'id_lp' => 'int',
		'id_lp3c' => 'int',
		'correction_fait' => 'int'
	];

	protected $fillable = [
		'date_correction',
		'motif_correction',
		'demande_correction',
		'id_user',
		'id_lp',
		'id_lp3c',
		'correction_fait'
	];
}
