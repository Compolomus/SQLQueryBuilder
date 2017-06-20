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

    protected $fields;

    public function __construct(array $fields = [], $count = false)
    {
        $this->fields = new Fields($fields, $count);
    }

    public function getFields()
    {
        return $this->fields->result();
    }

    public function get()
    {
        return 'SELECT ' . $this->getFields() . ' FROM ' . $this->table()
            . (is_object($this->where) ? ' ' . $this->where->result() : '')
            . (is_object($this->group) ? ' ' . $this->group->result() : '')
            . (is_object($this->order) ? ' ' . $this->order->result() : '')
            . (is_object($this->limit) ? ' ' . $this->limit->result() : '');
    }
}
