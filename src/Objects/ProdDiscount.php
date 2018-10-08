<?php

namespace ITCity\Rivile\Objects;

class ProdDiscount extends RivileObject {
	protected static $prefix = 'N13';

	protected static $defs = [
		'n13_kodas_ps' => ['string', 'max:12'],
		'n13_kodas_us' => ['string', 'max:12'],
		'n13_kodas_is' => ['string', 'max:12'],
		'n13_eil_nr' => ['integer', 'max:999999'],
		'n13_date_pr' => ['date'],
		'n13_date_pb' => ['date'],
		'n13_pav' => ['string', 'max:60'],
		'n13_poz_kaina' => ['boolean'],
		'n13_kaina1' => ['numeric', 'max:99999999.9999'],
		'n13_kiekis2k' => ['integer', 'max:99999999999999'],
		'n13_kaina2' => ['numeric', 'max:99999999.9999'],
		'n13_kiekis3k' => ['integer', 'max:99999999999999'],
		'n13_kaina3' => ['numeric', 'max:99999999.9999'],
		'n13_kiekis4k' => ['integer', 'max:99999999999999'],
		'n13_kaina4' => ['numeric', 'max:99999999.9999'],
		'n13_poz_nuolaida' => ['boolean'],
		'n13_nuolaida1' => ['numeric', 'max:9999.99'],
		'n13_kiekis2n' => ['integer', 'max:99999999999999'],
		'n13_nuolaida2' => ['numeric', 'max:9999.99'],
		'n13_kiekis3n' => ['integer', 'max:99999999999999'],
		'n13_nuolaida3' => ['numeric', 'max:9999.99'],
		'n13_kiekis4n' => ['integer', 'max:99999999999999'],
		'n13_nuolaida4' => ['numeric', 'max:9999.99'],
		'n13_kodas_ls_1' => ['string', 'max:12'],
		'n13_kodas_ls_2' => ['string', 'max:12'],
		'n13_kodas_ls_3' => ['string', 'max:12'],
		'n13_kodas_ls_4' => ['string', 'max:12'],
		'n13_addusr' => ['string', 'max:12'],
		'n13_useris' => ['string', 'max:12'],
		'n13_r_date' => ['date'],
		'n13_rezervas' => ['string', 'max:12'],
	];
}