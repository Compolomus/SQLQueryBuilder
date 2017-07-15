<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System;

class Conditions
{
    use Traits\Placeholders, Traits\Helper;

    private $conditionTypes = [
        '=',
        '!=', // <>
        '>',
        '<',
        '<=',
        '>=',
        'like',
        'not like',
        'regexp', // rlike
        'not regexp', // not rlike
        'in',
        'not in',
        'between',
        'not between',
    ];

    private $conditions = [];

    public function __construct()
    {
    }

    public function conditions(): array
    {
        return $this->conditions;
    }

    public function add(string $field, string $condition, $value): void
    {
        if (!in_array(strtolower($condition), $this->conditionTypes)) {
            throw new \InvalidArgumentException('Передан неверный тип |CONDITIONS add|');
        }
        $key = $this->uid('w');
        $value = $this->type($condition, $value);
        $this->placeholders()->set($key, $value);
        $this->conditions[] = $this->escapeField($field) . ' ' . strtoupper($condition) . ' :' . $key;
    }

    public function type(string $condition, $value)
    {
        return in_array($condition, ['in', 'not in'])
            ? '(' . implode(',', $value) . ')'
            : (
            in_array($condition, ['between', 'not between'])
                ? implode(' AND ', $value)
                : $value
            );
    }
}
