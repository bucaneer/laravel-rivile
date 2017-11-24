<?php

namespace ITCity\Rivile\Objects;

class InternalDoc extends Object {
	protected static $prefix = 'I09';

	protected static $defs = [
		'i09_kodas_vd' => ['string', 'max:12'],
		'i09_tipas' => ['integer', 'in:1,2'],
		'i09_dok_nr' => ['string', 'max:12'],
		'i09_is_data' => ['date'],
		'i09_gav_poz' => ['integer', 'max:9'],
		'i09_gav_data' => ['date'],
		'i09_kodas_is1' => ['string', 'max:12'],
		'i09_kodas_ss_t' => ['string', 'max:12'],
		'i09_nutol1' => ['boolean'],
		'i09_eil1' => ['string', 'max:40'],
		'i09_eil2' => ['string', 'max:40'],
		'i09_eil3' => ['string', 'max:40'],
		'i09_kodas_is2' => ['string', 'max:12'],
		'i09_nutol2' => ['integer'],
		'i09_a_eil1' => ['string', 'max:40'],
		'i09_a_eil2' => ['string', 'max:40'],
		'i09_a_eil3' => ['string', 'max:40'],
		'i09_perkelta1' => ['integer', 'in:1,2,3'],
		'i09_perkelta2' => ['integer', 'in:1,2,3'],
		'i09_imp_exp' => ['integer', 'max:9'],
		'i09_useris' => ['string', 'max:12'],
		'i09_r_date' => ['date'],
		'i09_addusr' => ['string', 'max:12'],
		'i09_eil_sk' => ['numeric', 'max:9999999999.99'],
		'i09_kodas_sm1' => ['string', 'max:12'],
		'i09_kodas_sm2' => ['string', 'max:12'],
		'i09_pav' => ['string', 'max:60'],
		'i09_kodas_ms' => ['string', 'max:12'],
		'i09_kodas_ls_1' => ['string', 'max:12'],
		'i09_kodas_ls_2' => ['string', 'max:12'],
		'i09_kodas_ls_3' => ['string', 'max:12'],
		'i09_kodas_ls_4' => ['string', 'max:12'],
		'i09_add_date' => ['date'],
		'i09_per1_date' => ['date'],
		'i09_per1_user' => ['string', 'max:12'],
		'i09_kodas_au' => ['string', 'max:12'],
	];
}