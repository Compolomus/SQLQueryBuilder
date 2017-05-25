<?php

namespace Koenig\SQLQueryBuilder\System;

use Koenig\SQLQueryBuilder\Builder;

trait Caller
{
    public function __call($method, $args)
    {
        if (!method_exists(__CLASS__, $method)) {
            return Builder::getInstance()->$method(...$args);
        }
    }
}
