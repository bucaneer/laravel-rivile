<?php

namespace ITCity\Rivile\Objects;

class ProductStocks extends Object {
	protected static $prefix = 'I17';

	protected static $defs = [
		'i17_kodas_is' => ['string', 'max:12'],
		'i17_kodas_ps' => ['string', 'max:12'],
		'i17_kodas_os' => ['string', 'max:12'],
		'i17_serija' => ['string', 'max:12'],
		'i17_kodas_us_a' => ['string', 'max:12'],
		'i17_kodas_us' => ['string', 'max:12'],
		'i17_frakcija' => ['integer', 'max:9999'],
		'i17_kiekis' => ['integer', 'max:99999999999999'],
		'i17_atiduota' => ['integer', 'max:99999999999999'],
		'i17_rezervas' => ['integer', 'max:99999999999999'],
		'i17_pard_uzs' => ['integer', 'max:99999999999999'],
		'i17_pirk_uzs' => ['integer', 'max:99999999999999'],
		'i17_suma' => ['numeric', 'max:9999999999.99'],
		'i17_p_pir_k' => ['numeric', 'max:99999999.9999'],
		'i17_p_pir_d' => ['date'],
		'i17_p_par_k' => ['numeric', 'max:99999999.9999'],
		'i17_p_par_d' => ['date'],
		'i17_vid_uzs' => ['integer', 'max:99999999999999'],
		'i17_reikalavimas' => ['integer', 'max:99999999999999'],
		'i17_kelyje' => ['integer', 'max:99999999999999'],
		'i17_kaina' => ['numeric', 'max:99999999.9999'],
		'i17_useris' => ['string', 'max:12'],
		'i17_addusr' => ['string', 'max:12'],
		'i17_r_date' => ['date'],
	];
}