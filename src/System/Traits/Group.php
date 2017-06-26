<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Group as Pgroup;

trait Group
{
    private $group;

    public function group($field = null)
    {
        $this->group = new Pgroup($field);
        $this->group->base($this);
        return $this->group;
    }
}
