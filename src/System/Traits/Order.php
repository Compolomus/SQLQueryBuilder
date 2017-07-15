<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Order as Porder;

trait Order
{
    private $order;

    public function order(?string $field = null, string $type = 'asc'): Porder
    {
        $this->order = new Porder($field, $type);
        $this->order->base($this);
        return $this->order;
    }
}
