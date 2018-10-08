<?php

namespace ITCity\Rivile\Objects;

class LoyaltyOperation extends RivileObject {
	protected static $prefix = 'I64';

	protected static $defs = [
		'i64_kodas_dr' => ['string', 'max:12'],
		'i64_eil_nr' => ['integer', 'max:999999'],
		'i64_kodas_dl' => ['string', 'max:12'],
		'i64_kodas_ww' => ['string', 'max:12'],
		'i64_op_date' => ['date'],
		'i64_pav' => ['string', 'max:40'],
		'i64_taskai' => ['integer', 'max:99999999999999'],
		'i64_tipas' => ['integer', 'in:1,2,3'],
		'i64_kodas_ps' => ['string', 'max:12'],
		'i64_suma' => ['numeric', 'max:9999999999.99'],
		'i64_addusr' => ['string', 'max:12'],
		'i64_useris' => ['string', 'max:12'],
		'i64_r_date' => ['date'],
		'i64_kodas_us' => ['string', 'max:12'],
		'i64_kodas_is' => ['string', 'max:12'],
		'i64_rezervas1' => ['string', 'max:12'],
		'i64_rezervas2' => ['string', 'max:12'],
		'i64_rezervas3' => ['string', 'max:60'],
		'i64_kodas_dl_a' => ['string', 'max:12'],
		'i64_id_par' => ['string', 'max:12'],
		'i64_id_pos' => ['string', 'max:12'],
		'i64_korteles_id' => ['string', 'max:40'],
	];
}