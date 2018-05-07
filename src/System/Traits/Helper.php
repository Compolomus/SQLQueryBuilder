<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\BuilderException;

trait Helper
{
    public function concatWhere(array $conditions, string $separator = 'and'): string
    {
        if (!\in_array($separator, ['and', 'or'], true)) {
            throw new BuilderException('Передан неверный тип |WHERE concate|');
        }
        return implode(' ' . strtoupper($separator) . ' ', $conditions);
    }

    public function concat(array $fields): string
    {
        return implode(',', $fields);
    }

    public function concatOrder(array $order, string $type = 'asc'): string
    {
        if (!\in_array($type, ['asc', 'desc'], true)) {
            throw new BuilderException('Передан неверный тип |ORDER concate|');
        }
        $result = '';
        if (\count($order) > 0) {
            $result = implode(',', $this->escapeField($order)) . ' ' . strtoupper($type);
        }
        return $result;
    }

    /**
     * @param $field
     * @return array|string
     */
    public function escapeField($field)
    {
        return \is_array($field) ? array_map([$this, 'escapeField'], $field) : str_replace('`*`', '*',
            '`' . str_replace('.', '`.`', $field) . '`');
    }

    public function map(string $field, $value): string
    {
        return $field . ' = ' . $value;
    }

    public function uid(string $prefix): string
    {
        $prefix = strtoupper($prefix);
        $str = uniqid($prefix . '-', true);
        return str_replace('.', '', substr($str, 2, 2) . substr($str, 12, -4)) . $prefix;
    }
}
