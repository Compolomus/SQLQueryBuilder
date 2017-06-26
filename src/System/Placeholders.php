<?php

namespace Compolomus\LSQLQueryBuilder\System;

class Placeholders
{
    private $placeholders = [];

    public function __construct($placeholders = []) // reset
    {
        $this->placeholders = $placeholders;
    }

    public function set($key, $value)
    {
        $this->placeholders[$key] = $value;
    }

    public function get()
    {
        return $this->placeholders;
    }
}
