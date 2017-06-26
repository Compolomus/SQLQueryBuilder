<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

trait Helper
{
    public function concatWhere(array $conditions, $separator = 'and')
    {
        if (!in_array($separator, ['and', 'or'])) {
            throw new \InvalidArgumentException('Передан неверный тип |WHERE concate|');
        }
        return implode(' ' . strtoupper($separator) . ' ', $conditions);
    }

    public function concatFields(array $fields)
    {
        return implode(',', $fields);
    }

    public function concatOrder(array $order, $type = 'asc')
    {
        if (!in_array($type, ['asc', 'desc'])) {
            throw new \InvalidArgumentException('Передан неверный тип |ORDER concate|');
        }
        $result = '';
        if (count($order) > 0) {
            $result = implode(', ', $this->escapeField($order)) . ' ' . strtoupper($type);
        }
        return $result;
    }

    public function escapeField($field)
    {
        return is_array($field) ? array_map([$this, 'escapeField'], $field) : '`' . $field . '`';
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
