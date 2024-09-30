<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeProduiit
 * 
 * @property int $id_type_produit
 * @property string|null $nom_type_produit
 *
 * @package App\Models
 */
class TypeProduiit extends Model
{
	protected $table = 'type_produiit';
	protected $primaryKey = 'id_type_produit';
	public $timestamps = false;

	protected $fillable = [
		'nom_type_produit'
	];
}
