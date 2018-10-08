<?php

namespace ITCity\Rivile\Objects;

class BarCode extends RivileObject {
	protected static $prefix = 'N37';

	protected static $primary_key = 'N37_BAR_KODAS';

	protected static $defs = [
		'n37_kodas_ps' => ['string', 'max:12'],
		'n37_kodas_us' => ['string', 'max:12'],
		'n37_bar_kodas' => ['string', 'max:12'],
		'n37_trum_pav' => ['string', 'max:16'],
		'n37_pav' => ['string', 'max:40'],
		'n37_kasos_poz' => ['boolean'],
		'n37_svarst_poz' => ['boolean'],
		'n37_sk_svarst' => ['string', 'max:4'],
		'n37_taros_gr' => ['string', 'max:4'],
		'n37_taros_svoris' => ['integer', 'max:999999999999'],
		'n37_frakcija_a' => ['integer', 'max:9999'],
		'n37_frakcija' => ['integer', 'max:9999'],
		'n37_koefici' => ['integer', 'max:99999999999999'],
		'n37_netto' => ['numeric', 'max:99999999999.999'],
		'n37_brutto' => ['numeric', 'max:99999999999.999'],
		'n37_turis' => ['numeric', 'max:99999999.9999999999'],
		'n37_ilgis' => ['numeric', 'max:99999999999.999'],
		'n37_plotis' => ['numeric', 'max:99999999999.999'],
		'n37_aukstis' => ['numeric', 'max:99999999999.999'],
		'n37_r_date' => ['date'],
		'n37_addusr' => ['string', 'max:12'],
		'n37_useris' => ['string', 'max:12'],
		'n37_laikas_krov' => ['integer', 'max:9999999999'],
		'n37_orientacija' => ['integer', 'max:9'],
		'n37_ar_virs' => ['boolean'],
		'n37_virs_svor' => ['numeric', 'max:99999999999.999'],
		'n37_virs_pak' => ['numeric', 'max:99999999999.999'],
		'n37_kodas_us_pak' => ['string', 'max:12'],
		'n37_kiekis_pak' => ['numeric', 'max:99999999999999'],
		'n37_pak_tipas' => ['integer', 'max:99'],
		'n37_pak_mase' => ['numeric', 'max:99999999999.999'],
		'n37_kodas_ls_1' => ['string', 'max:12'],
		'n37_kodas_ls_2' => ['string', 'max:12'],
		'n37_rezervas' => ['string', 'max:40'],
		'n37_apskritis' => ['string', 'max:3'],
		'n37_sandoris' => ['string', 'max:3'],
		'n37_salygos' => ['string', 'max:3'],
		'n37_rusis' => ['string', 'max:3'],
		'n37_salis' => ['string', 'max:3'],
		'n37_matas' => ['string', 'max:3'],
		'n37_salis_k' => ['string', 'max:3'],
		'n37_vaisto_id' => ['string', 'max:12'],
	];
}