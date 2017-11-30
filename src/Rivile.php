<?php

namespace ITCity\Rivile;

use ITCity\Rivile\Exceptions\RivileMissingKey;

class Rivile {
	public $key;

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
		'invoicePayment' => Objects\InvoicePayments::class,
		'invoiceProd' => Objects\InvoiceProd::class,
		'invoicePDF' => Objects\InvoicePDF::class,
		'loyaltyCard' => Objects\LoyaltyCard::class,
		'loyaltyOperation' => Objects\LoyaltyOperation::class,
		'priceList' => Objects\PriceList::class,
		'prodDiscount' => Objects\ProdDiscount::class,
		'product' => Objects\Product::class,
		'productComponent' => Objects\ProductComponent::class,
		'productPrice' => Objects\ProductPrice::class,
		'productStocks' => Objects\ProductStocks::class,
	];

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

	public function __call ($method, $parameters) {
		if ($class = array_get(static::$method_map, camel_case($method))) {
			return (new $class($parameters))->setConnection($this->key);
		} else {
			throw new \BadMethodCallException("Method {$method} does not exist.");
		}
	}
}