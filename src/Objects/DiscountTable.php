<?php

namespace ITCity\Rivile\Objects;

class DiscountTable extends Object {
	protected static $prefix = 'N31';

	protected static $defs = [
		'n31_kodas_ns' => ['string', 'max:12'],
		'n31_eil_nr' => ['integer', 'max:999999'],
		'n31_minimum' => ['numeric', 'max:99999999999.999'],
		'n31_nuol_proc' => ['numeric', 'max:9999.9999'],
		'n31_useris' => ['string', 'max:12'],
		'n31_r_date' => ['date'],
		'n31_addusr' => ['string', 'max:12'],
	];
}