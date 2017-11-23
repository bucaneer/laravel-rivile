<?php

namespace ITCity\Rivile\Objects;

use ITCity\Rivile\Exceptions\RivileInvalidAttribute;
use ITCity\Rivile\Exceptions\RivileInvalidObject;
use ITCity\Rivile\QueryBuilder;
use Carbon\Carbon;

class Object {
	protected static $prefix;
	protected static $primary_key;
	protected static $query_method;
	protected static $defs;

	public $data;

	public function __construct ($data = array()) {
		if (static::$defs) {
			foreach (static::$defs as $field => &$rules) {
				$rules[] = 'nullable';
			}
			if ($data) {
				$data = array_change_key_case($data);
				$validator = \Validator::make($data, static::$defs);
				if ($validator->fails()) {
					$failed = [];
					foreach ($validator->failed() as $field => $rules) {
						$failed[] = "<{$field}>: <".print_r(array_get($data, $field), true)."> fails [".join(', ', array_keys($rules))."]";
					}
					throw new RivileInvalidObject(join('; ', $failed));
				}
			}
		}
		$this->data = $data;
	}

	protected static function prefixedName ($name) {
		$name = static::$prefix ? static::$prefix.'_'.$name : $name;
		return strtolower($name);
	}

	protected static function castValue ($value, $def) {
		if (!isset($def[0])) return $value;
		if ($value === null) return $value;
		$type = $def[0];
		switch ($type) {
			case 'integer':
				return (int) $value;
			break;
			case 'numeric':
				return (float) $value;
			break;
			case 'boolean':
				return (bool) $value;
			break;
			case 'date':
				return new Carbon($value);
			break;
			case 'string':
			default:
				return trim($value);
			break;
		}
	}

	public static function attrName ($name) {
		$lower_name = strtolower($name);

		if (isset(static::$defs[$lower_name])) {
			return $lower_name;
		} else if (($pref_name = static::prefixedName($name)) && isset(static::$defs[$pref_name])) {
			return $pref_name;
		}

		return $name;
	}

	public static function getQueryMethod () {
		return isset(static::$query_method) ? static::$query_method : "GET_".static::$prefix."_LIST";
	}

	public static function getPrimaryKey () {
		if (isset(static::$primary_key)) {
			return static::$primary_key;
		} else {
			reset(static::$defs);
			return key(static::$defs);
		}
	}

	public static function query () {
		return new QueryBuilder(static::class);
	}

	public static function where (...$params) {
		return (new QueryBuilder(static::class))->where(...$params);
	}

	public static function find ($value) {
		return (new QueryBuilder(static::class))->find($value);
	}

	public function __get ($name) {
		if ($name == 'id') {
			$attr_name = $this->getPrimaryKey();
		} else {
			$attr_name = $this->attrName($name);
		}
		$value = $this->data[$attr_name];
		$def = static::$defs[$attr_name];
		return $this->castValue($value, $def);
	}

	public function __set ($name, $value) {
		$attr_name = $this->attrName($name);

		$this->data[$attr_name] = $value;
	}

	public function __isset ($name) {
		return $this->__get($name) !== null;
	}

	public function __unset ($name) {
		return $this->__set($name, null);
	}

	public static function fromList ($list) {
		$out = collect();
		foreach ($list as $item) {
			$out->push(new static($item));
		}
		return $out;
	}
}