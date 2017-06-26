<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Limit as Plimit;

trait Limit
{
    private $limit;

    public function limit($limit, $offset = 0, $type = 'limit')
    {
        $this->limit = new Plimit($limit, $offset, $type);
        $this->limit->base($this);
        return $this->limit;
    }
}
