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

    public function __construct($did = 0, $field = 'id')
    {
        if ($did) {
            $this->where()->add($field, '=', $did);
        }
    }

    public function get()
    {
        return 'DELETE FROM ' . $this->table()
            . $this->getParts();
    }
}
