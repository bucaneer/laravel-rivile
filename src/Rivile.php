<?php

namespace ITCity\Rivile;

use ITCity\Rivile\Exceptions\RivileMissingKey;

/**
 * Main facade/factory for Rivile package.
 *
 * @method \ITCity\Rivile\Objects\BarCode barCode(mixed $params)
 * @method \ITCity\Rivile\Objects\CashFlow cashFlow(mixed $params)
 * @method \ITCity\Rivile\Objects\CashFlowDetail cashFlowDetail(mixed $params)
 * @method \ITCity\Rivile\Objects\Client client(mixed $params)
 * @method \ITCity\Rivile\Objects\ClientDetails clientDetails(mixed $params)
 * @method \ITCity\Rivile\Objects\Debt debt(mixed $params)
 * @method \ITCity\Rivile\Objects\DebtTotal debtTotal(mixed $params)
 * @method \ITCity\Rivile\Objects\DiscountTable discountTable(mixed $params)
 * @method \ITCity\Rivile\Objects\InternalDoc InternalDoc(mixed $params)
 * @method \ITCity\Rivile\Objects\InternalDocProd internalDocProd(mixed $params)
 * @method \ITCity\Rivile\Objects\Invoice invoice(mixed $params)
 * @method \ITCity\Rivile\Objects\InvoiceDelay invoiceDelay(mixed $params)
 * @method \ITCity\Rivile\Objects\InvoicePayment invoicePayment(mixed $params)
 * @method \ITCity\Rivile\Objects\InvoiceProd invoiceProd(mixed $params)
 * @method \ITCity\Rivile\Objects\InvoicePDF invoicePDF(mixed $params)
 * @method \ITCity\Rivile\Objects\InvoiceDebt invoiceDebt(mixed $params)
 * @method \ITCity\Rivile\Objects\LoyaltyCard loyaltyCard(mixed $params)
 * @method \ITCity\Rivile\Objects\LoyaltyOperation loyaltyOperation(mixed $params)
 * @method \ITCity\Rivile\Objects\PriceList priceList(mixed $params)
 * @method \ITCity\Rivile\Objects\ProdDiscount prodDiscount(mixed $params)
 * @method \ITCity\Rivile\Objects\ProductComponent productComponent(mixed $params)
 * @method \ITCity\Rivile\Objects\ProductPrice productPrice(mixed $params)
 * @method \ITCity\Rivile\Objects\ProductStocks productStocks(mixed $params)
 */
class Rivile {
	/**
	 * Rivile webservice key.
	 *
	 * @var string
	 */
	public $key;

	/**
	 * List of valid dynamic methods and their class mapping.
	 *
	 * @var array
	 */
	protected static $method_map = [
		'barCode' => Objects\BarCode::class,
		'cashFlow' => Objects\CashFlow::class,
		'cashFlowDetail' => Objects\CashFlowDetail::class,
		'client' => Objects\Client::class,
		'clientDetails' => Objects\ClientDetails::class,
		'clientProd' => Objects\ClientProd::class,
		'debt' => Objects\Debt::class,
		'debtTotal' => Objects\DebtTotal::class,
		'discountTable' => Objects\DiscountTable::class,
		'internalDoc' => Objects\InternalDoc::class,
		'internalDocProd' => Objects\InternalDocProd::class,
		'invoice' => Objects\Invoice::class,
		'invoiceDelay' => Objects\InvoiceDelay::class,
		'invoicePayment' => Objects\InvoicePayment::class,
		'invoiceProd' => Objects\InvoiceProd::class,
		'invoicePDF' => Objects\InvoicePDF::class,
		'invoiceDebt' => Objects\InvoiceDebt::class,
		'loyaltyCard' => Objects\LoyaltyCard::class,
		'loyaltyOperation' => Objects\LoyaltyOperation::class,
		'priceList' => Objects\PriceList::class,
		'prodDiscount' => Objects\ProdDiscount::class,
		'product' => Objects\Product::class,
		'productComponent' => Objects\ProductComponent::class,
		'productPrice' => Objects\ProductPrice::class,
		'productStocks' => Objects\ProductStocks::class,
	];

	/**
	 * Create new Rivile instance.
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
	 * Handle dynamic method calls.
	 *
	 * @param string $method
	 * @param array $parameters
	 * @return mixed
	 *
	 * @throws \BadMethodCallException
	 */
	public function __call ($method, $parameters) {
		if ($class = array_get(static::$method_map, camel_case($method))) {
			return (new $class($parameters))->setConnection($this->key);
		} else {
			throw new \BadMethodCallException("Method {$method} does not exist.");
		}
	}
}