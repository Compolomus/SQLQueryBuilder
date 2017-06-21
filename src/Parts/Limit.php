<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\Traits\Caller;

class Limit
{
    use Caller;

    private $limit;

    private $offset;

    private $type;

    public function __construct($limit, $offset = 0, $type = 'limit')
    {
        if ($limit <= 0) {
            throw new InvalidArgumentException('Отрицательный или нулевой аргумент |LIMIT construct|');
        }
        $this->limit = $limit;
        $this->offset = $offset;
        $this->type = $type;

        $method = 't' . ucfirst($type);
        $this->$method();
    }

    public function tLimit()
    {
        if (!$this->offset) {
            $this->list();
        }
    }

    public function tOffset()
    {
        $this->list();
    }

    public function tPage()
    {
        if ($this->offset <= 0) {
            throw new InvalidArgumentException('Отрицательный или нулевой аргумент |PAGE construct|');
        }
        $this->offset = ($this->offset - 1) * $this->limit;
    }

    private function list()
    {
        return list($this->limit, $this->offset) = [$this->offset, $this->limit];
    }

    public function result()
    {
        return $this->limit ? 'LIMIT ' . $this->offset . ' OFFSET ' . $this->limit : '';
    }
}
