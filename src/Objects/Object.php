<?php

namespace ITCity\Rivile\Objects;

use ITCity\Rivile\Exceptions\RivileInvalidAttribute;
use ITCity\Rivile\Exceptions\RivileInvalidObject;
use ITCity\Rivile\QueryBuilder;
use ITCity\Rivile\RivileInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SimpleXMLElement;

/**
 * Eloquent-style wrapper for Rivile data.
 *
 * Extremely hackish.
 */
class Object extends Model {

	/**
	 * Rivile table prefix.
	 *
	 * @var string
	 */
	protected static $prefix;
	
	/**
	 * Primary key in Rivile table.
	 *
	 * @var string
	 */
	protected static $primary_key;

	/**
	 * Name of associated webservice get query method.
	 *
	 * @var string
	 */
	protected static $query_method;

	/**
	 * List of attributes with validation rules.
	 *
	 * @var array
	 */
	protected static $defs;

	/**
	 * List of relation definitions.
	 *
	 * @var array
	 */
	protected static $relation_map;

	/**
	 * Attribute to pass to related objects.
	 *
	 * @var string
	 */
	protected static $relation_key;

	protected $dateFormat = "Y-m-d H:i:s.u";
	protected $table = '';
	public $incrementing = false;
	public $timestamps = false;

	protected static function boot() {
        parent::bootTraits();

        foreach (static::$defs as $field => &$rules) {
			$rules[] = 'nullable';
		}

		static::retrieved(function($object) {
			$attributes = $object->getAttributes();
			foreach ((array) $object::$relation_map as $key => $def) {
				if (isset($attributes[$key])) {
					$rel_object = (new $def['class'])->setConnection($object->getConnectionName());
					if (isset($attributes[$key][0])) {
						$relation = $rel_object->fromList($attributes[$key]);
					} else {
						$relation = collect([$rel_object->instantiate($attributes[$key])]);
					}
					$object->setRelation($def['name'], $relation);
					unset($object->$key);
				} else {
					$object->setRelation($def['name'], collect());
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

	/**
	 * Construct a prefixed version of an attribute name.
	 *
	 * @param string $name
	 * @return string
	 */
	protected static function prefixedName ($name) {
		$name = static::$prefix ? static::$prefix.'_'.$name : $name;
		return strtolower($name);
	}

	/**
	 * Cast attribute value to appropriate data type, based on definition.
	 *
	 * @param mixed $value
	 * @param array $def
	 * @return mixed
	 */
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

	/**
	 * Process potential attribute name
	 *
	 * Returns full prefixed attribute name if a match is found,
	 * otherwise returns original input.
	 *
	 * @param string $name
	 * @return string
	 */
	public static function attrName ($name) {
		$lower_name = strtolower($name);

		if (isset(static::$defs[$lower_name])) {
			return $lower_name;
		} else if (($pref_name = static::prefixedName($name)) && isset(static::$defs[$pref_name])) {
			return $pref_name;
		}

		return $name;
	}

	/**
	 * Get the associated get query webservice method.
	 *
	 * @return string
	 */
	public static function getQueryMethod () {
		return isset(static::$query_method) ? static::$query_method : "GET_".static::$prefix."_LIST";
	}

	/**
	 * Get the associated edit query webservice method.
	 *
	 * @return string
	 */
	public static function getEditMethod () {
		return isset(static::$edit_method) ? static::$edit_method : 'EDIT_'.static::$prefix;
	}

	/**
	 * Get primary key attribute name.
	 *
	 * @return string
	 */
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

	/**
	 * Terrible hack: we store Rivile key as the model's connection name
	 * and get the appropriate RivileInterface with getConnection().
	 *
	 * @return ITCity\Rivile\RivileInterface
	 */
	public function getConnection() {
		return new RivileInterface($this->getConnectionName());
	}

	/**
	 * Create new instance with data loaded from Rivile.
	 *
	 * @param array $raw_data
	 * @return \ITCity\Rivile\Objects\Object
	 */
	public function instantiate ($raw_data) {
		return $this->newInstance()->newFromBuilder(array_change_key_case($raw_data));
	}

	/**
	 * Hydrate object with data from Rivile.
	 *
	 * @param array $attributes
	 * @return $this
	 */
	public function fillFromBuilder($attributes = []) {
        $this->setRawAttributes(array_change_key_case((array) $attributes), true);

        $this->fireModelEvent('retrieved', false);

        $this->exists = true;

        return $this;
    }

    public function refresh() {
    	$query = $this->newQueryWithoutScopes();
    	$query->raw_output = true;
    	$res = $query->where($this->getPrimaryKey(), $this->getKey())->get();
    	$this->fillFromBuilder($res);
    	return $this;
    }

	/**
	 * Instantiate multiple objects from Rivile data in one go.
	 *
	 * @param array $list
	 * @return \Illuminate\Support\Collection
	 */
	public function fromList ($list) {
		$out = collect();
		foreach ($list as $item) {
			if (!$item) continue;
			$out->push($this->instantiate($item));
		}
		return $out;
	}

	public function save(array $options = []) {
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

        $this->fillFromBuilder($saved);

        return $this;
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

	/**
	 * Represent current object state as an XML string.
	 *
	 * @return string
	 */
	public function toXml () {
		$simple_xml = array_to_xml($this->attributesToArray(), new SimpleXMLElement('<'.static::$prefix.' />'));
		$dom = dom_import_simplexml($simple_xml);
		return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
	}

	/**
	 * Get a map of relation names to classes.
	 *
	 * @return \Illuminate\Support\Collection
	 */
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

    public function __call ($method, $parameters) {
    	if ($class = array_get($this->getRelationNames(), $method)) {
    		$new_rel = (new $class)->setConnection($this->getConnectionName());
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

    public function getKeyName () {
    	return $this->getPrimaryKey();
    }

    public function getDates() {
        return collect(static::$defs)->filter(function($item) {
        	return array_get($item, 0) == 'date';
        })->keys()->all();
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

    /**
     * Get a Rivile facade.
     *
     * @return \ITCity\Rivile\Rivile
     */
    public function rivile() {
    	return new Rivile($this->getConnectionName());
    }
}