<?php

namespace ITCity\Rivile\Objects;

class InvoiceDelay extends Object {
	protected static $prefix = 'I08';

	protected static $defs = [
		'i08_kodas_po' => ['string', 'max:12'],
		'i08_eil_nr' => ['integer', 'max:999999'],
		'i08_nuol_d' => ['integer', 'max:99999'],
		'i08_nuol_p' => ['numeric', 'max:99999.99999'],
		'i08_mok_d' => ['integer', 'max:99999'],
		'i08_mok_p' => ['numeric', 'max:99999.99999'],
		'i08_suma_plk' => ['numeric', 'max:9999999999.99'],
		'i08_r_date' => ['date'],
		'i08_useris' => ['string', 'max:12'],
		'i08_addusr' => ['string', 'max:12'],
		'i08_mok_s' => ['numeric', 'max:9999999999.99'],
		'i08_plk_p' => ['numeric', 'max:99999.99999'],
	];

	protected static $insert_reqs = [
		'i08_kodas_po',
	];
}