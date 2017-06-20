<?php

namespace Compolomus\SQLQueryBuilder\System;

class Conditions
{
    private $conditionTypes = [
        '=',
        '!=', // <>
        '>',
        '<',
        '<=',
        '>=',
        'like',
        'not like',
        'regexp',
        'in',
        'not in',
        'between',
        'not between',
    ];

    private $conditions = [];

    public function __construct()
    {
    }

    public function conditions()
    {
        return $this->conditions;
    }

    public function add($field, $condition, $value)
    {
        if (!in_array(strtolower($condition), $this->conditionTypes)) {
            throw new InvalidArgumentException('Передан неверный тип |CONDITIONS add|');
        }
        $this->conditions[] = Helper::escapeField($field) . ' ' . strtoupper($condition) . ' :' . 'w' . Placeholders::$counter;
        $value = $this->type($condition, $value);
        Placeholders::add('w', $value);
    }

    public function type($condition, $value)
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
