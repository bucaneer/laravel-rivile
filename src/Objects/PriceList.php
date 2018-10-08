<?php

namespace ITCity\Rivile\Objects;

class PriceList extends RivileObject {
	protected static $prefix = 'N32';

	protected static $defs = [
		'n32_kodas_ps' => ['string', 'max:12'],
		'n32_kodas_us' => ['string', 'max:12'],
		'n32_tipas' => ['string', 'max:1'],
		'n32_g_date' => ['date'],
		'n32_kaina1' => ['numeric', 'max:99999999.9999'],
		'n32_kaina2' => ['numeric', 'max:99999999.9999'],
		'n32_kiekis2' => ['intger', 'max:99999999999999'],
		'n32_kaina3' => ['numeric', 'max:99999999.9999'],
		'n32_kiekis3' => ['intger', 'max:99999999999999'],
		'n32_kaina4' => ['numeric', 'max:99999999.9999'],
		'n32_kiekis4' => ['intger', 'max:99999999999999'],
		'n32_useris' => ['string', 'max:12'],
		'n32_r_date' => ['date'],
		'n32_addusr' => ['string', 'max:12'],
		'n32_id' => ['string', 'max:2'],
	];
}