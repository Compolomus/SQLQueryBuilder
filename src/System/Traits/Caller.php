<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\BuilderException;

/**
 * @method string table()
 * @method void addPlaceholders($placeholders)
 */
trait Caller
{
    private $base;

    public function setBase($base): void
    {
        $this->base = $base;
    }

    public function __call(string $method, $args)
    {
        if (!method_exists(__CLASS__, $method)) {
            return $this->base->$method(...$args);
        }
    }

    public function __toString()
    {
        return static::get();
    }
}
