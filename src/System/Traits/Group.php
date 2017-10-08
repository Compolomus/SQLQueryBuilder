<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Group as Pgroup;

trait Group
{
    private $group;

    public function group(array $fields): PGroup
    {
        $this->group = new Pgroup($fields);
        $this->group->base($this);
        return $this->group;
    }
}
