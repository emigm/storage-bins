<?php

namespace StorageBins;

class ArrayBin
{
    const GETTER_REGEX = '/^get(.*)$/';

    private $array;
    private $is_camelcase;

    public function __construct($array, $is_camelcase = true)
    {
        $this->array = $array;
        $this->is_camelcase = $is_camelcase;
    }

    /**
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $result = preg_match(self::GETTER_REGEX, $name, $matches);

        if (false === $result) {
            throw new \RuntimeException('Ups, something went wrong');
        } elseif (0 === $result) {
            throw new \BadMethodCallException();
        } elseif (1 === $result) {
            $attribute_nane = ($this->is_camelcase)
                ? lcfirst($matches[1])
                : $this->camelCaseToUnderscore($matches[1]);

            if (!array_key_exists($attribute_nane, $this->array)) {
                throw new \BadMethodCallException();
            }

            $attribute_value = $this->array[$attribute_nane];

            return ($this->isAssociativeArray($attribute_value))
                ? new self($attribute_value, $this->is_camelcase)
                : $attribute_value;
        }
    }

    protected function camelCaseToUnderscore($input)
    {
        return strtolower(
            preg_replace(['/([a-z])([A-Z\d])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $input)
        );
    }

    protected function underscoreToCamelCase($input, $capitalize_first_char = false)
    {
        $camelcase = str_replace(' ', '', ucwords(str_replace('_', ' ', $input)));

        if (!$capitalize_first_char) {
            $camelcase = lcfirst($camelcase);
        }

        return $camelcase;
    }

    protected function isAssociativeArray($array)
    {
        return is_array($array) and array_keys($array) !== range(0, count($array) - 1);
    }
}
