<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\{
    Caller,
    Traits\Limit as TLimit,
    Traits\Where as TWhere,
    Traits\Order as TOrder,
    Traits\Group as TGroup,
    Fields
};

/**
 * @method string table()
 */
class Select extends Caller
{
    use TLimit, TWhere, TOrder, TGroup;

    private $fields;

    public function __construct(array $fields = [])
    {
        $this->fields = new Fields($fields);
    }

    public function count($field = '*', $alias = null)
    {
        $this->fields->count($field, $alias);
        return $this;
    }

    public function get()
    {
        return 'SELECT ' . $this->fields->result() . ' FROM ' . $this->table()
            . (is_object($this->where) ? ' ' . $this->where->result() : '')
            . (is_object($this->group) ? ' ' . $this->group->result() : '')
            . (is_object($this->order) ? ' ' . $this->order->result() : '')
            . (is_object($this->limit) ? ' ' . $this->limit->result() : '');
    }
}
