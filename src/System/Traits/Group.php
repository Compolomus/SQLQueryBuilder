<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Group as Pgroup;

trait Group
{
    private $group;

    public function group(?string $field = null): PGroup
    {
        $this->group = new Pgroup($field);
        $this->group->base($this);
        return $this->group;
    }
}
