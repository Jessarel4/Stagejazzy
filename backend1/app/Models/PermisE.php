<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PermisE
 * 
 * @property int $id_permis_e
 * @property int|null $titre_permis_e
 * @property int|null $nombre_carres_permis_e
 * @property Carbon|null $date_octroi_permis_e
 * @property Carbon|null $fin_validite_permis_e
 * @property string|null $classification_permis_e
 * @property int|null $dernier_fa_permis_e
 * @property string|null $en_cours_permis_e
 * @property int|null $status_permis_e
 * @property Carbon|null $date_insertion_permis_e
 * @property Carbon|null $date_modification_permis_e
 * @property int|null $max_quantite_permis_e
 * @property int|null $nombre_exploitant_permis_e
 * @property string|null $num_ae_pe_permis_e
 * @property string|null $pj_cape_permis_e
 * @property Carbon|null $date_pe_permis_e
 * @property string|null $pj_cpm_permis_e
 * @property string|null $pj_cre_permis_e
 * @property string|null $pj_qpfa_permis_e
 * @property Carbon|null $date_paiement_fa_permis_e
 * @property string|null $pj_cdoc_permis_e
 * @property Carbon|null $date_ouverture_chantier_permis_e
 * @property string|null $pj_rra_permis_e
 * @property Carbon|null $date_rapport_annuel_permis_e
 * @property string|null $pj_addr_permis_e
 * @property string|null $pj_registre_appel_permis_e
 * @property int $id_titulaire_permis_e
 * 
 * @property TitulairePermisE $titulaire_permis_e
 * @property Collection|Commune[] $communes
 * @property Collection|LpInfo[] $lp_infos
 * @property Collection|Substance[] $substances
 *
 * @package App\Models
 */
class PermisE extends Model
{
	protected $table = 'permis_e';
	protected $primaryKey = 'id_permis_e';
	public $timestamps = false;

	protected $casts = [
		'titre_permis_e' => 'int',
		'nombre_carres_permis_e' => 'int',
		'date_octroi_permis_e' => 'datetime',
		'fin_validite_permis_e' => 'datetime',
		'dernier_fa_permis_e' => 'int',
		'status_permis_e' => 'int',
		'date_insertion_permis_e' => 'datetime',
		'date_modification_permis_e' => 'datetime',
		'max_quantite_permis_e' => 'int',
		'nombre_exploitant_permis_e' => 'int',
		'date_pe_permis_e' => 'datetime',
		'date_paiement_fa_permis_e' => 'datetime',
		'date_ouverture_chantier_permis_e' => 'datetime',
		'date_rapport_annuel_permis_e' => 'datetime',
		'id_titulaire_permis_e' => 'int'
	];

	protected $fillable = [
		'titre_permis_e',
		'nombre_carres_permis_e',
		'date_octroi_permis_e',
		'fin_validite_permis_e',
		'classification_permis_e',
		'dernier_fa_permis_e',
		'en_cours_permis_e',
		'status_permis_e',
		'date_insertion_permis_e',
		'date_modification_permis_e',
		'max_quantite_permis_e',
		'nombre_exploitant_permis_e',
		'num_ae_pe_permis_e',
		'pj_cape_permis_e',
		'date_pe_permis_e',
		'pj_cpm_permis_e',
		'pj_cre_permis_e',
		'pj_qpfa_permis_e',
		'date_paiement_fa_permis_e',
		'pj_cdoc_permis_e',
		'date_ouverture_chantier_permis_e',
		'pj_rra_permis_e',
		'date_rapport_annuel_permis_e',
		'pj_addr_permis_e',
		'pj_registre_appel_permis_e',
		'id_titulaire_permis_e'
	];

	public function titulaire_permis_e()
	{
		return $this->belongsTo(TitulairePermisE::class, 'id_titulaire_permis_e');
	}

	public function communes()
	{
		return $this->belongsToMany(Commune::class, 'commune_permis_e', 'id_permis_e', 'id_commune');
	}

	public function lp_infos()
	{
		return $this->hasMany(LpInfo::class, 'id_permis_e');
	}

	public function substances()
	{
		return $this->belongsToMany(Substance::class, 'substance_permis_e', 'id_permis_e', 'id_substance');
	}
}
