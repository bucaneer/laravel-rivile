<?php

namespace ITCity\Rivile\Objects;

class ClientProd extends RivileObject {
	protected static $prefix = 'N87';

	protected static $defs = [
		'n87_kodas_ps' => ['string', 'max:12'],
		'n87_kodas_us' => ['string', 'max:12'],
		'n87_kodas_ks' => ['string', 'max:12'],
		'n87_pav' => ['string', 'max:100'],
		'n87_kodas' => ['string', 'max:100'],
		'n87_aprasymas' => ['string', 'max:100'],
		'n87_eil1' => ['string', 'max:100'],
		'n87_eil2' => ['string', 'max:100'],
		'n87_eil3' => ['string', 'max:100'],
		'n87_num1' => ['numeric', 'max:9999999999.9999'],
		'n87_num2' => ['numeric', 'max:9999999999.9999'],
		'n87_num3' => ['numeric', 'max:9999999999.9999'],
		'n87_useris' => ['string', 'max:12'],
		'n87_r_date' => ['date'],
		'n87_addusr' => ['string', 'max:12'],
	];
}