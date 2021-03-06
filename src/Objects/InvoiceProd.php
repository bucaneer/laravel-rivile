<?php

namespace ITCity\Rivile\Objects;

use ITCity\Rivile\Exceptions\RivileInvalidObject;

class InvoiceProd extends RivileObject {
	protected static $prefix = 'I07';

	protected static $primary_key = ['i07_kodas_po', 'i07_eil_nr'];

	protected static $defs = [
		'i07_kodas_po' => ['string', 'max:12'],
		'i07_eil_nr' => ['integer', 'max:999999'],
		'i07_tipas' => ['integer', 'in:1,2,3,4,5'],
		'i07_kodas' => ['string', 'max:12'],
		'i07_pav' => ['string', 'max:40'],
		'i07_kodas_tr' => ['string', 'max:12'],
		'i07_kodas_is' => ['string', 'max:12'],
		'i07_kodas_os' => ['string', 'max:12'],
		'i07_kodas_os_c' => ['string', 'max:12'],
		'i07_serija' => ['string', 'max:12'],
		'i07_kodas_us' => ['string', 'max:12'],
		'i07_kiekis' => ['integer', 'max:99999999999999'],
		'i07_frakcija' => ['integer', 'max:9999'],
		'i07_kodas_us_p' => ['string', 'max:12'],
		'i07_kodas_us_a' => ['string', 'max:12'],
		'i07_alt_kiekis' => ['integer', 'max:99999999999999'],
		'i07_alt_frak' => ['integer', 'max:9999'],
		'i07_val_kaina' => ['numeric', 'max:99999999999999.9999'],
		'i07_suma_val' => ['numeric', 'max:9999999999999999.99'],
		'i07_kaina_be' => ['numeric', 'max:99999999.9999'],
		'i07_kaina_su' => ['numeric', 'max:99999999.9999'],
		'i07_nuolaida' => ['numeric', 'max:9999.99'],
		'i07_islaidu_m' => ['boolean'],
		'i07_islaidos' => ['numeric', 'max:9999999999.99'],
		'i07_islaidos_pvm' => ['numeric', 'max:9999999999.99'],
		'i07_muitas_m' => ['boolean'],
		'i07_muitas' => ['numeric', 'max:9999999999.99'],
		'i07_muitas_pvm' => ['numeric', 'max:9999999999.99'],
		'i07_akcizas_m' => ['boolean'],
		'i07_akcizas' => ['numeric', 'max:9999999999.99'],
		'i07_akcizas_pvm' => ['numeric', 'max:9999999999.99'],
		'i07_mokestis' => ['boolean'],
		'i07_mokestis_p' => ['numeric', 'max:9999.99'],
		'i07_pvm' => ['numeric', 'max:9999999999.99'],
		'i07_suma' => ['numeric', 'max:9999999999.99'],
		'i07_par_kaina' => ['numeric', 'max:99999999.9999'],
		'i07_par_kaina_n' => ['numeric', 'max:99999999.9999'],
		'i07_mok_suma' => ['numeric', 'max:9999999999.99'],
		'i07_savikaina' => ['numeric', 'max:9999999999.99'],
		'i07_galioja_iki' => ['date'],
		'i07_perkelta' => ['integer', 'in:1,2'],
		'i07_addusr' => ['string', 'max:12'],
		'i07_useris' => ['string', 'max:12'],
		'i07_r_date' => ['date'],
		'i07_sertifikatas' => ['string', 'max:12'],
		'i07_kodas_kt' => ['string', 'max:12'],
		'i07_kodas_k0' => ['string', 'max:12'],
		'i07_kodas_kv' => ['string', 'max:12'],
		'i07_kodas_vz' => ['string', 'max:12'],
		'i07_add_date' => ['date'],
		'i07_apskritis' => ['string', 'max:3'],
		'i07_sandoris' => ['string', 'max:3'],
		'i07_salygos' => ['string', 'max:3'],
		'i07_rusis' => ['string', 'max:3'],
		'i07_salis' => ['string', 'max:3'],
		'i07_matas' => ['string', 'max:3'],
		'i07_salis_k' => ['string', 'max:3'],
		'i07_mase' => ['numeric', 'max:99999999999.999'],
		'i07_int_kiekis' => ['numeric', 'max:99999999999.999'],
		'i07_pvm_val' => ['numeric', 'max:9999999999999999.99'],
		'i07_kodas_ks' => ['string', 'max:12'],
		'i07_aprasymas1' => ['string', 'max:150'],
		'i07_aprasymas2' => ['string', 'max:150'],
		'i07_aprasymas3' => ['string', 'max:150'],
		'i07_kodas_kl' => ['string', 'max:12'],
		'kiekis_a' => ['numeric', 'max:99999999.9999'],
		'bar_kodas' => ['string', 'max:12'],
	];

	protected static $insert_reqs = [
		'i07_kodas_po',
		'i07_tipas',
		'i07_kodas_is',
		'i07_kodas',
		'i07_kodas_us',
		'i07_kaina_be',
		'i07_suma',
		'i07_pvm',
		'kiekis_a',
	];

	public function fromProd ($reference) {
		$product = null;
		if ($reference instanceof Product) {
			$product = $reference;
		} else if (is_string($reference)) {
			$product = (new Product)->setConnection($this->getConnectionName())->find($reference);
		}
		if (!($product instanceof Product)) {
			throw new RivileInvalidObject;
		}

		$copy_attrs = ['tipas' => null, 'kodas' => 'kodas_ps', 'pav' => null, 'kodas_us' => null];
		foreach ($copy_attrs as $this_attr => $prod_attr) {
			$prod_attr = $prod_attr ?: $this_attr;
			$this->{$this_attr} = $product->{$prod_attr};
		}

		return $this;
	}
}