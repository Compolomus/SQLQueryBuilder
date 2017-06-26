<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller
};

class Order
{
    use Caller, Helper;

    private $orders = [
        'asc' => [],
        'desc' => []
    ];

    public function __construct($field = null, $type = 'asc')
    {
        if (!is_null($field)) {
            $this->add($field, $type);
        }
    }

    public function add($field, $type = 'asc')
    {
        if (!in_array(strtolower($type), array_keys($this->orders))) {
            throw new \InvalidArgumentException('Передан неверный тип |ORDER add|');
        }
        $this->orders[$type][] = $field;
        return $this;
    }

    public function result()
    {
        $order = '';
        $asc = $this->concatOrder($this->orders['asc'], 'asc');
        $desc = $this->concatOrder($this->orders['desc'], 'desc');
        if ($asc | $desc) {
            $order = 'ORDER BY ' . $asc . ($asc & $desc ? ', ' : '') . $desc;
        }
        return $order;
    }
}
