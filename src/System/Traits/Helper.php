<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

trait Helper
{
    public function concatWhere(array $conditions, $separator = 'and')
    {
        if (in_array($separator, ['and', 'or'])) {
            return implode(' ' . strtoupper($separator) . ' ', $conditions);
        } else {
            throw new \InvalidArgumentException('Передан неверный тип |WHERE concate|');
        }
    }

    public function concatFields(array $fields)
    {
        return implode(',', $fields);
    }

    public function concatOrder(array $order, $type = 'asc')
    {
        $result = '';
        if (in_array($type, ['asc', 'desc'])) {
            if (count($order) > 0) {
                $result = implode(', ', $this->escapeField($order)) . ' ' . strtoupper($type);
            }
        } else {
            throw new \InvalidArgumentException('Передан неверный тип |ORDER concate|');
        }
        return $result;
    }

    public function escapeField($field)
    {
        if (!is_array($field)) {
            $field = '`' . $field . '`';
        } else {
            $field = array_map([$this, 'escapeField'], $field);
        }
        return $field;
    }

    public function map($field, $value)
    {
        return $field . ' = ' . $value;
    }

    public function uid($prefix)
    {
        $str = uniqid(strtoupper($prefix) . '-', true);
        return str_replace('.', '', substr($str, 0, 2) . substr($str, 12, -4));
    }
}
