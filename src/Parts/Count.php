<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

class Count extends Select
{
    public function __construct($field = '*', $alias = null)
    {
        parent::__construct([$field => $alias], true);
    }
}
