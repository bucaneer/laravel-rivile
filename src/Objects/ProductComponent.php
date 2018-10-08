<?php

namespace ITCity\Rivile\Objects;

class ProductComponent extends RivileObject {
	protected static $prefix = 'N26';

	protected static $defs = [
		'n26_kodas_ps' => ['string', 'max:12'],
		'n26_eil_nr' => ['integer', 'max:999999'],
		'n26_tipas' => ['integer', 'in:1,2'],
		'n26_kodas_ps_k' => ['string', 'max:12'],
		'n26_kodas_us' => ['string', 'max:12'],
		'n26_frakcija' => ['integer', 'max:9999'],
		'n26_kiekis' => ['integer', 'max:99999999999999'],
		'n26_g_kiekis' => ['integer', 'max:99999999999999'],
		'n26_isb_poz' => ['boolean'],
		'n26_iseig_proc' => ['numeric', 'max:9999.99'],
		'n26_komp_poz' => ['boolean'],
		'n26_kreps_poz' => ['boolean'],
		'n26_eksp_poz' => ['boolean'],
		'n26_kiti_poz' => ['string', 'max:5'],
		'n26_useris' => ['string', 'max:12'],
		'n26_r_date' => ['date'],
		'n26_addusr' => ['string', 'max:12'],
		'n26_komp_svs' => ['boolean'],
	];
}