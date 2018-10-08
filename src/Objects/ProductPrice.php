<?php

namespace ITCity\Rivile\Objects;

class ProductPrice extends RivileObject {
	protected static $prefix = 'I33';

	protected static $defs = [
		'i33_kodas_ps' => ['string', 'max:12'],
		'i33_kodas_is' => ['string', 'max:12'],
		'i33_kodas_us' => ['string', 'max:12'],
		'i33_kaina' => ['numeric', 'max:99999999.9999'],
		'i33_kaina_new' => ['numeric', 'max:99999999.9999'],
		'i33_ppk' => ['numeric', 'max:99999999.9999'],
		'i33_ppk_date' => ['date'],
		'i33_kodas_vl' => ['string', 'max:12'],
		'i33_ppk_val' => ['numeric', 'max:99999999999999.9999'],
		'i33_ppk_sav' => ['numeric', 'max:99999999.9999'],
		'i33_ppk_sav_date' => ['date'],
		'i33_addusr' => ['string', 'max:12'],
		'i33_useris' => ['string', 'max:12'],
		'i33_r_date' => ['date'],
		'i33_formatas' => ['integer', 'max:999'],
		'i33_poz' => ['string', 'max:3'],
		'i33_kaina_baz' => ['numeric', 'max:99999999.9999'],
		'i33_poz_pos' => ['integer', 'in:1,2,3'],
	];
}