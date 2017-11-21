<?php

namespace ITCity\Rivile\Objects;

class ClientDetails extends Object {
	protected $prefix = 'N33';

	protected $defs = [
		'N33_KODAS_KS' => ['string', 'max:12'],
		'N33_EIL_NR' => ['integer', 'max:999999'],
		'N33_PAV' => ['string', 'max:70'],
		'N33_ADRESAS' => ['string', 'max:40'],
		'N33_KODAS_VS' => ['string', 'max:12'],
		'N33_FAX' => ['string', 'max:40'],
		'N33_TEL' => ['string', 'max:40'],
		'N33_PAST_KODAS' => ['string', 'max:9'],
		'N33_SHIP_VIA' => ['string', 'max:15'],
		'N33_SHIP_FOB' => ['string', 'max:15'],
		'N33_NUTYL' => ['boolean'],
		'N33_KODAS_WS' => ['string', 'max:12'],
		'N33_S_KODAS' => ['string', 'max:45'],
		'N33_SWIFT' => ['string', 'max:15'],
		'N33_KODAS_WS_K' => ['string', 'max:12'],
		'N33_KSWIFT' => ['string', 'max:15'],
		'N33_K_SASK' => ['string', 'max:45'],
		'N33_USERIS' => ['string', 'max:12'],
		'N33_R_DATE' => ['date'],
		'N33_ADDUSR' => ['string', 'max:12'],
		'N33_KODAS_SS' => ['string', 'max:12'],
		'N33_KODAS_AK' => ['string', 'max:12'],
		'N33_WEB_ADR' => ['string', 'max:12'],
		'N33_WEB_POZ' => ['boolean'],
		'N33_WEB_ATAS' => ['string', 'max:13'],
		'N33_WEB_SERV' => ['integer', 'max:99'],
		'N33_WEB_POZT' => ['boolean'],
		'N33_WEB_POZI' => ['boolean'],
		'N33_WEB_ADRI' => ['string', 'max:12'],
		'N33_KODAS_LS_1' => ['string', 'max:12'],
		'N33_KODAS_LS_2' => ['string', 'max:12'],
		'N33_KODAS_LS_3' => ['string', 'max:12'],
		'N33_KODAS_LS_4' => ['string', 'max:12'],
		'N33_KODAS_MS' => ['string', 'max:12'],
		'N33_SALIS_K' => ['string', 'max:5'],
	];
}