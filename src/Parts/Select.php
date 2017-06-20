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

    public function getParts()
    {
        $result = '';
        foreach (['where', 'group', 'order', 'limit'] as $value) {
            $result .= (is_object($this->$value) ? ' ' . $this->$value->result() : '');
        }
        return $result;
    }

    public function get()
    {
        return 'SELECT ' . $this->getFields() . ' FROM '
            . $this->table()
            . $this->getParts();
    }
}
