<?php

namespace ITCity\Rivile\Objects;

use ITCity\Rivile\Exceptions\RivileInvalidAttribute;
use ITCity\Rivile\Exceptions\RivileInvalidObject;
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
		$name = strtoupper($name);
		return static::$prefix ? static::$prefix.'_'.$name : $name;
	}

	protected static function castValue ($value, $def) {
		if (!isset($def[0])) return $value;
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
		if (array_key_exists($name, static::$defs)) {
			return $name;
		} else if (($upper_name = strtoupper($name)) && array_key_exists($upper_name, static::$defs)) {
			return $upper_name;
		} else if (($pref_name = static::prefixedName($name)) && array_key_exists($pref_name, static::$defs)) {
			return $pref_name;
		} else {
			throw new RivileInvalidAttribute;
		}
	}

	public function __get ($name) {
		$attr_name = $this->attrName($name);
		$value = $this->data[$attr_name];
		$def = static::$defs[$attr_name];
		return $this->castValue($value, $def);
	}

	public function __set ($name, $value) {
		$attr_name = $this->attrName($name);

		$this->data[$attr_name] = $value;
	}

	public static function fromList ($list) {
		$out = collect();
		foreach ($list as $item) {
			$out->push(new static($item));
		}
		return $out;
	}
}