<?php

namespace ITCity\Rivile;

use Illuminate\Database\Eloquent\Model;
use ITCity\Rivile\Objects\RivileObject;
use ITCity\Rivile\Exceptions\RivileNoMapping;

class RivileModel extends Model
{
    /**
     * Array of attribute mappings. Format:
     * [
     *    'ITCity\Rivile\Objects\ObjectClassName' => [
     *       'model_attribute_name' => $rivile_object_mapping,
     *    ]
     * ]
     *
     * @var array
     */
    protected $rivile_map = [];

    /**
     * Maps model attributes from Rivile Object attributes.
     *
     * @param \ITCity\Rivile\Objects\RivileObject $object
     * @param null|array $only Limit attributes to map.
     */
    protected function mapFromRivile (RivileObject $object, $only = null) {
        $class = get_class($object);
        if (!isset($this->rivile_map[$class])) throw new RivileNoMapping(get_class($object));

        $class_map = $this->rivile_map[$class];
        if (is_array($only)) {
            $map = array_intersect_key($class_map, array_flip($only));
        } else {
            $map = $class_map;
        }
        foreach ($map as $attribute => $mapping) {
            $this->{$attribute} = $this->mapAttributeFromRivile($object, $mapping);
        }
    }

    /**
     * Maps a single attribute value from Rivile object.
     *
     * @param \ITCity\Rivile\Objects\RivileObject $object
     * @param mixed $mapping
     */
    protected function mapAttributeFromRivile (RivileObject $object, $mapping) {
        // Simple value copy
        if (is_string($mapping)) {
            return $object->{$mapping};
        }

        // Set attribute to return value of callable
        else if (is_callable($mapping)) {
            return call_user_func($mapping, $object);
        }

        // Fancy mapping via mapCustomType{$type} method
        else if (is_array($mapping)) {
            foreach ($mapping as $type => $params) {
                $custom_method = camel_case('mapCustomType'.$type);
                if (method_exists($this, $custom_method)) {
                    $value = $this->{$custom_method}($object, $params);
                    if (isset($value)) return $value;
                }
            }
        }

        return null;
    }

    /**
     * Picks first set attribute from a list of alternatives.
     *
     * @param \ITCity\Rivile\Objects\RivileObject $object
     * @param array $params
     */
    protected function mapCustomTypeFirst (RivileObject $object, $params) {
        foreach ($params as $alt) {
            if (isset($object->{$alt})) return $object->{$alt};
        }
    }

    /**
     * Creates new model instance with mapped attributes.
     *
     * @param \ITCity\Rivile\Objects\RivileObject $object
     */
    public static function fromRivile(RivileObject $object) {
    	$model = new static;
    	$model->mapFromRivile($object);

    	return $model;
    }

    /**
     * Update mappable attributes in existing model instance.
     *
     * @param \ITCity\Rivile\Objects\RivileObject $object
     */
    public function updateFromRivile(RivileObject $object) {
        $this->mapFromRivile($object);

        return $this;
    }
}