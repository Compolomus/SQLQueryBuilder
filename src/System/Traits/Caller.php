<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

trait Caller
{
    private $base;

    public function base($base): void
    {
        $this->base = $base;
    }

    public function __call(string $method, $args)
    {
        if (!method_exists(__CLASS__, $method)) {
            return $this->base->$method(...$args);
        }
    }
}
