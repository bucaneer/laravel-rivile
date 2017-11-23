<?php

namespace ITCity\Rivile\Objects;

class InvoicePayment extends Object {
	protected static $prefix = 'I13';

	protected static $defs = [
		'I13_KODAS_PO' => ['string', 'max:12'],
		'I13_EIL_NR' => ['integer', 'max:999999'],
		'I13_KODAS_SS' => ['string', 'max:12'],
		'I13_SUMA' => ['numernumericN', 'max:999999999999999.99'],
		'I13_PAV' => ['string', 'max:40'],
		'I13_ADDUSR' => ['string', 'max:12'],
		'I13_USERIS' => ['string', 'max:12'],
		'I13_R_DATE' => ['date'],
	];
}