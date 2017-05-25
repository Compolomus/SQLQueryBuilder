<?php

namespace Koenig\SQLQueryBuilder;

use Koenig\SQLQueryBuilder\Parts\Order;
use Koenig\SQLQueryBuilder\Parts\Where;
use Koenig\SQLQueryBuilder\System\Singleton;

class Builder
{
    use Singleton;

    private $table;

    private $where;

    private $limit;

    private $order;

    private $group;

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($type = 'and')
    {
        $this->where = new Where($type);
        return $this->where;
    }

    public function order($field = null, $type = 'asc')
    {
        $this->order = new Order($field, $type);
        return $this->order;
    }
}
