<?php

namespace ITCity\Rivile\Objects;

class Debt extends RivileObject {
	protected static $prefix = 'I44';

	protected static $defs = [
		'i44_modul' => ['string', 'max:2'],
		'i44_kodas_op' => ['string', 'max:12'],
		'i44_eil_nr' => ['integer', 'max:999999'],
		'i44_tipas' => ['integer', 'max:99'],
		'i44_dok_nr' => ['string', 'max:20'],
		'i44_kodas_ks' => ['string', 'max:12'],
		'i44_kodas_ms' => ['string', 'max:12'],
		'i44_kodas_is' => ['string', 'max:12'],
		'i44_kodas_os' => ['string', 'max:12'],
		'i44_kodas_os_c' => ['string', 'max:12'],
		'i44_kodas_ss' => ['string', 'max:12'],
		'i44_data_dok' => ['date'],
		'i44_data_mok' => ['date'],
		'i44_data_dsk' => ['date'],
		'i44_dsk_proc' => ['numeric', 'max:9999.99'],
		'i44_suma_db' => ['numeric', 'max:9999999999.99'],
		'i44_suma_cr' => ['numeric', 'max:9999999999.99'],
		'i44_kodas_vl' => ['string', 'max:12'],
		'i44_suma_db_vl' => ['numeric', 'max:9999999999999999.99'],
		'i44_suma_cr_vl' => ['numeric', 'max:9999999999999999.99'],
		'i44_suma_plk' => ['numeric', 'max:9999999999.99'],
		'i44_savikaina' => ['numeric', 'max:9999999999.99'],
		'i44_pvm' => ['numeric', 'max:9999999999.99'],
		'i44_pastabos' => ['string', 'max:12'],
		'i44_addusr' => ['string', 'max:12'],
		'i44_r_date' => ['date'],
		'i44_useris' => ['string', 'max:12'],
		'i44_kodas_kt' => ['string', 'max:12'],
		'i44_kodas_k0' => ['string', 'max:12'],
	];
}