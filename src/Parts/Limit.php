<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller,
    Placeholders
};

class Limit
{
    use Caller, Placeholders, Helper;

    private $limit;

    private $offset;

    public function __construct($limit, $offset = 0, $type = 'limit')
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException('Отрицательный или нулевой аргумент |LIMIT construct|');
        }
        $this->limit = $limit;
        $this->offset = $offset;

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
            throw new \InvalidArgumentException('Отрицательный или нулевой аргумент |PAGE construct|');
        }
        $this->offset = ($this->offset - 1) * $this->limit;
    }

    private function list()
    {
        return list($this->limit, $this->offset) = [$this->offset, $this->limit];
    }

    public function setPlaceholders()
    {
        $offset = $this->uid('l');
        $this->placeholders()->set($offset, $this->offset);
        $limit = $this->uid('l');
        $this->placeholders()->set($limit, $this->limit);
        return ['offset' => ':' . $offset, 'limit' => ':' . $limit];
    }

    public function result()
    {
        $placeholders = $this->setPlaceholders();
        $this->addPlaceholders($this->placeholders()->get());
        return $this->limit ? 'LIMIT ' . $placeholders['offset'] . ' OFFSET ' . $placeholders['limit'] : '';
    }
}
