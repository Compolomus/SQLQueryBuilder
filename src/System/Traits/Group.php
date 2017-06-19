<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

use Compolomus\SQLQueryBuilder\Parts\Group as Pgroup;

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
