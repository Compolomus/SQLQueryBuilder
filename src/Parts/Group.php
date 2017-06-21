<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\Helper;
use Compolomus\SQLQueryBuilder\System\Traits\Caller;

class Group
{
    use Caller;

    private $groups = [];

    public function __construct($field = null)
    {
        if (!is_null($field)) {
            $this->add($field);
        }
    }

    public function add($field)
    {
        $this->groups[] = Helper::escapeField($field);
        return $this;
    }

    public function result()
    {
        $group = '';
        if (count($this->groups)) {
            $group = 'GROUP BY ' . implode(',', $this->groups);
        }
        return $group;
    }
}
