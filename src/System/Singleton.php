<?php

namespace Koenig\SQLQueryBuilder\System;

trait Singleton
{
    protected static $instance = null;

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public final static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
