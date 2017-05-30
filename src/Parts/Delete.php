<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\Traits\{
    Caller,
    Limit,
    Where
};

class Delete
{
    use Caller, Limit, Where;

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
