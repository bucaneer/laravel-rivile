<?php

namespace ITCity\Rivile\Objects;

class ClientDetails extends Object {
	protected static $prefix = 'N33';

	protected static $defs = [
		'n33_kodas_ks' => ['string', 'max:12'],
		'n33_eil_nr' => ['integer', 'max:999999'],
		'n33_pav' => ['string', 'max:70'],
		'n33_adresas' => ['string', 'max:40'],
		'n33_kodas_vs' => ['string', 'max:12'],
		'n33_fax' => ['string', 'max:40'],
		'n33_tel' => ['string', 'max:40'],
		'n33_past_kodas' => ['string', 'max:9'],
		'n33_ship_via' => ['string', 'max:15'],
		'n33_ship_fob' => ['string', 'max:15'],
		'n33_nutyl' => ['boolean'],
		'n33_kodas_ws' => ['string', 'max:12'],
		'n33_s_kodas' => ['string', 'max:45'],
		'n33_swift' => ['string', 'max:15'],
		'n33_kodas_ws_k' => ['string', 'max:12'],
		'n33_kswift' => ['string', 'max:15'],
		'n33_k_sask' => ['string', 'max:45'],
		'n33_useris' => ['string', 'max:12'],
		'n33_r_date' => ['date'],
		'n33_addusr' => ['string', 'max:12'],
		'n33_kodas_ss' => ['string', 'max:12'],
		'n33_kodas_ak' => ['string', 'max:12'],
		'n33_web_adr' => ['string', 'max:12'],
		'n33_web_poz' => ['boolean'],
		'n33_web_atas' => ['string', 'max:13'],
		'n33_web_serv' => ['integer', 'max:99'],
		'n33_web_pozt' => ['boolean'],
		'n33_web_pozi' => ['boolean'],
		'n33_web_adri' => ['string', 'max:12'],
		'n33_kodas_ls_1' => ['string', 'max:12'],
		'n33_kodas_ls_2' => ['string', 'max:12'],
		'n33_kodas_ls_3' => ['string', 'max:12'],
		'n33_kodas_ls_4' => ['string', 'max:12'],
		'n33_kodas_ms' => ['string', 'max:12'],
		'n33_salis_k' => ['string', 'max:5'],
	];
}