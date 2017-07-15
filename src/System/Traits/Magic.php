<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

trait Magic
{
    private $data = [];

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    public function __call(string $name, $args)
    {
        $class = "Compolomus\\LSQLQueryBuilder\\Parts\\" . ucfirst($name);
        if (class_exists($class)) {
            $this->$name = new $class(...$args);
            $this->$name->base($this);
            return $this->$name;
        }
    }
}
