<?php

namespace ITCity\Rivile\Objects;

class ProductUnit extends Object {
	protected $prefix = 'N37';

	protected $defs = [
		'N37_KODAS_PS' => ['string', 'max:12'],
		'N37_KODAS_US' => ['string', 'max:12'],
		'N37_BAR_KODAS' => ['string', 'max:12'],
		'N37_TRUM_PAV' => ['string', 'max:16'],
		'N37_PAV' => ['string', 'max:40'],
		'N37_KASOS_POZ' => ['boolean'],
		'N37_SVARST_POZ' => ['boolean'],
		'N37_SK_SVARST' => ['string', 'max:4'],
		'N37_TAROS_GR' => ['string', 'max:4'],
		'N37_TAROS_SVORIS' => ['integer', 'max:999999999999'],
		'N37_FRAKCIJA_A' => ['integer', 'max:9999'],
		'N37_FRAKCIJA' => ['integer', 'max:9999'],
		'N37_KOEFICI' => ['integer', 'max:99999999999999'],
		'N37_NETTO' => ['numeric', 'max:99999999999.999'],
		'N37_BRUTTO' => ['numeric', 'max:99999999999.999'],
		'N37_TURIS' => ['numeric', 'max:99999999.9999999999'],
		'N37_ILGIS' => ['numeric', 'max:99999999999.999'],
		'N37_PLOTIS' => ['numeric', 'max:99999999999.999'],
		'N37_AUKSTIS' => ['numeric', 'max:99999999999.999'],
		'N37_R_DATE' => ['date'],
		'N37_ADDUSR' => ['string', 'max:12'],
		'N37_USERIS' => ['string', 'max:12'],
		'N37_LAIKAS_KROV' => ['integer', 'max:9999999999'],
		'N37_ORIENTACIJA' => ['integer', 'max:9'],
		'N37_AR_VIRS' => ['boolean'],
		'N37_VIRS_SVOR' => ['numeric', 'max:99999999999.999'],
		'N37_VIRS_PAK' => ['numeric', 'max:99999999999.999'],
		'N37_KODAS_US_PAK' => ['string', 'max:12'],
		'N37_KIEKIS_PAK' => ['numeric', 'max:99999999999999'],
		'N37_PAK_TIPAS' => ['integer', 'max:99'],
		'N37_PAK_MASE' => ['numeric', 'max:99999999999.999'],
		'N37_KODAS_LS_1' => ['string', 'max:12'],
		'N37_KODAS_LS_2' => ['string', 'max:12'],
		'N37_REZERVAS' => ['string', 'max:40'],
		'N37_APSKRITIS' => ['string', 'max:3'],
		'N37_SANDORIS' => ['string', 'max:3'],
		'N37_SALYGOS' => ['string', 'max:3'],
		'N37_RUSIS' => ['string', 'max:3'],
		'N37_SALIS' => ['string', 'max:3'],
		'N37_MATAS' => ['string', 'max:3'],
		'N37_SALIS_K' => ['string', 'max:3'],
		'N37_VAISTO_ID' => ['string', 'max:12'],
	];
}