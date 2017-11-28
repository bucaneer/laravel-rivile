<?php

namespace ITCity\Rivile;

use Illuminate\Support\Collection;

class QueryResult extends Collection {
	public $query;
	public $lastLoadCount;

	public function __construct($items = [], QueryBuilder $query = null) {
		parent::__construct($items);
		$this->query = $query;
		$this->lastLoadCount = $this->count();
	}

	public function hasMore() {
		return $this->lastLoadCount == 100;
	}

	public function nextQuery() {
		if (!isset($this->query)) return null;
		$interface = new RivileInterface;
		$method_def = $interface->getMethodDef($this->query->getQueryMethod());
		if (!isset($method_def['order'])) return null;
		$order_cols = $method_def['order'];
		$next_query = clone $this->query;
		$main_col = array_shift($order_cols);
		$final_item = $this->last();
		$next_query->where(function($q) use ($final_item, $order_cols, $main_col) {
			$q->where($main_col, '>', $final_item->{$main_col});
			if ($order_cols) {
				$q->orWhere(function($q) use ($final_item, $order_cols, $main_col) {
					$q->where($main_col, '=', $final_item->{$main_col});
					$q->where(function($q) use ($order_cols, $final_item) {
						foreach ($order_cols as $col) {
							$q->where($col, '>', $final_item->{$col});
						}
					});
				});
			}
		});
		
		return $next_query;
	}

	public function next() {
		$query = $this->nextQuery();
		if (!$query) return new static([], null);
		return $query->get();
	}

	public function more() {
		if ( !$this->hasMore()
			|| !( $more = $this->next() )
			|| !$more->count() )
		{
			$this->lastLoadCount = 0;
			return $this;
		}
		$merge = $this->merge($more);
		$merge->query = $more->query;
		$merge->lastLoadCount = $more->count();
		return $merge;
	}

	public function all() {
		$all = $this;
		while ($all->hasMore()) {
			$all = $all->more();
		}
		return $all;
	}
}