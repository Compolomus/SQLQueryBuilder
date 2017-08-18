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

    private $parentTable;

    private $on;

    private $using = null;

    private $alias;

    private $joinType;

    private $joinTypes = ['left', 'right', 'cross', 'inner'];

    public function __construct(string $table, ?array $on = null, ?string $alias = null, string $joinType = 'left')
    {
        $this->table = $table;
        if (!is_null($on)) {
            $this->on($on);
        }
        if (!is_null($alias)) {
            $this->alias = $alias;
        }
        if (!in_array($joinType, $this->joinTypes)) {
            throw new \InvalidArgumentException('DIE |JOIN construct|');
        }
        $this->joinType = $joinType;
    }

    public function getTable(): string
    {
        return (!is_null($this->alias)) ? $this->escapeField($this->alias) : $this->escapeField($this->table);
    }

    public function setParentTable(string $table): void
    {
        $this->parentTable = $table;
    }

    public function using(string $field): void
    {
        $this->using = $this->escapeField($field);
    }

    public function on(array $on): void
    {
        $this->on = $on;
    }

    private function onMap(array $array): string
    {
        return ' ON ' . $this->concatWhere(array_map(function ($item) {
            return $this->parentTable . '.' . $this->escapeField($item[0]) . ' = ' . $this->getTable() . '.' . $this->escapeField($item[1]);
        }, $array));
    }

    public function get(): string
    {
        return ' ' . strtoupper($this->joinType) . ' JOIN '
            . $this->escapeField($this->table)
            . (!is_null($this->alias) ? ' AS ' . $this->escapeField($this->alias) : '')
            . (!is_null($this->on)
                ? $this->onMap($this->on)
                : (!is_null($this->using)
                    ? ' USING(' . $this->escapeField($this->using) . ')'
                    : ''
                )
            );
    }

}
