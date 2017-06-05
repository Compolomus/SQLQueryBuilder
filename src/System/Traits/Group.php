<?php

namespace Koenig\SQLQueryBuilder\System\Traits;

trait Group
{
    private $group;

    public function group($field = null)
    {
        $this->group = new \Koenig\SQLQueryBuilder\Parts\Group($field);
        $this->group->base($this);
        return $this->group;
    }
}
