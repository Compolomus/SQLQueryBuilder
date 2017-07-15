<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller,
    GetParts,
    Placeholders,
    Limit as TLimit,
    Where as TWhere,
    Order as TOrder
};

/**
 * @method string table()
 */
class Update extends Insert
{
    use Caller, TLimit, TWhere, TOrder, GetParts, Placeholders, Helper;

    public function set(array $values): string
    {
        $result = [];
        foreach ($values as $value) {
            $key = $this->uid('u');
            $result[] = ':' . $key;
            $this->placeholders()->set($key, $value);
        }
        return implode(',',
            array_map(function($field, $value) {
                return $field . ' = ' . $value;
            }
                , $this->escapeField($this->fields), $result));
    }

    public function get(): string
    {
        $this->addPlaceholders($this->placeholders()->get());
        return 'UPDATE ' . $this->table() . ' SET '
            . (count($this->values)
                ? implode(',', $this->values)
                : (count($this->fields) & !count($this->values)
                    ? implode(',', array_map(function ($field) {
                        return $this->escapeField($field) . ' = ?';
                    ;}, $this->fields))
                    : '')
            )
            . $this->getParts();
    }
}
