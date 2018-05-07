<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Limit as TLimit,
    Where as TWhere,
    GetParts,
    Caller
};

/**
 * @method string table()
 */
class Delete
{
    use TLimit, TWhere, Caller, GetParts;

    public function __construct(int $did = 0, string $field = 'id')
    {
        if ($did) {
            $this->where()->add($field, '=', $did);
        }
    }

    public function get(): string
    {
        return 'DELETE FROM ' . $this->table()
            . $this->getParts();
    }
}
