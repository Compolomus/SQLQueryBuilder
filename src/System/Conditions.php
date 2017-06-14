<?php

namespace Koenig\SQLQueryBuilder\System;

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
        $this->conditions[] = Helper::escapeField($field) . ' ' . $condition . ' :' . 'w' . Placeholders::$counter;
        switch ($condition) {
            default:
                break;
            case 'in':
            case 'not in':
                $value = '(' . implode(',', $value) . ')';
                break;
            case 'between':
            case 'not between':
                $value = implode(' AND ', $value);
                break;
        }
        Placeholders::add('w', $value);
    }
}
