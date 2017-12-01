<?php

namespace ITCity\Rivile;

use ITCity\Rivile\Objects\Object;
use ITCity\Rivile\Exceptions\RivileMalformedWhere;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Connection;
use SoapVar;

class QueryBuilder extends Builder {
	/**
	 * Associative array of parameters for webservice method.
	 *
	 * @var array
	 */
	protected $method_params = [];

	/**
	 * Associated Object instance.
	 *
	 * @var ITCity\Rivile\Objects\Object
	 */
	public $rivile_object;

	/**
	 * Indicates if results should be output as raw unmapped array.
	 *
	 * @var bool
	 */
	public $raw_output = false;

	/**
	 * Create new QueryBuilder instance.
	 *
	 * @param \ITCity\Rivile\Objects\Object $object
	 * @param \Illuminate\Database\ConnectionInterface  $connection
	 * @param \Illuminate\Database\Query\Grammars\Grammar  $grammar
	 * @param \Illuminate\Database\Query\Processors\Processor  $processor
	 */
	public function __construct($object, $connection = null, $grammar = null, $processor = null) {
		if ($connection == null) $connection = new Connection(null);
		if ($grammar == null) $grammar = new QueryGrammar;
		$this->rivile_object = $object;
		parent::__construct($connection, $grammar, $processor);
	}

	/**
	 * Construct an SQL where clause string for passing to webservice.
	 *
	 * @return string
	 */
	public function toSql() {
		$query_string = (new QueryGrammar)->whereString($this);
		$processed_query = str_replace('?', "'%s'", $query_string);
		$args = [$processed_query];
		foreach ($this->bindings['where'] as $binding) {
			$args[] = $binding;
		}
		return sprintf(...$args);
	}

	/**
	 * Execute an edit method on the associated object via webservice.
	 *
	 * @param string $edit One of 'I' (insert), 'U' (update) or 'D' (delete)
	 * @param string $xml
	 * @return mixed
	 */
	public function edit ($edit = null, $xml = null) {
		$interface = $this->getInterface();
		$interface->raw_output = true;
		$xml = '<xml_info><![CDATA['.$xml.']]></xml_info>';
		$xml = new SoapVar($xml, XSD_ANYXML);
		return $interface->{$this->getEditMethod()}(compact('edit', 'xml'));
	}

	/**
	 * Setup a 'find' query based on object primary key(s).
	 *
	 * @param mixed $values
	 * @return $this
	 */
	public function findQuery ($values) {
		$primary = array_values(array_wrap($this->rivile_object::getPrimaryKey()));
		$values = array_values(array_wrap($values));
		if (count($values) !== count($primary)) {
			throw new RivileMalformedWhere('Find for '.get_class($this->rivile_object).' needs '.count($primary).' values, '.count($values).' given.');
		}
		foreach ($primary as $i => $key) {
			$value = $values[$i];
			$this->where($key, $value);
		}
		return $this;
	}

	/**
	 * Execute a query for a single record by primary key(s).
	 *
	 * @param mixed $value
	 * @param array $columns
	 * @return mixed
	 */
	public function find ($value, $columns = null) {
		return $this->findQuery($value)->get()->first();
	}

	/**
	 * Bind named parameter(s) for the webservice method.
	 *
	 * @param string|array $param
	 * @param mixed $value
	 * @return $this
	 */
	public function bind ($param, $value = null) {
		if (is_array($param)) {
			foreach ($param as $key => $val) {
				$this->bind($key, $val);
			}
			return $this;
		}

		$this->method_params[$param] = $value;

		return $this;
	}

	/**
	 * Execute a get method via webservice.
	 *
	 * @param mixed $param
	 * @return mixed
	 */
	public function get ($param = null) {
		$this->bind('where', $this->toSql());
		$interface = $this->getInterface();
		$interface->raw_output = $this->raw_output;
		$raw = $interface->{$this->getQueryMethod()}($this->method_params);
		if ($this->raw_output) {
			return $raw;
		} else {
			return query_result($raw, $this);
		}
	}

	/**
	 * Execute a get method and return the first result.
	 *
	 * @param array $columns
	 * @return mixed
	 */
	public function first ($columns = ['*']) {
		if ($this->raw_output) {
			return $this->get($columns);
		}
		return $this->get($columns)->first();
	}

	/**
	 * Execute an update query on the associated object via webservice.
	 *
	 * @param array $values
	 * @return mixed
	 */
	public function update (array $values = []) {
		return $this->edit('U', $this->rivile_object->toXml());
	}

	/**
	 * Execute an insert query on the associated object via webservice.
	 *
	 * @param array $values
	 * @return mixed
	 */
	public function insert (array $values = []) {
		return $this->edit('I', $this->rivile_object->toXml());
	}

	/**
	 * Execute a delete query on the associated object via webservice.
	 *
	 * @param array $values
	 * @return mixed
	 */
	public function delete ($id = null) {
		return $this->edit('D', $this->rivile_object->toXml());
	}

	/**
	 * Get the associated get query method name.
	 *
	 * @return string|null
	 */
	public function getQueryMethod () {
		return $this->rivile_object::getQueryMethod();
	}

	/**
	 * Get the associated edit query method name.
	 *
	 * @return string|null
	 */
	public function getEditMethod () {
		return $this->rivile_object::getEditMethod();
	}

	/**
	 * Get a RivileInterface instance.
	 *
	 * @return \ITCity\Rivile\RivileInterface
	 */
	public function getInterface () {
		return $this->rivile_object->getConnection();
	}

	/**
	 * Get a new instance of the query builder.
	 *
	 * @return \ITCity\Rivile\QueryBuilder
	 */
	public function newQuery() {
        return new static($this->rivile_object, $this->connection, $this->grammar, $this->processor);
    }

    /**
     * Block inherited methods.
     *
     * @throws \BadMethodCallException
     */
    protected function __missingMethod() {
    	throw new \BadMethodCallException();
    }

    /**
     * Public methods from parent that are not implemented here.
     */
    public function select($columns = ['*']) { return $this->__missingMethod(); }
    public function selectRaw($expression, array $bindings = []) { return $this->__missingMethod(); }
    public function selectSub($query, $as) { return $this->__missingMethod(); }
    public function addSelect($column) { return $this->__missingMethod(); }
    public function distinct() { return $this->__missingMethod(); }
    public function from($table) { return $this->__missingMethod(); }
    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false) { return $this->__missingMethod(); }
    public function joinWhere($table, $first, $operator, $second, $type = 'inner') { return $this->__missingMethod(); }
    public function leftJoin($table, $first, $operator = null, $second = null) { return $this->__missingMethod(); }
    public function leftJoinWhere($table, $first, $operator, $second) { return $this->__missingMethod(); }
    public function rightJoin($table, $first, $operator = null, $second = null) { return $this->__missingMethod(); }
    public function rightJoinWhere($table, $first, $operator, $second) { return $this->__missingMethod(); }
    public function crossJoin($table, $first = null, $operator = null, $second = null) { return $this->__missingMethod(); }
    public function groupBy(...$groups) { return $this->__missingMethod(); }
    public function having($column, $operator = null, $value = null, $boolean = 'and') { return $this->__missingMethod(); }
    public function orHaving($column, $operator = null, $value = null) { return $this->__missingMethod(); }
    public function havingRaw($sql, array $bindings = [], $boolean = 'and') { return $this->__missingMethod(); }
    public function orHavingRaw($sql, array $bindings = []) { return $this->__missingMethod(); }
    public function orderBy($column, $direction = 'asc') { return $this->__missingMethod(); }
    public function orderByDesc($column) { return $this->__missingMethod(); }
    public function latest($column = 'created_at') { return $this->__missingMethod(); }
    public function oldest($column = 'created_at') { return $this->__missingMethod(); }
    public function inRandomOrder($seed = '') { return $this->__missingMethod(); }
    public function orderByRaw($sql, $bindings = []) { return $this->__missingMethod(); }
    public function skip($value) { return $this->__missingMethod(); }
    public function offset($value) { return $this->__missingMethod(); }
    public function take($value) { return $this->__missingMethod(); }
    public function limit($value) { return $this->__missingMethod(); }
    public function forPage($page, $perPage = 15) { return $this->__missingMethod(); }
    public function forPageAfterId($perPage = 15, $lastId = 0, $column = 'id') { return $this->__missingMethod(); }
    public function union($query, $all = false) { return $this->__missingMethod(); }
    public function unionAll($query) { return $this->__missingMethod(); }
    public function lock($value = true) { return $this->__missingMethod(); }
    public function lockForUpdate() { return $this->__missingMethod(); }
    public function sharedLock() { return $this->__missingMethod(); }
    public function value($column) { return $this->__missingMethod(); }
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null) { return $this->__missingMethod(); }
    public function simplePaginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null) { return $this->__missingMethod(); }
    public function getCountForPagination($columns = ['*']) { return $this->__missingMethod(); }
    public function cursor() { return $this->__missingMethod(); }
    public function chunkById($count, callable $callback, $column = 'id', $alias = null) { return $this->__missingMethod(); }
    public function pluck($column, $key = null) { return $this->__missingMethod(); }
    public function implode($column, $glue = '') { return $this->__missingMethod(); }
    public function exists() { return $this->__missingMethod(); }
    public function count($columns = '*') { return $this->__missingMethod(); }
    public function min($column) { return $this->__missingMethod(); }
    public function max($column) { return $this->__missingMethod(); }
    public function sum($column) { return $this->__missingMethod(); }
    public function avg($column) { return $this->__missingMethod(); }
    public function average($column) { return $this->__missingMethod(); }
    public function aggregate($function, $columns = ['*']) { return $this->__missingMethod(); }
    public function numericAggregate($function, $columns = ['*']) { return $this->__missingMethod(); }
    public function increment($column, $amount = 1, array $extra = []) { return $this->__missingMethod(); }
    public function decrement($column, $amount = 1, array $extra = []) { return $this->__missingMethod(); }
    public function truncate() { return $this->__missingMethod(); }
    public function useWritePdo() { return $this->__missingMethod(); }
    public function chunk($count, callable $callback) { return $this->__missingMethod(); }
    public function each(callable $callback, $count = 1000) { return $this->__missingMethod(); }
}