<?php

namespace Objectify;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class Objectify {

    public function make($var)
    {
        if ($var === null) {
            return $var;
        }

        return $this->convert($var);
    }

    public function convert($var)
    {
        if (is_object($var) ||  (is_array($var) && $this->isAssociative($var))) {
            return $this->convertToFluent($var);
        }

        if (is_array($var)) {
            return $this->convertToCollection($var);
        }

        return $var;
    }

    public function convertToFluent($var)
    {
        $var = new ObjectifyFluent($var);

        foreach ($var->getAttributes() as $key => $value) {
            $var->{$key} = $this->convert($value);
        }

        return $var;
    }

    public function convertToCollection($var)
    {
        $var = ObjectifyCollection::make($var);

        foreach ($var as $key => $value) {
            $var[$key] = $this->convert($value);
        }

        return $var;
    }

    public function isAssociative(array $var)
    {
        $keys      = array_keys($var);
        $first_key = reset($keys);

        // Empty array, treat it as non-associative
        if ($first_key === false) {
            return false;
        }

        return !($first_key === 0);
    }

}
