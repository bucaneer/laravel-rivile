<?php

namespace ITCity\Rivile\Objects;

class InvoicePDF extends RivileObject {
	protected static $query_method = 'PDF_INVOICE';

	protected static $defs = [];

	public $pdf_bin;

	public function fromList($list) {
		return [$this->instantiate($list)];
	}

	public function instantiate($item) {
		$invoice_pdf = $this->newInstance();
		$invoice_pdf->pdf_bin = base64_decode($item);
		return $invoice_pdf;
	}

	public function writeFile($filename) {
		if (!$this->pdf_bin) return null;
		return file_put_contents($filename, $this->pdf_bin);
	}
}