<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller
};

class Group
{
    use Caller, Helper;

    private $groups = [];

    public function __construct(?string $field = null)
    {
        if (!is_null($field)) {
            $this->add($field);
        }
    }

    public function add(string $field): Group
    {
        $this->groups[] = $this->escapeField($field);
        return $this;
    }

    public function result(): string
    {
        $group = '';
        if (count($this->groups)) {
            $group = 'GROUP BY ' . implode(',', $this->groups);
        }
        return $group;
    }
}
