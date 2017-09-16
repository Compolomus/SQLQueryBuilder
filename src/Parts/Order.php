<?php declare(strict_types=1);

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

    public function __construct(?string $field = null, string $type = 'asc')
    {
        if (!is_null($field)) {
            if (!in_array(strtolower($type), array_keys($this->orders))) {
                throw new \InvalidArgumentException('Передан неверный тип |ORDER add|');
            }
            $this->add($field, $type);
        }
    }

    public function add(string $field, string $type = 'asc'): Order
    {
        $this->orders[$type][] = $field;
        return $this;
    }

    public function result(): string
    {
        $order = '';
        $asc = $this->concatOrder($this->orders['asc'], 'asc');
        $desc = $this->concatOrder($this->orders['desc'], 'desc');
        if ($asc | $desc) {
            $order = 'ORDER BY ' . $asc . ($asc & $desc ? ',' : '') . $desc;
        }
        return $order;
    }
}
