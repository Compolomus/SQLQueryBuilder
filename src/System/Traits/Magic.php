<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

trait Magic
{
    private $data = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    public function __call($name, $args)
    {
        $class = "Compolomus\\SQLQueryBuilder\\Parts\\" . ucfirst($name);
        if (class_exists($class)) {
            $this->$name = new $class(...$args);
            $this->$name->base($this);
            return $this->$name;
        }
    }
}
