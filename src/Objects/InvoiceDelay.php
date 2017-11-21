<?php

namespace ITCity\Rivile\Objects;

class InvoiceDelay extends Object {
	protected $prefix = 'I08';

	protected $defs = [
		'I08_KODAS_PO' => ['string', 'max:12'],
		'I08_EIL_NR' => ['integer', 'max:999999'],
		'I08_NUOL_D' => ['integer', 'max:99999'],
		'I08_NUOL_P' => ['numeric', 'max:99999.99999'],
		'I08_MOK_D' => ['integer', 'max:99999'],
		'I08_MOK_P' => ['numeric', 'max:99999.99999'],
		'I08_SUMA_PLK' => ['numeric', 'max:9999999999.99'],
		'I08_R_DATE' => ['date'],
		'I08_USERIS' => ['string', 'max:12'],
		'I08_ADDUSR' => ['string', 'max:12'],
		'I08_MOK_S' => ['numeric', 'max:9999999999.99'],
		'I08_PLK_P' => ['numeric', 'max:99999.99999'],
	];
}