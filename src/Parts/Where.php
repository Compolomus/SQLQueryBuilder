<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\{
    Conditions,
    Helper,
    Traits\Caller
};

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
    }

    public function add($field, $condition, $value)
    {
        $this->condition()->add($field, $condition, $value);
        return $this;
    }

    public function result()
    {
        $array = [];
        $placeholders = [];
        foreach ($this->conditions as $key => $condition) {
            $placeholders += $condition->placeholders()->get();
            $array[] = '(' . Helper::concatWhere($condition->conditions(), $this->whereType[$key]) . ')';
        }
        $this->addPlaceholders($placeholders);
        return 'WHERE ' . Helper::concatWhere($array, 'and');
    }
}
