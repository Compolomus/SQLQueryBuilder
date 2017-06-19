<?php

namespace Compolomus\SQLQueryBuilder\System;

use Compolomus\SQLQueryBuilder\Builder;

class Caller
{
    private $base;

    public function base($base) {
        $this->base = $base;
    }

    public function __call($method, $args)
    {
        if (!method_exists(__CLASS__, $method)) {
            return $this->base->$method(...$args);
        }
    }
}
