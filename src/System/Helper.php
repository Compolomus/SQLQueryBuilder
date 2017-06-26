<?php

namespace Compolomus\SQLQueryBuilder\System;

class Helper
{
    public static function concatWhere(array $conditions, $separator = 'and')
    {
        if (in_array($separator, ['and', 'or'])) {
            return implode(' ' . strtoupper($separator) . ' ', $conditions);
        } else {
            throw new \InvalidArgumentException('Передан неверный тип |WHERE concate|');
        }
    }

    public static function concatFields(array $fields)
    {
        return implode(',', $fields);
    }

    public static function concatOrder(array $order, $type = 'asc')
    {
        $result = '';
        if (in_array($type, ['asc', 'desc'])) {
            if (count($order) > 0) {
                $result = implode(', ', self::escapeField($order)) . ' ' . strtoupper($type);
            }
        } else {
            throw new \InvalidArgumentException('Передан неверный тип |ORDER concate|');
        }
        return $result;
    }

    public static function escapeField($field)
    {
        if (!is_array($field)) {
            $field = '`' . $field . '`';
        } else {
            $field = array_map([self, 'escapeField'], $field);
        }
        return $field;
    }

    public static function map($field, $value)
    {
        return $field . ' = ' . $value;
    }

    public static function uid($prefix)
    {
        $str = uniqid(strtoupper($prefix) . '-', true);
        return str_replace('.', '', substr($str, 0, 2) . substr($str, 12, -4));
    }
}
