<?php

namespace Compolomus\LSQLQueryBuilder\System;

use Compolomus\LSQLQueryBuilder\BuilderException;

class Conditions
{
    use Traits\Placeholders,
        Traits\Helper;

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
        if (!\in_array(strtolower($condition), $this->conditionTypes, true)) {
            throw new BuilderException('Передан неверный тип ' . $condition . ' |CONDITIONS add|');
        }
        $key = $this->uid('w');
        $value = $this->type($condition, $value);
        $this->placeholders()->set($key, $value);
        $this->conditions[] = $this->escapeField($field) . ' ' . strtoupper($condition) . ' :' . $key;
    }

    public function type(string $condition, $value): string
    {
        return \in_array($condition, ['in', 'not in'], true)
            ? '(' . $this->concat($value) . ')'
            : (\in_array($condition, ['between', 'not between'], true)
                ? implode(' AND ', $value)
                : $value
            );
    }
}
