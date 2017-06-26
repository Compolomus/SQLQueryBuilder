<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Where as Pwhere;

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
