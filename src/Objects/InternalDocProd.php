<?php

namespace ITCity\Rivile\Objects;

class InternalDocProd extends Object {
	protected static $prefix = 'I10';

	protected static $defs = [
		'i10_kodas_vd' => ['string', 'max:12'],
		'i10_eil_nr' => ['integer', 'max:999999'],
		'i10_kodas_tr' => ['string', 'max:12'],
		'i10_tipas' => ['integer', 'max:9'],
		'i10_perkelta' => ['integer', 'in:1,2,3'],
		'i10_kodas_ps' => ['string', 'max:12'],
		'i10_kodas_os1' => ['string', 'max:12'],
		'i10_serija1' => ['string', 'max:12'],
		'i10_kodas_os2' => ['string', 'max:12'],
		'i10_serija2' => ['string', 'max:12'],
		'i10_pav' => ['string', 'max:40'],
		'i10_kodas_us1' => ['string', 'max:12'],
		'i10_kiekis1' => ['integer', 'max:99999999999999'],
		'i10_frakcija1' => ['integer', 'max:9999'],
		'i10_kodas_us' => ['string', 'max:12'],
		'i10_kiekis' => ['integer', 'max:99999999999999'],
		'i10_frakcija' => ['integer', 'max:9999'],
		'i10_kodas_us2' => ['string', 'max:12'],
		'i10_kiekis2' => ['integer', 'max:99999999999999'],
		'i10_frakcija2' => ['integer', 'max:9999'],
		'i10_pir_kaina' => ['numeric', 'max:99999999.9999'],
		'i10_pard_kaina1' => ['numeric', 'max:99999999.9999'],
		'i10_pard_kaina2' => ['numeric', 'max:99999999.9999'],
		'i10_kitos' => ['numeric', 'max:9999999999.99'],
		'i10_muitas' => ['numeric', 'max:9999999999.99'],
		'i10_akcizas' => ['numeric', 'max:9999999999.99'],
		'i10_sav_viso' => ['numeric', 'max:9999999999.99'],
		'i10_gal_data' => ['date'],
		'i10_useris' => ['string', 'max:12'],
		'i10_r_date' => ['date'],
		'i10_addusr' => ['string', 'max:12'],
		'i10_add_date' => ['date'],
		'i10_aprasymas1' => ['string', 'max:150'],
		'i10_aprasymas2' => ['string', 'max:150'],
		'i10_aprasymas3' => ['string', 'max:150'],
	];
}