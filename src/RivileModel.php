<?php

namespace ITCity\Rivile;

use Illuminate\Database\Eloquent\Model;
use ITCity\Rivile\Objects\Object;
use ITCity\Rivile\Exceptions\RivileNoMapping;

class RivileModel extends Model
{
    protected $rivile_map = [];

    protected function mapFromRivile (Object $object, $only = null) {
        $class = get_class($object);
        if (!isset($this->rivile_map[$class])) throw new RivileNoMapping;

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

    protected function mapAttributeFromRivile (Object $object, $mapping) {
        if (is_string($mapping)) {
            return $object->{$mapping};
        } else if (is_callable($mapping)) {
            return $mapping($object);
        } else if (is_array($mapping)) {
            if (isset($mapping['first'])) {
                foreach ($mapping['first'] as $alt) {
                    if (isset($object->{$alt})) return $object->{$alt};
                }
                return null;
            }
        }
    }

    public static function fromRivile(Object $object) {
    	$model = new static;
    	$model->mapFromRivile($object);

    	return $model;
    }
}