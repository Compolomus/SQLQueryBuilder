<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\Traits\Caller;

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

        switch ($type) {
            default:
            case 'limit':
                if (!$this->offset) {
                    list($this->limit, $this->offset) = [$this->offset, $this->limit];
                }
                break;

            case 'offset':
                list($this->limit, $this->offset) = [$this->offset, $this->limit];
                break;

            case 'page':
                if ($this->offset <= 0) {
                    throw new InvalidArgumentException('Отрицательный или нулевой аргумент |PAGE construct|');
                }
                $this->offset = ($this->offset - 1) * $this->limit;
                break;
        }
    }

    public function result()
    {
        return $this->limit ? 'LIMIT ' . $this->offset . ' OFFSET ' . $this->limit : '';
    }
}
