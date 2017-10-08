<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\Parts\Order as Porder;

trait Order
{
    private $order;

    public function order(array $fields = [], string $type = 'asc'): Porder
    {
        $this->order = new Porder($fields, $type);
        $this->order->base($this);
        return $this->order;
    }
}
