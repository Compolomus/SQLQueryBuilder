<?php

namespace Compolomus\SQLQueryBuilder\System;

class Conditions
{
    use Traits\Placeholders;

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

    public function conditions()
    {
        return $this->conditions;
    }

    public function add($field, $condition, $value)
    {
        if (!in_array(strtolower($condition), $this->conditionTypes)) {
            throw new InvalidArgumentException('Передан неверный тип |CONDITIONS add|');
        }
        $key = Helper::uid('w');
        $value = $this->type($condition, $value);
        $this->placeholders()->set($key, $value);
        $this->conditions[] = Helper::escapeField($field) . ' ' . strtoupper($condition) . ' :' . $key;
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
