<?php

namespace ITCity\Rivile\Objects;

class CashFlowDetail extends RivileObject {
	protected static $prefix = 'I05';

	protected static $defs = [
		'i05_kodas_ch' => ['string', 'max:12'],
		'i05_eil_nr' => ['integer', 'max:999999'],
		'i05_dok_nr' => ['string', 'max:20'],
		'i05_data_dok' => ['date'],
		'i05_data_mok' => ['date'],
		'i05_data_dsk' => ['date'],
		'i05_apr' => ['string', 'max:12'],
		'i05_suma' => ['numeric', 'max:9999999999.99'],
		'i05_suma_dsk' => ['numeric', 'max:9999999999.99'],
		'i05_suma_plk' => ['numeric', 'max:9999999999.99'],
		'i05_kodas_ss' => ['string', 'max:12'],
		'i05_kodas_vl' => ['string', 'max:12'],
		'i05_kodas_vl_s' => ['string', 'max:12'],
		'i05_suma_val_dsk' => ['numeric', 'max:9999999999999999.99'],
		'i05_koef' => ['numeric', 'max:99999.999999999999999'],
		'i05_koef_s' => ['numeric', 'max:99999.999999999999999'],
		'i05_suma_val' => ['numeric', 'max:9999999999999999.99'],
		'i05_suma_val_s' => ['numeric', 'max:9999999999999999.99'],
		'i05_kodas_is' => ['string', 'max:12'],
		'i05_kodas_os' => ['string', 'max:12'],
		'i05_kodas_os_c' => ['string', 'max:12'],
		'i05_kodas_ms' => ['string', 'max:12'],
		'i05_useris' => ['string', 'max:12'],
		'i05_r_date' => ['date'],
		'i05_addusr' => ['string', 'max:12'],
		'i05_kodas_kt' => ['string', 'max:12'],
		'i05_kodas_k0' => ['string', 'max:12'],
		'i05_suma_per' => ['numeric', 'max:9999999999999999.99'],
	];
}