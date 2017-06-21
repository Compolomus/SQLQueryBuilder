<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\{
    Helper,
    Placeholders,
    Traits\Caller,
    Traits\Limit as TLimit,
    Traits\Where as TWhere,
    Traits\Order as TOrder,
    Traits\GetParts
};

/**
 * @method string table()
 */
class Update extends Insert
{
    use Caller, TLimit, TWhere, TOrder, GetParts;

    private $result;

    public function set($values)
    {
        $result = [];
        foreach ($values as $value) {
            $result[] = ':u' . Placeholders::$counter;
            Placeholders::add('u', $value);
        }
        $this->result = implode(',',
            array_map(function ($field, $value) {
                return $field . ' = ' . $value;
            }
                , Helper::escapeField($this->fields), $result));
    }

    public function get()
    {
        return 'UPDATE ' . $this->table() . ' SET '
            . $this->result
            . $this->getParts();
    }
}
