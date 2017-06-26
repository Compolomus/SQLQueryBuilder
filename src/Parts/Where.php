<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\{
    Conditions,
    Traits\Helper,
    Traits\Caller
};

class Where
{
    use Caller, Helper;

    private $whereType;

    private $whereTypes = [
        'and',
        'or'
    ];

    private $counter = -1;

    private $conditions;

    public function where($type = 'and')
    {
        if (!in_array(strtolower($type), $this->whereTypes)) {
            throw new \InvalidArgumentException('DIE |WHERE construct|');
        }
        $this->counter++;
        $this->whereType[$this->counter] = $type;
        $this->conditions[$this->counter] = new Conditions;
        return $this;
    }

    public function condition()
    {
        return end($this->conditions);
    }

    public function __construct($type = 'and')
    {
        $this->where($type);
    }

    public function add($field, $cond, $value)
    {
        $this->condition()->add($field, $cond, $value);
        return $this;
    }

    public function result()
    {
        $array = [];
        $placeholders = [];
        foreach ($this->conditions as $key => $condition) {
            $placeholders += $condition->placeholders()->get();
            $array[] = '(' . $this->concatWhere($condition->conditions(), $this->whereType[$key]) . ')';
        }
        $this->addPlaceholders($placeholders);
        return 'WHERE ' . $this->concatWhere($array, 'and');
    }
}
