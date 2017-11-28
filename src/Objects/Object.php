<?php

namespace ITCity\Rivile\Objects;

use ITCity\Rivile\Exceptions\RivileInvalidAttribute;
use ITCity\Rivile\Exceptions\RivileInvalidObject;
use ITCity\Rivile\QueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SimpleXMLElement;

class Object extends Model{

	protected static $prefix;
	protected static $primary_key;
	protected static $query_method;
	protected static $defs;
	protected static $relation_map;
	protected static $relation_key;

	protected $dateFormat = "Y-m-d H:i:s.u";
	protected $table = '';

	protected static function boot() {
        parent::bootTraits();

        foreach (static::$defs as $field => &$rules) {
			$rules[] = 'nullable';
		}

		static::retrieved(function($object) {
			$attributes = $object->getAttributes();
			foreach ((array) $object::$relation_map as $key => $def) {
				if (isset($attributes[$key])) {
					if (isset($attributes[$key][0])) {
						$relation = $def['class']::fromList($attributes[$key]);
					} else {
						$relation = collect([$def['class']::instantiate($attributes[$key])]);
					}
					$object->setRelation($def['name'], $relation);
					unset($object->$key);
				}
			}
		});
    }

    public function getFillable() {
    	return array_keys(static::$defs);
    }

	public function fill (array $data) {
		if (!$data) return;
		$data = array_change_key_case($data);
		$validator = \Validator::make($data, static::$defs);
		if ($validator->fails()) {
			$failed = [];
			foreach ($validator->failed() as $field => $rules) {
				$failed[] = "<{$field}>: <".print_r(array_get($data, $field), true)."> fails [".join(', ', array_keys($rules))."]";
			}
			throw new RivileInvalidObject(join('; ', $failed));
		}
		
		return parent::fill($data);
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

	protected function castAttribute ($key, $value) {
		$def = static::$defs[$key];
		return static::castValue($value, $def);
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

	public static function getEditMethod () {
		return isset(static::$edit_method) ? static::$edit_method : 'EDIT_'.static::$prefix;
	}

	public static function getPrimaryKey () {
		if (isset(static::$primary_key)) {
			return static::$primary_key;
		} else {
			reset(static::$defs);
			return key(static::$defs);
		}
	}

	public function newQueryWithoutScopes () {
		return new QueryBuilder($this);
	}

	public static function instantiate ($raw_data) {
		return (new static)->newFromBuilder(array_change_key_case($raw_data));
	}

	public static function fromList ($list) {
		$out = collect();
		foreach ($list as $item) {
			if (!$item) continue;
			$out->push(static::instantiate($item));
		}
		return $out;
	}

	public function save(array $options = [])
    {
        $query = $this->newQueryWithoutScopes();

        // If the "saving" event returns false we'll bail out of the save and return
        // false, indicating that the save failed. This provides a chance for any
        // listeners to cancel save operations if validations fail or whatever.
        if ($this->fireModelEvent('saving') === false) {
            return false;
        }

        // If the model already exists in the database we can just update our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        if ($this->exists) {
            $saved = $this->isDirty() ?
                        $query->update() : true;
        }

        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else {
            $saved = $query->insert();
        }

        // If the model is successfully saved, we need to do a few more things once
        // that is done. We will call the "saved" method here to run any actions
        // we need to happen after a model gets successfully saved right here.
        if ($saved) {
            $this->finishSave($options);
        }

        return $saved;
    }

    public function delete()
    {
        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }

        if ($this->fireModelEvent('deleting') === false) {
            return false;
        }

        // Here, we'll touch the owning models, verifying these timestamps get updated
        // for the models. This will allow any caching to get broken on the parents
        // by the timestamp. Then we will go ahead and delete the model instance.
        $this->touchOwners();

        $this->performDeleteOnModel();

        // Once the model has been deleted, we will fire off the deleted event so that
        // the developers may hook into post-delete operations. We will then return
        // a boolean true as the delete is presumably successful on the database.
        $this->fireModelEvent('deleted', false);

        return true;
    }

    protected function performDeleteOnModel()
    {
        $this->newQueryWithoutScopes()->delete();

        $this->exists = false;
    }

	public function toXml () {
		$simple_xml = array_to_xml($this->attributesToArray(), new SimpleXMLElement('<'.static::$prefix.' />'));
		$dom = dom_import_simplexml($simple_xml);
		return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
	}

	public function getRelationNames() {
		return collect((array) static::$relation_map)->mapWithKeys(function($item) {
			return [$item['name'] => $item['class']];
		});
	}

	public function __get($key) {
		if (array_get($this->getRelationNames(), $key)) {
			return $this->getRelation($key);
		}
        return $this->getAttribute($key);
    }

    public function __set($key, $value) {
        $this->setAttribute($key, $value);
    }

    public function __call ($method, $parameters) {
    	if ($class = array_get($this->getRelationNames(), $method)) {
    		$new_rel = new $class;
    		if (isset(static::$relation_key)) {
    			$new_rel->{static::$relation_key} = $this->{static::$relation_key};
    		}
    		return $new_rel;
    	}
    	return parent::__call($method, $parameters);
    }

    public function getAttribute ($key) {
	    return parent::getAttribute(static::attrName($key));
    }

    public function setAttribute ($key, $value) {
    	return parent::setAttribute(static::attrName($key), $value);
    }

    public function relationLoaded($key) {
    	return false;
    }

    public function getIncrementing() {
    	return false;
    }

    public function getKeyName () {
    	return $this->getPrimaryKey();
    }

    public function getDates() {
        return collect(static::$defs)->filter(function($item) {
        	return array_get($item, 0) == 'date';
        })->keys()->all();
    }

    public function usesTimestamps() {
    	return false;
    }

    public function hasCast($key, $types = null) {
        if (!$types) {
        	return isset(static::$defs[static::attrName($key)]);
        } else if (isset(static::$defs[static::attrName($key)])) {
        	$type_map = [
	    		'int' => 'integer',
	            'integer' => 'integer',
	            'real' => 'numeric',
	            'float' => 'numeric',
	            'double' => 'numeric',
	            'string' => 'string',
	            'bool' => 'boolean',
	            'boolean' => 'boolean',
	            'object' => null,
	            'array' => null,
	            'json' => null,
	            'collection' => null,
	            'date' => 'date',
	            'datetime' => 'date',
	            'timestamp' => 'date',
	        ];
	        foreach ((array) $types as &$type) {
	        	$type = array_get($type_map, $type);
	        }
	        $cast = static::$defs[static::attrName($key)][0];
	        return in_array($cast, $types);
        } else {
        	return parent::hasCast($key, $types);
        }
    	
    }
}