<?php
namespace Application\Model;

use ReflectionObject;
use ReflectionProperty;

/*
 * Behaviour class.
 * Convenience methods for moving well formed data between model types.
 */
abstract class AbstractSelfMappingModel
{

    /**
     *
     * Populate self from a related model object. Null tolerant.
     * 1. get protected properties declared within this class
     * 2. look up corresponding values in the model
     *
     * @param $model
     *
     * @return static
     */

    public static function fromModel($model)
    {
        $self = new static;

        foreach ($self::reflect()->getProperties(ReflectionProperty::IS_PROTECTED) as $prop) {
            $propName = $prop->getName();

            if ($prop->getDeclaringClass()->name == get_class($self)) {
                $self->$propName = $model->$propName;
            }
        }

        return $self;
    }

    /**
     *
     * Populate self from an array. Null tolerant.
     * 1. get protected properties declared within this class
     * 2. look up corresponding values in the array
     *
     * @param $array
     *
     */

    public function exchangeArray($array)
    {
        foreach ($this->reflect()->getProperties(ReflectionProperty::IS_PROTECTED) as $prop) {
            $propName = $prop->getName();

            if ($prop->getDeclaringClass()->name == get_class($this)) {
                $this->$propName = $array[self::fromCamelCase($propName)];
            }
        }
    }


    /**
     * Copy to an array protected properties declared within this class.
     * @return array
     */

    public function toArray()
    {
        $array = [];

        foreach ($this->reflect()->getProperties(ReflectionProperty::IS_PROTECTED) as $prop) {
            $propName = $prop->getName();

            if ($prop->getDeclaringClass()->name == get_class($this)) {
                $array[self::fromCamelCase($propName)] = $this->$propName;
            }
        }
        return $array;
    }

    /**
     * Provide a reflection of self.
     * @return ReflectionObject
     */
    protected function reflect()
    {
        $self = (isset($this) && get_class($this) == __CLASS__)? $this : new static;
        return new ReflectionObject($self);
    }

    /**
     * Camelcase strings.
     *
     * @param $string
     * @param string $separator
     * @param bool $capitalizeFirstCharacter
     *
     * @return mixed|string
     */
    public function toCamelCase($string, $separator = "_", $capitalizeFirstCharacter = false) {
        $str = str_replace($separator, '', ucwords($string, $separator));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }
        return $str;
    }

    /**
     * Uncamelcase strings.
     *
     * @param $string
     * @param string $separator
     *
     * @return string
     */
    public function fromCamelCase($string, $separator = "_") {
        $str = strtolower(preg_replace('/(?<!^)[A-Z]/', $separator.'$0', $string));
        return $str;
    }

}