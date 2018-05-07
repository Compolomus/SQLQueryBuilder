<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Limit as Plimit;

trait Limit
{
    private $limit;

    public function limit(int $limit, int $offset = 0, string $type = 'limit'): Plimit
    {
        $this->limit = new Plimit($limit, $offset, $type);
        $this->limit->setBase($this);
        return $this->limit;
    }
}
