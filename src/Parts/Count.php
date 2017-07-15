<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

class Count extends Select
{
    public function __construct(string $field = '*', ?string $alias = null)
    {
        parent::__construct([$field => $alias], true);
    }
}
