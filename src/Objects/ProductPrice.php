<?php

namespace ITCity\Rivile\Objects;

class ProductPrice extends Object {
	protected static $prefix = 'I33';

	protected static $defs = [
		'I33_KODAS_PS' => ['string', 'max:12'],
		'I33_KODAS_IS' => ['string', 'max:12'],
		'I33_KODAS_US' => ['string', 'max:12'],
		'I33_KAINA' => ['numeric', 'max:99999999.9999'],
		'I33_KAINA_NEW' => ['numeric', 'max:99999999.9999'],
		'I33_PPK' => ['numeric', 'max:99999999.9999'],
		'I33_PPK_DATE' => ['date'],
		'I33_KODAS_VL' => ['string', 'max:12'],
		'I33_PPK_VAL' => ['numeric', 'max:99999999999999.9999'],
		'I33_PPK_SAV' => ['numeric', 'max:99999999.9999'],
		'I33_PPK_SAV_DATE' => ['date'],
		'I33_ADDUSR' => ['string', 'max:12'],
		'I33_USERIS' => ['string', 'max:12'],
		'I33_R_DATE' => ['date'],
		'I33_FORMATAS' => ['integer', 'max:999'],
		'I33_POZ' => ['string', 'max:3'],
		'I33_KAINA_BAZ' => ['numeric', 'max:99999999.9999'],
		'I33_POZ_POS' => ['integer', 'in:1,2,3'],
	];
}