<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\BuilderException;
use Compolomus\LSQLQueryBuilder\System\{
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

    private $counter = 0;

    private $conditions;

    public function where(array $where = [], string $type = 'and'): Where
    {
        if (!\in_array(strtolower($type), $this->whereTypes, true)) {
            throw new BuilderException('Передан неверный тип ' . $type . '  |WHERE construct|');
        }
        $this->whereType[$this->counter] = $type;
        $this->conditions[$this->counter] = new Conditions;
        if (\count($where)) {
            foreach ($where as [$field, $cond, $value]) {
                $this->add($field, $cond, $value);
            }
        }
        $this->counter++;
        return $this;
    }

    public function condition(): Conditions
    {
        return end($this->conditions);
    }

    public function __construct(array $where = [], string $type = 'and')
    {
        $this->where($where, $type);
    }

    /**
     * @param string $field
     * @param string $cond
     * @param mixed $value
     * @return $this
     */
    public function add(string $field, string $cond, $value): Where
    {
        $this->condition()->add($field, $cond, $value);
        return $this;
    }

    public function result(): string
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
