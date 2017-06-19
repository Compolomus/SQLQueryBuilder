<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

use Compolomus\SQLQueryBuilder\Parts\Where as Pwhere;

trait Where
{
    private $where;

    public function where($type = 'and')
    {
        $this->where = new Pwhere($type);
        $this->where->base($this);
        return $this->where;
    }
}
