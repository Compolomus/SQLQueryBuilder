<?php declare(strict_types=1);

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

    public function __construct(int $limit, int $offset = 0, string $type = 'limit')
    {
        if ($limit <= 0) {
            throw new \InvalidArgumentException('Отрицательный или нулевой аргумент |LIMIT construct|');
        }
        $this->limit = $limit;
        $this->offset = $offset;

        $method = 't' . ucfirst($type);
        $this->$method();
    }

    public function tLimit(): void
    {
        if (!$this->offset) {
            $this->list();
        }
    }

    public function tOffset(): void
    {
        $this->list();
    }

    public function tPage(): ?\Exception
    {
        if ($this->offset <= 0) {
            throw new \InvalidArgumentException('Отрицательный или нулевой аргумент |PAGE construct|');
        } else {
            $this->offset = ($this->offset - 1) * $this->limit;
            return null;
        }
    }

    private function list(): array
    {
        return list($this->limit, $this->offset) = [$this->offset, $this->limit];
    }

    public function setPlaceholders(): array
    {
        $offset = $this->uid('l');
        $this->placeholders()->set($offset, $this->offset);
        $limit = $this->uid('l');
        $this->placeholders()->set($limit, $this->limit);
        return ['offset' => ':' . $offset, 'limit' => ':' . $limit];
    }

    public function result(): string
    {
        $placeholders = $this->setPlaceholders();
        $this->addPlaceholders($this->placeholders()->get());
        return $this->limit ? 'LIMIT ' . $placeholders['offset'] . ' OFFSET ' . $placeholders['limit'] : '';
    }
}
