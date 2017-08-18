<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\{
    Traits\GetParts,
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
    use TLimit, TWhere, TOrder, TGroup, Caller, GetParts;

    protected $fields;

    protected $join = null;

    public function __construct(array $fields = [], bool $count = false)
    {
        $this->fields = new Fields($fields, $count);
    }

    public function getFields(): string
    {
        return $this->fields->result();
    }

    public function join(string $table, ?array $on = null, ?string $alias = null, string $joinType = 'left'): Select
    {
        $this->join = new Join($table, $on, $alias, $joinType);
        $this->join->setParentTable($this->table());
        return $this;
    }

    public function get(): string
    {
        return 'SELECT ' . $this->getFields() . ' FROM '
            . $this->table()
            . (!is_null($this->join) ? $this->join->get() : '')
            . $this->getParts();
    }
}
