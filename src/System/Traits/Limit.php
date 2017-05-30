<?php

namespace Koenig\SQLQueryBuilder\System\Traits;

trait Limit
{
    private $limit = false;

    public function limit($limit, $offset = 0, $type = 'limit')
    {
        $this->limit = new \Koenig\SQLQueryBuilder\Parts\Limit($limit, $offset, $type);
        $this->limit->base($this);
        return $this->limit;
    }
}
