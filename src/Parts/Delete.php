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
        #echo '<pre>' . print_r($this, 1) . '</pre>'; exit;
        if ($id) {
            $this->where()->add('id', '=', $id);
            #return $this;
        }
    }

    public function get()
    {
        #return 'DELETE FROM ' . $this->table() . ' ' . $this->where->result();
    }
}
