<?php

namespace Koenig\SQLQueryBuilder\System\Traits;

trait Order
{
    private $order = false;

    public function order($field = null, $type = 'asc')
    {
        $this->order = new \Koenig\SQLQueryBuilder\Parts\Order($field, $type);
        $this->order->base($this);
        return $this->order;
    }
}
