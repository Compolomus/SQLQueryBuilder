<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Join as Pjoin;

trait Join
{
    private $join;

    public function join(string $table, ?string $alias = null, array $onPairs = [], string $joinType = 'left'): Pjoin
    {
        $this->join = new Pjoin($table, $alias, $onPairs, $joinType);
        $this->join->setBase($this);
        return $this->join;
    }
}
