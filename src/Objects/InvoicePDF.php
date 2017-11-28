<?php

namespace ITCity\Rivile\Objects;

class InvoicePDF extends Object {
	protected static $query_method = 'PDF_INVOICE';

	protected static $defs = [];

	public $pdf_bin;

	public static function fromList($list) {
		return [static::instantiate($list)];
	}

	public static function instantiate($item) {
		$invoice_pdf = new static;
		$invoice_pdf->pdf_bin = base64_decode($item);
		return $invoice_pdf;
	}

	public function writeFile($filename) {
		if (!$this->pdf_bin) return null;
		return file_put_contents($filename, $this->pdf_bin);
	}
}