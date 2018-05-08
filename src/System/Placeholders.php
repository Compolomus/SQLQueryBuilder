<?php

namespace Compolomus\LSQLQueryBuilder\System;

class Placeholders
{
    private $placeholders;

    public function __construct(array $placeholders = []) // reset
    {
        $this->placeholders = $placeholders;
    }

    public function set(string $key, $value): void
    {
        $this->placeholders[':' . $key] = $value;
    }

    public function get(): array
    {
        return $this->placeholders;
    }
}
