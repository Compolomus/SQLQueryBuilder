<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller
};

class Group
{
    use Caller, Helper;

    private $groups = [];

    public function __construct($field = null)
    {
        if (!is_null($field)) {
            $this->add($field);
        }
    }

    public function add($field)
    {
        $this->groups[] = $this->escapeField($field);
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
