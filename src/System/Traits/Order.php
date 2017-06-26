<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Order as Porder;

trait Order
{
    private $order;

    public function order($field = null, $type = 'asc')
    {
        $this->order = new Porder($field, $type);
        $this->order->base($this);
        return $this->order;
    }
}
