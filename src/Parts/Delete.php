<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\Traits\{
    Caller,
    Limit as TLimit,
    Where as TWhere
};

class Delete
{
    use Caller, TLimit, TWhere;

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
