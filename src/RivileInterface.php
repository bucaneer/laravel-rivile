<?php

namespace ITCity\Rivile;

use ITCity\Rivile\Exceptions\RivileMissingKey;
use ITCity\Rivile\Exceptions\RivileInvalidMethod;
use SoapClient;

/**
 * SoapClient wrapper for Rivile webservice
 *
 * @method mixed EDIT_I06(mixed $params)
 * @method mixed editInvoice(mixed $params)  Alias of EDIT_I06
 * @method mixed EDIT_I07(mixed $params)
 * @method mixed editInvoiceProds(mixed $params)  Alias of EDIT_I07
 * @method mixed EDIT_I08(mixed $params)
 * @method mixed editInvoiceDelays(mixed $params)  Alias of EDIT_I08
 * @method mixed EDIT_I13(mixed $params)
 * @method mixed editInvoicePayment(mixed $params)  Alias of EDIT_I13
 * @method mixed EDIT_I33(mixed $params)
 * @method mixed editProductPrice(mixed $params)  Alias of EDIT_I33
 * @method mixed EDIT_N08(mixed $params)
 * @method mixed editClient(mixed $params)  Alias of EDIT_N08
 * @method mixed EDIT_N17(mixed $params)
 * @method mixed editProduct(mixed $params)  Alias of EDIT_N17
 * @method mixed EDIT_N33(mixed $params)
 * @method mixed editClientDetails(mixed $params)  Alias of EDIT_N33
 * @method mixed EDIT_N37(mixed $params)
 * @method mixed editBarcode(mixed $params)  Alias of EDIT_N37
 * @method mixed EDIT_I09(mixed $params)
 * @method mixed editInternalDoc(mixed $params)  Alias of EDIT_I09
 * @method mixed EDIT_I10(mixed $params)
 * @method mixed editInternalDocProd(mixed $params)  Alias of EDIT_I10
 * @method mixed GET_I06_LIST(mixed $params)
 * @method mixed getInvoices(mixed $params)  Alias of GET_I06_LIST
 * @method mixed GET_I17_LIST(mixed $params)
 * @method mixed getProdStocks(mixed $params)  Alias of GET_I17_LIST
 * @method mixed getProductStocks(mixed $params)  Alias of GET_I17_LIST
 * @method mixed GET_N08_LIST(mixed $params)
 * @method mixed getClients(mixed $params)  Alias of GET_N08_LIST
 * @method mixed GET_N17_LIST(mixed $params)
 * @method mixed getProducts(mixed $params)  Alias of GET_N17_LIST
 * @method mixed GET_I33_LIST(mixed $params)
 * @method mixed getProductPrices(mixed $params)  Alias of GET_I33_LIST
 * @method mixed GET_I09_LIST(mixed $params)
 * @method mixed getInternalDocs(mixed $params)  Alias of GET_I09_LIST
 * @method mixed PDF_INVOICE(mixed $params)
 * @method mixed getPDF(mixed $params)  Alias of PDF_INVOICE
 * @method mixed GET_N64_LIST(mixed $params)
 * @method mixed getLoyaltyCards(mixed $params)  Alias of GET_N64_LIST
 * @method mixed GET_I64_LIST(mixed $params)
 * @method mixed getLoyaltyPoints(mixed $params)  Alias of GET_I64_LIST
 * @method mixed EDIT_N64(mixed $params)
 * @method mixed editLoyaltyCards(mixed $params)  Alias of EDIT_N64
 * @method mixed EDIT_I64(mixed $params)
 * @method mixed editLoyaltyPoints(mixed $params)  Alias of EDIT_I64
 * @method mixed GET_N32_LIST(mixed $params)
 * @method mixed getPriceLists(mixed $params)  Alias of GET_N32_LIST
 * @method mixed GET_N26_LIST(mixed $params)
 * @method mixed getProductComponents(mixed $params)  Alias of GET_N26_LIST
 * @method mixed GET_N37_LIST(mixed $params)
 * @method mixed getBarcode(mixed $params)  Alias of GET_N37_LIST
 * @method mixed GET_N13_LIST(mixed $params)
 * @method mixed getProdDiscounts(mixed $params)  Alias of GET_N13_LIST
 * @method mixed GET_T03_LIST(mixed $params)
 * @method mixed getDebtTotals(mixed $params)  Alias of GET_T03_LIST
 * @method mixed GET_I44_LIST(mixed $params)
 * @method mixed getDebts(mixed $params)  Alias of GET_I44_LIST
 * @method mixed GET_I04_LIST(mixed $params)
 * @method mixed getCashFlows(mixed $params)  Alias of GET_I04_LIST
 * @method mixed GET_N87_LIST(mixed $params)
 * @method mixed getClientProducts(mixed $params)  Alias of GET_N87_LIST
 * @method mixed GET_N31_LIST(mixed $params)
 * @method mixed getDiscountTables(mixed $params)  Alias of GET_N31_LIST
 * @method mixed GET_PRICE(mixed $params)
 * @method mixed getPrice(mixed $params)  Alias of GET_PRICE
 * @method mixed GET_I06_DEBT(mixed $params)
 * @method mixed getInvoiceDebt(mixed $params)  Alias of GET_I06_DEBT
 * @method mixed GET_USER_PROC(mixed $params)
 * @method mixed getProc(mixed $params)  Alias of GET_USER_PROC
 */
class RivileInterface {
	/**
	 * Rivile webservice key.
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * Rivile webservice URL.
	 *
	 * @var string
	 */
	protected $wsdl_url = 'http://manorivile.lt/WEBSERVICE_RIV_WEB/awws/webservice.awws?wsdl';

	/**
	 * Cached SoapClient instance.
	 *
	 * @var \SoapClient
	 */
	protected $soapclient;

	/**
	 * Number of times the current method call has been retried.
	 *
	 * @var int
	 */
	protected $retryCount = 0;

	/**
	 * Maximum number of method call retries.
	 *
	 * @var int
	 */
	protected $retryLimit = 1;

	
	/**
	 * Validation rules for method params.
	 *
	 * @var array
	 */
	protected $param_validation = [
		'edit' => 'in:I,U,D',
		'get' => 'in:H,A',
		'language' => 'in:LT,EN',
		'kiekis' => 'numeric',
		'ps_tip' => 'in:1,2,3',
		'op_tip' => 'in:1,2',
		'module' => 'in:RO,PO',
	];

	/**
	 * Indicates if results should be output as raw array without mapping to Objects.
	 *
	 * @var bool
	 */
	public $raw_output = false;

	/**
	 * List of webservice method definitions with aliases, param lists and mapping details.
	 *
	 * @var array
	 */
	protected $method_definitions = [
		'EDIT_I06'      => [
			'aliases' => ['editInvoice'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\Invoice::class,
		],
		'EDIT_I07'      => [
			'aliases' => ['editInvoiceProds'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\InvoiceProd::class,
		],
		'EDIT_I08'      => [
			'aliases' => ['editInvoiceDelays'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\InvoiceDelay::class,
		],
		'EDIT_I13'      => [
			'aliases' => ['editInvoicePayment'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\InvoicePayment::class,
		],
		'EDIT_I33'      => [
			'aliases' => ['editProductPrice'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\ProductPrice::class,
		],
		'EDIT_N08'      => [
			'aliases' => ['editClient'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\Client::class,
		],
		'EDIT_N17'      => [
			'aliases' => ['editProduct'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\Product::class,
		],
		'EDIT_N33'      => [
			'aliases' => ['editClientDetails'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\ClientDetails::class,
		],
		'EDIT_N37'      => [
			'aliases' => ['editBarcode'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\BarCode::class,
		],
		'EDIT_I09'      => [
			'aliases' => ['editInternalDoc'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\InternalCode::class,
		],
		'EDIT_I10'      => [
			'aliases' => ['editInternalDocProd'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\InternalDocProd::class,
		],
		'GET_I06_LIST'  => [
			'aliases' => ['getInvoices'],
			'params'  => ['get', 'where'],
			'map'     => Objects\Invoice::class,
			'order'   => ['i06_kodas_po'],
		],
		'GET_I17_LIST'  => [
			'aliases' => ['getProdStocks', 'getProductStocks'],
			'params'  => ['where'],
			'map'     => Objects\ProductStocks::class,
			'order'   => ['i17_kodas_ps','i17_kodas_is','i17_kodas_us_a','i17_kodas_os','i17_serija'],
		],
		'GET_N08_LIST'  => [
			'aliases' => ['getClients'],
			'params'  => ['get', 'where'],
			'map'     => Objects\Client::class,
			'order'   => ['n08_kodas_ks'],
		],
		'GET_N17_LIST'  => [
			'aliases' => ['getProducts'],
			'params'  => ['get', 'where'],
			'map'     => Objects\Product::class,
			'order'   => ['n17_kodas_ps'],
		],
		'GET_I33_LIST'  => [
			'aliases' => ['getProductPrices'],
			'params'  => ['where'],
			'map'     => Objects\ProductPrice::class,
			'order'   => ['i33_kodas_ps','i33_kodas_is','i33_kodas_us'],
		],
		'GET_I09_LIST'  => [
			'aliases' => ['getInternalDocs'],
			'params'  => ['get', 'where'],
			'map'     => Objects\InternalDoc::class,
			'order'   => ['i09_kodas_vd'],
		],
		'PDF_INVOICE'   => [
			'aliases' => ['getPDF'],
			'params'  => ['kodas_po', 'module', 'language', 'pdf_rep'],
			'map'     => Objects\InvoicePDF::class,
		],
		'GET_N64_LIST'  => [
			'aliases' => ['getLoyaltyCards'],
			'params'  => ['where'],
			'map'     => Objects\LoyaltyCard::class,
			'order'   => ['n64_kodas_dl'],
		],
		'GET_I64_LIST'  => [
			'aliases' => ['getLoyaltyPoints'],
			'params'  => ['where'],
			'map'     => Objects\LoyaltyOperation::class,
			'order'   => ['i64_kodas_dl'],
		],
		'EDIT_N64'      => [
			'aliases' => ['editLoyaltyCards'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\LoyaltyCard::class,
		],
		'EDIT_I64'      => [
			'aliases' => ['editLoyaltyPoints'],
			'params'  => ['edit', 'xml'],
			'map'     => Objects\LoyaltyOperation::class,
		],
		'GET_N32_LIST'  => [
			'aliases' => ['getPriceLists'],
			'params'  => ['where'],
			'map'     => Objects\PriceList::class,
			'order'   => ['n32_kodas_ps','n32_kodas_us','n32_tipas,n32_g_date','n32_id'],
		],
		'GET_N26_LIST'  => [
			'aliases' => ['getProductComponents'],
			'params'  => ['where'],
			'map'     => Objects\ProductComponent::class,
			'order'   => ['n26_kodas_ps','n26_eil_nr'],
		],
		'GET_N37_LIST'  => [
			'aliases' => ['getBarcode'],
			'params'  => ['barcode', 'get', 'where'],
			'map'     => Objects\BarCode::class,
			'order'   => ['n37_kodas_ps','n37_kodas_us'],
		],
		'GET_N13_LIST'  => [
			'aliases' => ['getProdDiscounts'],
			'params'  => ['where'],
			'map'     => Objects\ProdDiscount::class,
			'order'   => ['n13_kodas_ps','n13_kodas_us','n13_kodas_is','n13_eil_nr'],
		],
		'GET_T03_LIST'  => [
			'aliases' => ['getDebtTotals'],
			'params'  => ['get', 'where'],
			'map'     => Objects\DebtTotal::class,
			'order'   => ['t03_kodas_ks'],
		],
		'GET_I44_LIST'  => [
			'aliases' => ['getDebts'],
			'params'  => ['get', 'where'],
			'map'     => Objects\Debt::class,
			'order'   => ['i44_modul','i44_kodas_op','i44_eil_nr','i44_tipas'],
		],
		'GET_I04_LIST'  => [
			'aliases' => ['getCashFlows'],
			'params'  => ['get', 'where'],
			'map'     => Objects\CashFlow::class,
			'order'   => ['i04_kodas_ch'],
		],
		'GET_N87_LIST'  => [
			'aliases' => ['getClientProducts'],
			'params'  => ['where'],
			'map'     => Objects\ClientProd::class,
			'order'   => ['n87_kodas_ps','n87_kodas_us','n87_kodas_ks'],
		],
		'GET_N31_LIST'  => [
			'aliases' => ['getDiscountTables'],
			'params'  => ['where'],
			'map'     => Objects\DiscountTable::class,
			'order'   => ['n31_kodas_ns','n31_eil_nr'],
		],
		'GET_PRICE'     => [
			'aliases' => ['getPrice'],
			'params'  => ['kodas_ps', 'kodas_us', 'kodas_os', 'serija', 'kodas_is', 'kiekis', 'kodas_ks', 'ps_tip', 'op_tip'],
		],
		'GET_I06_DEBT'  => [
			'aliases' => ['getInvoiceDebt'],
			'params'  => ['get', 'where'],
			'map'     => Objects\InvoiceDebt::class,
			'order'   => ['i06_kodas_ks'],
		],
		'GET_USER_PROC' => [
			'aliases' => ['getProc'],
			'params'  => ['proc_name', 'params'],
		],
	];

	/**
	 * Cache of alias-to-raw method name mappings.
	 *
	 * @var array
	 */
	protected $inverse_aliases;

	/**
	 * Create a new RivileInterface instance.
	 *
	 * @param null|string $key
	 */
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

	/**
	 * Get alias-to-raw method name map.
	 *
	 * @return array
	 */
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

	/**
	 * Get raw webservice method name from an alias.
	 *
	 * @param string $alias
	 * @return string
	 */
	protected function findMethodByAlias($alias) {
		return array_get($this->inverseAliases(), $alias);
	}

	/**
	 * Get webservice method definition array from any valid name.
	 *
	 * @param string $name
	 * @return array
	 */
	public function getMethodDef ($name) {
		if (isset($this->method_definitions[strtoupper($name)])) {
			$method = $name;
		} else if ($method = $this->findMethodByAlias($name)) {
			$method = $method;
		} else {
			throw new RivileInvalidMethod;
		}
		return $this->method_definitions[$method];
	}

	/**
	 * Get a SoapClient instance.
	 *
	 * @return \SoapClient
	 */
	protected function _Soap () {
		if (is_null($this->soapclient)) {
			$this->soapclient = new SoapClient($this->wsdl_url);
		}
		return $this->soapclient;
	}
	
	/**
	 * Call a webservice method. 
	 * 
	 * Returns the response converted into an array.
	 *
	 * @param string $method
	 * @param array $params
	 * @return array
	 */
	protected function _soapMethod ($method, $params=array()) {
		$params_list = $this->method_definitions[$method]['params'];
		$call_params = [$this->key];
		for ($i=0; $i<count($params_list); $i++) {
			$call_params[] = isset($params[$i]) ? $params[$i] : '';
		}
		try {
			$response = $this->_Soap()->__soapCall($method, $call_params);
		} catch (\SoapFault $e) {
			if ($this->retryCount < $this->retryLimit) {
				// Try to re-initialize SoapClient
				$this->soapclient = null;
				$this->retryCount++;
				return $this->_soapMethod($method, $params);
			} else {
				logger("SoapFault", [$method, $call_params, $this->soapclient->__getLastResponse()]);
				throw $e;
			}
		}
		$this->retryCount = 0;
		return object2array(simplexml_load_string($response));
	}

	/**
	 * Handle dynamic method calls.
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 *
	 * @throws \ITCity\Rivile\Exceptions\RivileInvalidMethod
	 * @throws \ITCity\Rivile\Exceptions\RivileSoapError if the webservice response is an error
	 */
	public function __call ($name, $arguments) {
		if (isset($this->method_definitions[strtoupper($name)])) {
			$method = $name;
		} else if ($method = $this->findMethodByAlias($name)) {
			$method = $method;
		} else {
			throw new RivileInvalidMethod;
		}
		$definition = $this->method_definitions[$method];

		/**
		 * Method called with array argument - map named parameters.
		 */
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

		reset($raw);
		if(key($raw) == 'ERROR') {
			throw new Exceptions\RivileSoapError(print_r(current($raw), true)."\nArguments: ".print_r($arguments, true));
		}

		$root = array_first($raw);
		if ($this->raw_output) {
			return $root;
		}
		if (!isset($root[0])) {
			$root = [$root];
		}

		if (isset($definition['map'])) {
			$map = (new $definition['map'])->setConnection($this->key);
			return $map->fromList($root);
		} else {
			return collect($root);
		}
	}

	/**
	 * Set preference for raw output of webservice responses.
	 *
	 * @param bool $raw
	 * @return $this
	 */
	public function setRawOutput($raw) {
		$this->raw_output = (bool) $raw;
		return $this;
	}
}