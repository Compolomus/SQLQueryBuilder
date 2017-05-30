<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\{
    Traits\Caller,
    Traits\Limit,
    Traits\Where,
    Traits\Order,
    Traits\Group,
    Fields
};

class Select
{
    use Caller, Limit, Where, Order, Group;

    private $fields;

    public function __construct(array $fields = [])
    {
        $this->fields = new Fields($fields);
    }

    public function get()
    {
        return 'SELECT ' . $this->fields->result() . ' FROM ' . $this->table()
            . (is_object($this->where) ? ' ' . $this->where->result() : '')
            . (is_object($this->group) ?  ' ' . $this->group->result() : '')
            . (is_object($this->order) ?  ' ' . $this->order->result() : '')
            . (is_object($this->limit) ?  ' ' . $this->limit->result() : '');
    }
}
