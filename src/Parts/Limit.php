<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller
};

class Limit
{
    use Caller, Helper;

    private $limit;

    private $offset;

    public function __construct(int $limit, int $offset = 0, string $type = 'limit')
    {
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

    public function tPage(): void
    {
        $this->offset = ($this->offset - 1) * $this->limit;
    }

    private function list(): array
    {
        return list($this->limit, $this->offset) = [$this->offset, $this->limit];
    }

    public function result(): string
    {
        return 'LIMIT ' . $this->offset . ' OFFSET ' . $this->limit;
    }
}
