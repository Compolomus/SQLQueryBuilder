<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\{
    Traits\Helper,
    Traits\Caller
};

class Join
{
    use Caller, Helper;

    private $table;

    private $onPairs;

    private $using = null;

    private $alias = null;

    private $joinType = null;

    private $joinTypes = ['left', 'right', 'cross', 'inner']; //TODO: add types

    private $counter = 0;

    public function __construct(string $table, ?string $alias = null, array $onPairs = [], string $joinType = 'left')
    {
        $this->join($table, $alias, $onPairs, $joinType);
    }

    public function debug()
    {
        echo '<pre>' . print_r($this, true) . '</pre>';
        return $this;
    }

    public function join(string $table, ?string $alias = null, array $onPairs = [], string $joinType = 'left'): Join
    {
        $this->counter++;
        $this->table[$this->counter] = $table;
        $this->addOn($onPairs);
        $this->setAlias($alias);
        $this->setType($joinType);
        return $this;
    }

    public function setType(string $joinType): Join
    {
        if (!in_array($joinType, $this->joinTypes)) {
            throw new \InvalidArgumentException('DIE |JOIN construct|');
        }
        $this->joinType[$this->counter] = $joinType;
        return $this;
    }

    public function setAlias(?string $alias): Join
    {
        if (!is_null($alias)) {
            $this->alias[$this->counter] = $alias;
        }
        return $this;
    }

    public function getTable(int $counter): string
    {
        return (!is_null($this->alias[$counter])) ? $this->escapeField($this->alias[$counter]) : $this->escapeField($this->table[$counter]);
    }

    public function using(string $field): Join
    {
        $this->using = $this->escapeField($field);
        return $this;
    }

    public function addOn(array $onPairs): Join
    {
        if (count($onPairs)) {
            $this->onPairs[$this->counter] = $onPairs;
        }
        return $this;
    }

    private function onMap(): ?string
    {
        if (!empty($this->onPairs)) {
            $result = [];
            foreach ($this->table as $counter => $join) {
                $result[] = $this->concatWhere(array_map(function ($item) use ($join, $counter) {
                    return $this->base->table() . '.' . $this->escapeField($item[0]) . ' = ' . $this->escapeField($join) . '.' . $this->escapeField($item[1]);
                }, $this->onPairs[$counter]));
            }
            return ' ON ' . $this->concatWhere($result);
        }
        return null;
    }

    public function result(): ?string
    {
        $result = [];
        foreach ($this->table as $counter => $join) {
            $result[] = ' ' . strtoupper($this->joinType[$counter]) . ' JOIN '
                . $this->escapeField($join)
                . (!is_null($this->alias[$counter]) ? ' AS ' . $this->escapeField($this->alias[$counter]) : '');
        }
        $result[] = ($this->onMap()
            ? $this->onMap()
            : (!is_null($this->using)
                ? ' USING(' . $this->using . ')'
                : ''
            )
        );
        return implode(' ', $result);
    }
}
