<?php

namespace Koenig\SQLQueryBuilder;

use Koenig\SQLQueryBuilder\Parts\{
    Order,
    Where,
    Limit,
    Group
};
use Koenig\SQLQueryBuilder\System\{
    PDOInstanceInterface,
    PDOInstance
};

class Builder implements PDOInstanceInterface
{
    use PDOInstance;

    private $table;

    private $where;

    private $limit;

    private $order;

    private $group;

    public function __construct($table = false) {
        if ($table) {
            $this->table($table);
        }
        $this->getPDO();
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($type = 'and')
    {
        $this->where = new Where($type);
        $this->where->base($this);
        return $this->where;
    }

    public function order($field = null, $type = 'asc')
    {
        $this->order = new Order($field, $type);
        $this->order->base($this);
        return $this->order;
    }
}
