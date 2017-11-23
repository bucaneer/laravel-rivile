<?php

namespace ITCity\Rivile;

use ITCity\Rivile\Exceptions\RivileMissingKey;
use ITCity\Rivile\Exceptions\RivileInvalidMethod;
use SoapClient;

class RivileInterface {
	protected $key;
	protected $wsdl_url = 'http://manorivile.lt/WEBSERVICE_RIV_WEB/awws/webservice.awws?wsdl';
	protected $soapclient;

	protected $method_definitions = [
		'EDIT_I06'      => [
			'aliases' => ['editInvoice'],
			'params'  => ['in:I,U,D', 'xml:i06'],
		],
		'EDIT_I07'      => [
			'aliases' => ['editInvoiceProds'],
			'params'  => ['in:I,U,D', 'xml:i07'],
		],
		'EDIT_I08'      => [
			'aliases' => ['editInvoiceDelays'],
			'params'  => ['in:I,U,D', 'xml:i08'],
		],
		'EDIT_I13'      => [
			'aliases' => ['editInvoicePayment'],
			'params'  => ['in:I,U,D', 'xml:i13'],
		],
		'EDIT_I33'      => [
			'aliases' => ['editProductPrice'],
			'params'  => ['in:I,U,D', 'xml:i33'],
		],
		'EDIT_N08'      => [
			'aliases' => ['editClient'],
			'params'  => ['in:I,U,D', 'xml:n08'],
		],
		'EDIT_N17'      => [
			'aliases' => ['editProduct'],
			'params'  => ['in:I,U,D', 'xml:n17'],
		],
		'EDIT_N33'      => [
			'aliases' => ['editClientDetails'],
			'params'  => ['in:I,U,D', 'xml:n33'],
		],
		'EDIT_N37'      => [
			'aliases' => ['editProductUnits'],
			'params'  => ['in:I,U,D', 'xml:n37'],
		],
		'EDIT_I09'      => [
			'aliases' => ['editInternalDoc'],
			'params'  => ['in:I,U,D', 'xml:i09'],
		],
		'EDIT_I10'      => [
			'aliases' => ['editInternalDocdetails'],
			'params'  => ['in:I,U,D', 'xml:i10'],
		],
		'GET_I06_LIST'  => [
			'aliases' => ['getInvoices'],
			'params'  => ['in:H,A', 'where'],
		],
		'GET_I17_LIST'  => [
			'aliases' => ['getProdStocks', 'getProductStocks'],
			'params'  => ['where'],
		],
		'GET_N08_LIST'  => [
			'aliases' => ['getClients'],
			'params'  => ['in:H,A', 'where'],
			'map'     => Objects\Client::class,
		],
		'GET_N17_LIST'  => [
			'aliases' => ['getProducts'],
			'params'  => ['in:H,A', 'where'],
		],
		'GET_I33_LIST'  => [
			'aliases' => ['getProductPrices'],
			'params'  => ['where'],
		],
		'GET_I09_LIST'  => [
			'aliases' => ['getInternalDocs'],
			'params'  => ['in:H,A', 'where'],
		],
		'PDF_INVOICE'   => [
			'aliases' => ['getPDF'],
			'params'  => ['kodas_po', 'in:RO,PO', 'in:LT,EN', 'pdf_rep'],
		],
		'GET_N64_LIST'  => [
			'aliases' => ['getLoyaltyCards'],
			'params'  => ['where'],
		],
		'GET_I64_LIST'  => [
			'aliases' => ['getLoyaltyPoints'],
			'params'  => ['where'],
		],
		'EDIT_N64'      => [
			'aliases' => ['editLoyaltyCards'],
			'params'  => ['in:I,U,D', 'xml:n64'],
		],
		'EDIT_I64'      => [
			'aliases' => ['editLoyaltyPoints'],
			'params'  => ['in:I,U,D', 'xml:i64'],
		],
		'GET_N32_LIST'  => [
			'aliases' => ['getPriceLists'],
			'params'  => ['where'],
		],
		'GET_N26_LIST'  => [
			'aliases' => ['getCompoundProducts'],
			'params'  => ['where'],
		],
		'GET_N37_LIST'  => [
			'aliases' => ['getBarcode'],
			'params'  => ['barcode', 'in:H,A', 'where'],
		],
		'GET_N13_LIST'  => [
			'aliases' => ['getDiscounts'],
			'params'  => ['where'],
		],
		'GET_T03_LIST'  => [
			'aliases' => ['getCompoundDebts'],
			'params'  => ['in:H,A', 'where'],
		],
		'GET_I44_LIST'  => [
			'aliases' => ['getDebts'],
			'params'  => ['in:H,A', 'where'],
		],
		'GET_I04_LIST'  => [
			'aliases' => ['getCashFlows'],
			'params'  => ['in:H,A', 'where'],
		],
		'GET_N87_LIST'  => [
			'aliases' => ['getClientProducts'],
			'params'  => ['where'],
		],
		'GET_N31_LIST'  => [
			'aliases' => ['getDiscountTables'],
			'params'  => ['where'],
		],
		'GET_PRICE'     => [
			'aliases' => ['getPrice'],
			'params'  => ['kodas_ps', 'kodas_us', 'kodas_os', 'serija', 'kodas_is', 'numeric', 'kodas_ks', 'in:1,2,3', 'in:1,2'],
		],
		'GET_I06_DEBT'  => [
			'aliases' => ['getInvoiceDebt'],
			'params'  => ['in:H,A', 'where'],
		],
		'GET_USER_PROC' => [
			'aliases' => ['getProc'],
			'params'  => ['proc_name', 'params'],
		],
	];
	protected $inverse_aliases;

	public function __construct ($key = null) {
		if ($key) {
			$this->key = $key;
		} else {
			$this->key = env('RIVILE_KEY');
		}

		if (!$this->key) {
			throw new RivileMissingKey;
		}
	}

	protected function inverseAliases() {
		if (!isset($this->inverse_aliases)) {
			$inverse = [];
			foreach ($this->method_definitions as $method => $definition) {
				foreach ($definition['aliases'] as $alias) {
					$inverse[$alias] = $method;
				}
			}
			$this->inverse_aliases = $inverse;
		}
		return $this->inverse_aliases;
	}

	protected function findMethodByAlias($alias) {
		return array_get($this->inverseAliases(), $alias);
	}

	protected function _Soap () {
		if (is_null($this->soapclient)) {
			$this->soapclient = new SoapClient($this->wsdl_url);
		}
		return $this->soapclient;
	}
	
	protected function _soapMethod ($method, $params=array()) {
		$params_list = $this->method_definitions[$method]['params'];
		$call_params = [$this->key];
		for ($i=0; $i<count($params_list); $i++) {
			$call_params[] = isset($params[$i]) ? $params[$i] : '';
		}
		$response = call_user_func_array(array($this->_Soap(), $method), $call_params);
		return object2array(simplexml_load_string($response));
	}

	public function __call ($name, $arguments) {
		if (isset($this->method_definitions[strtoupper($name)])) {
			$method = $name;
		} else if ($method = $this->findMethodByAlias($name)) {
			$method = $method;
		} else {
			throw new RivileInvalidMethod;
		}
		$definition = $this->method_definitions[$method];

		if (isset($arguments[0]) && is_array($arguments[0])) {
			$param_map = $arguments[0];
			$param_defs = $definition['params'];
			$call_args = array_fill(0, count($param_defs), '');
			foreach ($param_map as $key => $val) {
				if (($i = array_search($key, $param_defs)) !== false) {
					$call_args[$i] = $val;
				}
			}
			$arguments = $call_args;
		}

		$raw = $this->_soapMethod($method, $arguments);
		$root = array_first($raw);
		if (!isset($root[0])) {
			$root = [$root];
		}
		if (isset($definition['map'])) {
			$map = $definition['map'];
			return $map::fromList($root);
		} else {
			return collect($root);
		}
	}
}