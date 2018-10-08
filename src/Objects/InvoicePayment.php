<?php

namespace ITCity\Rivile\Objects;

class InvoicePayment extends RivileObject {
	protected static $prefix = 'I13';

	protected static $defs = [
		'i13_kodas_po' => ['string', 'max:12'],
		'i13_eil_nr' => ['integer', 'max:999999'],
		'i13_kodas_ss' => ['string', 'max:12'],
		'i13_suma' => ['numernumericN', 'max:999999999999999.99'],
		'i13_pav' => ['string', 'max:40'],
		'i13_addusr' => ['string', 'max:12'],
		'i13_useris' => ['string', 'max:12'],
		'i13_r_date' => ['date'],
	];
}