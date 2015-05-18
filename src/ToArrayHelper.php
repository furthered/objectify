<?php namespace Objectify;

use Illuminate\Contracts\Support\Arrayable;

trait ToArrayHelper {

    public function toArray()
    {
        return array_map(function($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, parent::toArray());
    }

}
