<?php

namespace Koenig\SQLQueryBuilder\System;

use Koenig\SQLQueryBuilder\Builder;

trait Caller
{
    private $base = false;

    public function base(Builder $base) {
        $this->base = $base;
    }

    public function __call($method, $args)
    {
        if (!method_exists(__CLASS__, $method)) {
            return $this->base->$method(...$args);
        }
    }
}
