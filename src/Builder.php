<?php

namespace Koenig\SQLQueryBuilder;

use Koenig\SQLQueryBuilder\Parts\{
    Order, Select, Where, Limit, Group
};
use Koenig\SQLQueryBuilder\System\{
    Helper, PDOInstanceInterface, PDOInstance
};

class Builder implements PDOInstanceInterface
{
    use PDOInstance;

    private $table;

    private $select;

    private $where;

    private $limit;

    private $order;

    private $group;

    public function __construct($table = false)
    {
        if ($table) {
            $this->setTable($table);
        }
        $this->getPDO();
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function table() {
        return $this->table ? Helper::escapeField($this->table) : null;
    }

    public function select(array $fields = []) {
        $this->select = new Select($fields);
        $this->select->base($this);
        return $this->select;
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
