<?php

namespace ITCity\Rivile\Objects;

class PriceList extends Object {
	protected static $prefix = 'N32';

	protected static $defs = [
		'N32_KODAS_PS' => ['string', 'max:12'],
		'N32_KODAS_US' => ['string', 'max:12'],
		'N32_TIPAS' => ['string', 'max:1'],
		'N32_G_DATE' => ['date'],
		'N32_KAINA1' => ['numeric', 'max:99999999.9999'],
		'N32_KAINA2' => ['numeric', 'max:99999999.9999'],
		'N32_KIEKIS2' => ['intger', 'max:99999999999999'],
		'N32_KAINA3' => ['numeric', 'max:99999999.9999'],
		'N32_KIEKIS3' => ['intger', 'max:99999999999999'],
		'N32_KAINA4' => ['numeric', 'max:99999999.9999'],
		'N32_KIEKIS4' => ['intger', 'max:99999999999999'],
		'N32_USERIS' => ['string', 'max:12'],
		'N32_R_DATE' => ['date'],
		'N32_ADDUSR' => ['string', 'max:12'],
		'N32_ID' => ['string', 'max:2'],
	];
}