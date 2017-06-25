<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\{
    Helper,
    Traits\Caller,
    Traits\Limit as TLimit,
    Traits\Where as TWhere,
    Traits\Order as TOrder,
    Traits\GetParts,
    Traits\Placeholders
};

/**
 * @method string table()
 */
class Update extends Insert
{
    use Caller, TLimit, TWhere, TOrder, GetParts, Placeholders;

    private $result;

    public function set($values)
    {
        $result = [];
        foreach ($values as $value) {
            $key = Helper::uid('u');
            $result[] = ':' . $key;
            $this->placeholders()->set($key, $value);
        }
        $this->result = implode(',',
            array_map(function($field, $value) {
                return $field . ' = ' . $value;
            }
                , Helper::escapeField($this->fields), $result));
    }

    public function get()
    {
        $this->addPlaceholders($this->placeholders()->get());
        return 'UPDATE ' . $this->table() . ' SET '
            . $this->result
            . $this->getParts();
    }
}
