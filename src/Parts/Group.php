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

    public function __construct(array $fields)
    {
        array_map([$this, 'add'], $fields);
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
            $group = 'GROUP BY ' . $this->concat($this->groups);
        }
        return $group;
    }
}
