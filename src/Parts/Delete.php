<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\Caller;
use Compolomus\SQLQueryBuilder\System\Traits\{
    Limit as TLimit,
    Where as TWhere
};

/**
 * @method string table()
 */
class Delete extends Caller
{
    use TLimit, TWhere;

    public function __construct($id = 0)
    {
        if ($id) {
            $this->where()->add('id', '=', $id);
        }
    }

    public function get()
    {
        return 'DELETE FROM ' . $this->table()
            . (is_object($this->where) ? ' ' . $this->where->result() : '');
    }
}
