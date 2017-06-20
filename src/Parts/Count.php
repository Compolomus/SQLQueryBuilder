<?php

namespace Compolomus\SQLQueryBuilder\Parts;

class Count extends Select
{
    public function __construct($field = '*', $alias = null)
    {
        parent::__construct([$field => $alias], 1);
    }
}
