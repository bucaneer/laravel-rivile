<?php

namespace ITCity\Rivile\Objects;

class CashFlow extends Object {
	protected static $prefix = 'I04';

	protected static $defs = [
		'i04_kodas_ch' => ['string', 'max:12'],
		'i04_dok_nr' => ['string', 'max:20'],
		'i04_op_rusis' => ['integer', 'in:1,2'],
		'i04_op_tipas' => ['boolean'],
		'i04_op_storno' => ['integer', 'max:9'],
		'i04_op_data' => ['date'],
		'i04_kodas_ss' => ['string', 'max:12'],
		'i04_moketojas' => ['integer', 'in:1,2'],
		'i04_kodas_ks' => ['string', 'max:12'],
		'i04_pav' => ['string', 'max:40'],
		'i04_adr' => ['string', 'max:40'],
		'i04_atstovas' => ['string', 'max:40'],
		'i04_kodas_vs' => ['string', 'max:12'],
		'i04_suma' => ['numeric', 'max:9999999999.99'],
		'i04_suma_dsk' => ['numeric', 'max:9999999999.99'],
		'i04_suma_plk' => ['numeric', 'max:9999999999.99'],
		'i04_pastabos' => ['string', 'max:12'],
		'i04_perkelta' => ['integer', 'in:1,2,3'],
		'i04_imp_exp' => ['integer', 'max:9'],
		'i04_kodas_vl' => ['string', 'max:12'],
		'i04_suma_val' => ['n', 'max:18,2'],
		'i04_koef' => ['numeric', 'max:99999.999999999999999'],
		'i04_useris' => ['string', 'max:12'],
		'i04_r_date' => ['date'],
		'i04_addusr' => ['string', 'max:12'],
		'i04_kodas_sm' => ['string', 'max:12'],
		'i04_aprasymas' => ['string', 'max:60'],
		'i04_suma_per' => ['numeric', 'max:9999999999.99'],
		'i04_suma_wk' => ['numeric', 'max:9999999999.99'],
		'i04_kodas_ls_1' => ['string', 'max:12'],
		'i04_kodas_ls_2' => ['string', 'max:12'],
		'i04_kodas_ls_3' => ['string', 'max:12'],
		'i04_kodas_ls_4' => ['string', 'max:12'],
		'i04_kodas_zn' => ['string', 'max:12'],
		'i04_busena' => ['integer', 'max:999'],
	];

	protected static $relation_map = [
		'i05' => ['name' => 'details', 'class' => CashFlowDetail::class],
	];
}