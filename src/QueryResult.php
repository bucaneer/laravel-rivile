<?php

namespace ITCity\Rivile;

use Illuminate\Support\Collection;

/**
 * A subclass of Collection that allows loading additional items from Rivile.
 */
class QueryResult extends Collection {

	/**
	 * A QueryBuilder instance.
	 *
	 * @var \ITCity\Rivile\QueryBuilder
	 */
	public $query;

	/**
	 * QueryBuilder instance that nextQuery is based on.
	 *
	 * @var \ITCity\Rivile\QueryBuilder
	 */
	public $base_query;

	/**
	 * Number of items loaded on latest load.
	 *
	 * @var int
	 */
	public $lastLoadCount;

	/**
	 * Create new QueryResult intance.
	 *
	 * @param mixed $items
	 * @param \ITCity\Rivile\QueryBuilder|null $query
	 */
	public function __construct($items = [], QueryBuilder $query = null) {
		parent::__construct($items);
		$this->query = $query;
		$this->lastLoadCount = $this->count();
	}

	/**
	 * Determine if the associated query potentially has more items to load.
	 *
	 * @return bool
	 */
	public function hasMore() {
		return $this->lastLoadCount == 100;
	}

	/**
	 * Create a query for loading the next batch of items.
	 *
	 * This relies on knowing which columns the original query was sorted on.
	 * Rivile webservice has a fixed ordering behavior for each method, which is
	 * listed in Rivile webservice documentation and stored in RivileInterface 
	 * method definitions.
	 *
	 * @return \ITCity\Rivile\QueryBuilder|null
	 */
	public function nextQuery() {
		if (!isset($this->query)) return null;
		if (!isset($this->base_query)) {
			$this->base_query = $this->query;
		}
		
		// Get query method definition
		$interface = $this->base_query->getInterface();
		$method_def = $interface->getMethodDef($this->base_query->getQueryMethod());
		if (!isset($method_def['order'])) return null;
		
		$order_cols = $method_def['order'];
		$next_query = clone $this->base_query;
		$next_query->base_query = $this->base_query;
		$main_col = array_shift($order_cols);
		// Assume the items haven't been reordered since retrieval.
		$final_item = $this->last();
		
		$next_query->where(function($q) use ($final_item, $order_cols, $main_col) {
			$q->where($main_col, '>', $final_item->{$main_col});
			
			// Special case when query is ordered on multiple columns: check for items
			// that have the same primary column value as the last item, but higher
			// values in other columns.
			if ($order_cols) {
				$q->orWhere(function($q) use ($final_item, $order_cols, $main_col) {
					$q->where($main_col, '=', $final_item->{$main_col});
					$q->where(function($q) use ($order_cols, $final_item) {
						foreach ($order_cols as $col) {
							if (!isset($final_item->{$col})) continue;
							$q->where($col, '>', $final_item->{$col});
						}
					});
				});
			}
		});
		
		return $next_query;
	}

	/**
	 * Retrieve the next batch of items for current query.
	 *
	 * @return \ITCity\Rivile\QueryResult
	 */
	public function next() {
		$query = $this->nextQuery();
		if (!$query) return new static([], null);
		$next = $query->get();
		$next->base_query = $this->base_query;
		return $next;
	}

	/**
	 * Load the next batch of items and return the results appended to current batch.
	 *
	 * @return \ITCity\Rivile\QueryResult
	 */
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

	/**
	 * Load all available items for current query.
	 *
	 * May take a very long time.
	 *
	 * @return \ITCity\Rivile\QueryResult
	 */
	public function loadAll() {
		$all = $this;
		while ($all->hasMore()) {
			$all = $all->more();
		}
		return $all;
	}
}