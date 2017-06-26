<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\Traits\{
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

    private $result;

    public function set($values)
    {
        $result = [];
        foreach ($values as $value) {
            $key = $this->uid('u');
            $result[] = ':' . $key;
            $this->placeholders()->set($key, $value);
        }
        $this->result = implode(',',
            array_map(function($field, $value) {
                return $field . ' = ' . $value;
            }
                , $this->escapeField($this->fields), $result));
    }

    public function get()
    {
        $this->addPlaceholders($this->placeholders()->get());
        return 'UPDATE ' . $this->table() . ' SET '
            . $this->result
            . $this->getParts();
    }
}
