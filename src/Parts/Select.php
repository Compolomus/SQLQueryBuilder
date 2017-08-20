<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\{
    Traits\GetParts,
    Traits\Join as TJoin,
    Traits\Limit as TLimit,
    Traits\Where as TWhere,
    Traits\Order as TOrder,
    Traits\Group as TGroup,
    Traits\Caller,
    Fields
};

/**
 * @method string table()
 */
class Select
{
    use TJoin, TLimit, TWhere, TOrder, TGroup, Caller, GetParts;

    protected $fields;

    public function __construct(array $fields = [], bool $count = false)
    {
        $this->fields = new Fields($fields, $count);
    }

    public function getFields(): string
    {
        return $this->fields->result();
    }

    public function get(): string
    {
        return 'SELECT ' . $this->getFields() . ' FROM '
            . $this->table()
            . (!is_null($this->join) ? $this->join->result() : '')
            . $this->getParts();
    }
}
