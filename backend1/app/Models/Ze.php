<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ze
 * 
 * @property int $id_ze
 * @property string|null $nom_ze
 * @property string|null $sigle_ze
 * @property string|null $numero_arrete
 * @property Carbon|null $date_octroi_ze
 * @property Carbon|null $fin_validite_ze
 * @property int|null $nombre_petits_exploitants
 * @property int|null $x1
 * @property int|null $y1
 * @property int|null $status_ze
 * @property int|null $avis_admin_ze
 * @property string|null $pj_arrete_ze
 * @property Carbon|null $date_insertion_ze
 * @property Carbon|null $date_modification_ze
 * @property string|null $num_ad
 * @property string|null $pj_ad
 * @property Carbon|null $date_ad
 * @property string|null $num_cf
 * @property string|null $pj_cf
 * @property Carbon|null $date_cf
 * @property string|null $num_instat
 * @property string|null $pj_instat
 * @property Carbon|null $date_instat
 * @property string|null $pj_bcmm
 * @property Carbon|null $date_bcmm
 * @property string|null $pj_statut_a
 * @property string|null $pj_cre
 * @property string|null $pj_crlp
 * @property string|null $pj_cra
 * @property string|null $pj_cb
 * @property int|null $derogation_quotas_ze
 * @property Carbon|null $date_reprendre_ze
 * @property int $id_commune
 * @property int|null $id_ad
 * 
 * @property Collection|Correspondre[] $correspondres
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Ze extends Model
{
	protected $table = 'ze';
	protected $primaryKey = 'id_ze';
	public $timestamps = false;

	protected $casts = [
		'date_octroi_ze' => 'datetime',
		'fin_validite_ze' => 'datetime',
		'nombre_petits_exploitants' => 'int',
		'x1' => 'int',
		'y1' => 'int',
		'status_ze' => 'int',
		'avis_admin_ze' => 'int',
		'date_insertion_ze' => 'datetime',
		'date_modification_ze' => 'datetime',
		'date_ad' => 'datetime',
		'date_cf' => 'datetime',
		'date_instat' => 'datetime',
		'date_bcmm' => 'datetime',
		'derogation_quotas_ze' => 'int',
		'date_reprendre_ze' => 'datetime',
		'id_commune' => 'int',
		'id_ad' => 'int'
	];

	protected $fillable = [
		'nom_ze',
		'sigle_ze',
		'numero_arrete',
		'date_octroi_ze',
		'fin_validite_ze',
		'nombre_petits_exploitants',
		'x1',
		'y1',
		'status_ze',
		'avis_admin_ze',
		'pj_arrete_ze',
		'date_insertion_ze',
		'date_modification_ze',
		'num_ad',
		'pj_ad',
		'date_ad',
		'num_cf',
		'pj_cf',
		'date_cf',
		'num_instat',
		'pj_instat',
		'date_instat',
		'pj_bcmm',
		'date_bcmm',
		'pj_statut_a',
		'pj_cre',
		'pj_crlp',
		'pj_cra',
		'pj_cb',
		'derogation_quotas_ze',
		'date_reprendre_ze',
		'id_commune',
		'id_ad'
	];

	public function correspondres()
	{
		return $this->hasMany(Correspondre::class, 'id_ze');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_ze');
	}
}
