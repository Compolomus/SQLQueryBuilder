<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Where as Pwhere;

trait Where
{
    private $where;

    public function where(array $where = [], string $type = 'and'): Pwhere
    {
        $this->where = new Pwhere($where, $type);
        $this->where->base($this);
        return $this->where;
    }
}
