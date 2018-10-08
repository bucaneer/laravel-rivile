<?php

namespace ITCity\Rivile\Objects;

class Invoice extends RivileObject {
	protected static $prefix = 'I06';

	protected static $primary_key = 'i06_kodas_po';

	protected static $defs = [
		'i06_kodas_po' => ['string', 'max:12'],
		'i06_op_tip' => ['integer', 'in:1,2,3,4,51,52,53,54,55,56'],
		'i06_val_poz' => ['boolean'],
		'i06_pvm_tip' => ['boolean'],
		'i06_op_storno' => ['boolean'],
		'i06_dok_nr' => ['string', 'max:20'],
		'i06_op_data' => ['date'],
		'i06_dok_data' => ['date'],
		'i06_kodas_ms' => ['string', 'max:12'],
		'i06_kodas_ks' => ['string', 'max:12'],
		'i06_kodas_ss' => ['string', 'max:12'],
		'i06_pav' => ['string', 'max:70'],
		'i06_adr' => ['string', 'max:40'],
		'i06_atstovas' => ['string', 'max:40'],
		'i06_kodas_vs' => ['string', 'max:12'],
		'i06_pav2' => ['string', 'max:70'],
		'i06_adr2' => ['string', 'max:40'],
		'i06_adr3' => ['string', 'max:40'],
		'i06_kodas_vl' => ['string', 'max:12'],
		'i06_kodas_xs' => ['string', 'max:12'],
		'i06_kodas_ss_p' => ['string', 'max:12'],
		'i06_pastabos' => ['string', 'max:40'],
		'i06_mok_dok' => ['string', 'max:12'],
		'i06_mok_suma' => ['numeric', 'max:9999999999.99'],
		'i06_kodas_ss_m' => ['string', 'max:12'],
		'i06_suma_val' => ['numeric', 'max:9999999999999999.99'],
		'i06_suma' => ['numeric', 'max:9999999999.99'],
		'i06_suma_pvm' => ['numeric', 'max:9999999999.99'],
		'i06_kursas' => ['numeric', 'max:9999999999.9999999999'],
		'i06_perkelta' => ['integer', 'in:1,2,3'],
		'i06_addusr' => ['string', 'max:12'],
		'i06_r_date' => ['date'],
		'i06_useris' => ['string', 'max:12'],
		'i06_kodas_au' => ['string', 'max:12'],
		'i06_kodas_sm' => ['string', 'max:12'],
		'i06_intrastat' => ['boolean'],
		'i06_dok_reg' => ['string', 'max:20'],
		'i06_kodas_ak' => ['string', 'max:12'],
		'i06_suma_wk' => ['numeric', 'max:9999999999.99'],
		'i06_kodas_ls_1' => ['string', 'max:12'],
		'i06_kodas_ls_2' => ['string', 'max:12'],
		'i06_kodas_ls_3' => ['string', 'max:12'],
		'i06_kodas_ls_4' => ['string', 'max:12'],
		'i06_val_poz_pvm' => ['N', 'max:1'],
		'i06_pvm_val' => ['numeric', 'max:999999999999999.999'],
		'i06_web_poz' => ['boolean'],
		'i06_web_atas' => ['string', 'max:13'],
		'i06_web_perkelta' => ['boolean'],
		'i06_aprasymas1' => ['string', 'max:150'],
		'i06_aprasymas2' => ['string', 'max:150'],
		'i06_aprasymas3' => ['string', 'max:150'],
	];

	protected static $relation_map = [
		'i07' => ['name' => 'products', 'class' => InvoiceProd::class],
		'i08' => ['name' => 'delays',   'class' => InvoiceDelay::class],
		'i13' => ['name' => 'payments', 'class' => InvoicePayment::class],
	];
	protected static $relation_key = 'kodas_po';

	protected static $insert_reqs = [
		'i06_op_tip',
		'i06_kodas_ks',
		'i06_kodas_xs',
	];
}