<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller
};

class Order
{
    use Caller, Helper;

    private $asc = [];

    private $desc = [];

    public function __construct(array $fields = [], string $type = 'asc')
    {
        if (!in_array(strtolower($type), ['asc', 'desc'])) {
            throw new \InvalidArgumentException('Передан неверный тип ' . $type . ' |ORDER add|');
        }
        if (count($fields)) {
            $this->map($fields, $type);
        }
    }

    private function map(array $fields, string $type = 'asc'): void
    {
        array_map([$this, 'add'], $fields, array_fill(0, count($fields), $type));
    }


    public function add(string $field, string $type = 'asc'): Order
    {
        $this->$type[] = $field;
        return $this;
    }

    public function desc(array $desc): Order
    {
        $this->map($desc, 'desc');
        return $this;
    }

    public function asc(array $asc): Order
    {
        $this->map($asc, 'asc');
        return $this;
    }

    public function result(): string
    {
        $order = '';
        $asc = $this->concatOrder($this->asc, 'asc');
        $desc = $this->concatOrder($this->desc, 'desc');
        if ($asc | $desc) {
            $order = 'ORDER BY ' . $asc . ($asc & $desc ? ',' : '') . $desc;
        }
        return $order;
    }
}
