<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\{
    Caller,
    Helper
};

class Order
{
    use Caller;

    private $orders = [
        'asc' => [],
        'desc' => []
    ];

    public function __construct($field, $type = 'asc')
    {
        if (!is_null($field)) {
            $this->add($field, $type);
        }
    }

    public function add($field, $type = 'asc')
    {
        if (!in_array(strtolower($type), array_keys($this->orders))) {
            throw new InvalidArgumentException('Передан неверный тип |ORDER add|');
        }
        $this->orders[$type][] = $field;
        return $this;
    }

    public function result()
    {
        $order = '';
        $asc = Helper::concatOrder($this->orders['asc'], 'asc');
        $desc = Helper::concatOrder($this->orders['desc'], 'desc');
        if ($asc | $desc) {
            $order = 'ORDER BY ' . $asc . ($asc & $desc ? ', ' : '') . $desc;
        }
        return $order;
    }
}
