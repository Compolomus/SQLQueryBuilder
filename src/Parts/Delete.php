<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\Traits\{
    Limit as TLimit,
    Where as TWhere,
    Caller
};

/**
 * @method string table()
 */
class Delete
{
    use TLimit, TWhere, Caller;

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
