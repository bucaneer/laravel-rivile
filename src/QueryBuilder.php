<?php

namespace ITCity\Rivile;

use ITCity\Rivile\Objects\Object;
use ITCity\Rivile\Exceptions\RivileMalformedWhere;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Connection;

class QueryBuilder extends Builder{

	public function __construct($object) {
		$this->object = $object;
		parent::__construct(new Connection(null), new QueryGrammar);
	}

	public function toSql() {
		$query_string = (new QueryGrammar)->whereString($this);
		$processed_query = str_replace('?', "'%s'", $query_string);
		$args = [$processed_query];
		foreach ($this->bindings['where'] as $binding) {
			$args[] = $binding;
		}
		return sprintf(...$args);
	}

	public function find ($value, $columns = null) {
		return $this->where($this->object::getPrimaryKey(), $value)->get()->first();
	}

	public function get ($param = null) {
		$interface = new RivileInterface;
		return $interface->{$this->object::getQueryMethod()}(['where' => $this->toSql()]);
	}
}