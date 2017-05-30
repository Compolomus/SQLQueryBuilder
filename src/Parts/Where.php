<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\{
    Conditions,
    Helper
};
use Koenig\SQLQueryBuilder\System\Traits\Caller;

class Where
{
    use Caller;

    private $whereType;

    private $whereTypes = [
        'and',
        'or'
    ];

    private $counter = -1;

    private $conditions;

    public function where($type = 'and')
    {
        $this->counter++;
        if (in_array(strtolower($type), $this->whereTypes)) {
            $this->whereType[$this->counter] = $type;
        } else {
            throw new InvalidArgumentException('DIE |WHERE construct|');
        }
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
        return $this;
    }

    public function add($field, $condition, $value)
    {
        $this->condition()->add($field, $condition, $value);
        return $this;
    }

    public function result()
    {
        $array = [];
        foreach ($this->conditions as $key => $condition) {
            $array[] = '(' . Helper::concatWhere($condition->conditions(), $this->whereType[$key]) . ')';
        }
        return 'WHERE ' . Helper::concatWhere($array, 'and');
    }
}
