<?php

namespace Koenig\SQLQueryBuilder\System\Traits;

trait Where
{
    private $where;

    public function where($type = 'and')
    {
        $this->where = new \Koenig\SQLQueryBuilder\Parts\Where($type);
        $this->where->base($this);
        return $this->where;
    }
}
