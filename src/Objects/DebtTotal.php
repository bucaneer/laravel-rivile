<?php

namespace ITCity\Rivile\Objects;

class DebtTotal extends RivileObject {
	protected static $prefix = 'T03';

	protected static $defs = [
		't03_kodas_ks' => ['string', 'max:12'],
		't03_dok_nr' => ['string', 'max:20'],
		't03_data_mok' => ['date'],
		't03_kodas_vl' => ['string', 'max:12'],
		't03_data_dok' => ['date'],
		't03_data_dsk' => ['date'],
		't03_suma_db_vl' => ['numeric', 'max:9999999999999999.99'],
		't03_suma_cr_vl' => ['numeric', 'max:9999999999999999.99'],
		't03_suma_db' => ['numeric', 'max:9999999999.99'],
		't03_suma_cr' => ['numeric', 'max:9999999999.99'],
		't03_dsk_proc' => ['numeric', 'max:9999.99'],
		't03_suma_plk' => ['numeric', 'max:9999999999.99'],
		't03_useris' => ['string', 'max:12'],
		't03_r_date' => ['date'],
	];
}