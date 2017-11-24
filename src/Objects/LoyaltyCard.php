<?php

namespace ITCity\Rivile\Objects;

class LoyaltyCard extends Object {
	protected static $prefix = 'N64';

	protected static $defs = [
		'n64_kodas_dl' => ['string', 'max:12'],
		'n64_date' => ['date'],
		'n64_kodas_ks' => ['string', 'max:12'],
		'n64_pav' => ['string', 'max:50'],
		'n64_vardas' => ['string', 'max:50'],
		'n64_kodas_vs' => ['string', 'max:12'],
		'n64_adr1' => ['string', 'max:40'],
		'n64_adr2' => ['string', 'max:40'],
		'n64_adr3' => ['string', 'max:40'],
		'n64_gim_data' => ['date'],
		'n64_lytis' => ['integer', 'max:9'],
		'n64_kodas_ls_1' => ['string', 'max:12'],
		'n64_kodas_ls_2' => ['string', 'max:12'],
		'n64_kodas_ls_3' => ['string', 'max:12'],
		'n64_kodas_ls_4' => ['string', 'max:12'],
		'n64_poz_date' => ['boolean'],
		'n64_beg_date' => ['date'],
		'n64_end_date' => ['date'],
		'n64_useris' => ['string', 'max:12'],
		'n64_r_date' => ['date'],
		'n64_addusr' => ['string', 'max:12'],
		'n64_asm_kodas' => ['string', 'max:20'],
		'n64_tel' => ['string', 'max:30'],
		'n64_mob_tel' => ['string', 'max:30'],
		'n64_e_mail' => ['string', 'max:60'],
		'n64_korteles_id' => ['string', 'max:40'],
		'n64_blok_poz' => ['boolean'],
		'n64_blok_date' => ['date'],
		'n64_blok_user' => ['string', 'max:12'],
		'n64_kodas_ls_5' => ['string', 'max:12'],
		'n64_kodas_ls_6' => ['string', 'max:12'],
		'n64_kodas_ls_7' => ['string', 'max:12'],
		'n64_kodas_ls_8' => ['string', 'max:12'],
		'n64_korteles_id_a' => ['string', 'max:40'],
		'n64_kodas_sm' => ['string', 'max:12'],
		'n64_neaktyvi' => ['boolean'],
		'n64_korteles_id_poz' => ['boolean'],
		'n64_korteles_id_i1' => ['string', 'max:40'],
		'n64_korteles_id_i2' => ['string', 'max:40'],
		'n64_apras' => ['string', 'max:40'],
	];
}