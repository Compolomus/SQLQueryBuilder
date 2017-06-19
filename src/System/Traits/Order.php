<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

use Compolomus\SQLQueryBuilder\Parts\Order as Porder;

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
