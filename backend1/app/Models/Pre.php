<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pre
 * 
 * @property int $id_pre
 * @property int|null $titre_pre
 * @property int|null $nombre_carres_pre
 * @property Carbon|null $date_octroi_pre
 * @property Carbon|null $fin_validite_pre
 * @property string|null $classification_pre
 * @property Carbon|null $dernier_fa
 * @property int|null $status_pre
 * @property int|null $avis_admin_pre
 * @property Carbon|null $date_attestation_paiement_fa
 * @property string|null $num_ae_ou_pe
 * @property string|null $pj_cape
 * @property string|null $pj_addr
 * @property string|null $pj_cdoc
 * @property string|null $pj_cpm
 * @property string|null $pj_cre
 * @property string|null $pj_qpfa
 * @property string|null $pj_rraa
 * @property Carbon|null $date_se_ou_pe
 * @property Carbon|null $date_demande_renouvellement
 * @property Carbon|null $date_recepisse_rapport_annuel_activites
 * @property Carbon|null $date_declaration_ouverture_de_chantier
 * @property Carbon|null $date_insertion_pre
 * @property Carbon|null $date_modification_pre
 * @property string|null $pj_demande_sub
 * @property int|null $nombre_exploitant_pre
 * @property string|null $pj_registre_appel
 * @property int|null $derogation_quotas_pre
 * @property Carbon|null $date_reprendre_pre
 * @property int|null $id_titulaire_pre
 * @property int|null $id_ad
 * 
 * @property Collection|Correspondre[] $correspondres
 * @property Collection|CorrespondrePre[] $correspondre_pres
 * @property Collection|LpInfo[] $lp_infos
 *
 * @package App\Models
 */
class Pre extends Model
{
	protected $table = 'pre';
	protected $primaryKey = 'id_pre';
	public $timestamps = false;

	protected $casts = [
		'titre_pre' => 'int',
		'nombre_carres_pre' => 'int',
		'date_octroi_pre' => 'datetime',
		'fin_validite_pre' => 'datetime',
		'dernier_fa' => 'datetime',
		'status_pre' => 'int',
		'avis_admin_pre' => 'int',
		'date_attestation_paiement_fa' => 'datetime',
		'date_se_ou_pe' => 'datetime',
		'date_demande_renouvellement' => 'datetime',
		'date_recepisse_rapport_annuel_activites' => 'datetime',
		'date_declaration_ouverture_de_chantier' => 'datetime',
		'date_insertion_pre' => 'datetime',
		'date_modification_pre' => 'datetime',
		'nombre_exploitant_pre' => 'int',
		'derogation_quotas_pre' => 'int',
		'date_reprendre_pre' => 'datetime',
		'id_titulaire_pre' => 'int',
		'id_ad' => 'int'
	];

	protected $fillable = [
		'titre_pre',
		'nombre_carres_pre',
		'date_octroi_pre',
		'fin_validite_pre',
		'classification_pre',
		'dernier_fa',
		'status_pre',
		'avis_admin_pre',
		'date_attestation_paiement_fa',
		'num_ae_ou_pe',
		'pj_cape',
		'pj_addr',
		'pj_cdoc',
		'pj_cpm',
		'pj_cre',
		'pj_qpfa',
		'pj_rraa',
		'date_se_ou_pe',
		'date_demande_renouvellement',
		'date_recepisse_rapport_annuel_activites',
		'date_declaration_ouverture_de_chantier',
		'date_insertion_pre',
		'date_modification_pre',
		'pj_demande_sub',
		'nombre_exploitant_pre',
		'pj_registre_appel',
		'derogation_quotas_pre',
		'date_reprendre_pre',
		'id_titulaire_pre',
		'id_ad'
	];

	public function correspondres()
	{
		return $this->hasMany(Correspondre::class, 'id_pre');
	}

	public function correspondre_pres()
	{
		return $this->hasMany(CorrespondrePre::class, 'id_pre');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_pre');
	}
}
