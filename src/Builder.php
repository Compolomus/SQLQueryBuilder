<?php

namespace Compolomus\LSQLQueryBuilder;

use Compolomus\LSQLQueryBuilder\{
    System\Traits\Helper,
    Parts\Insert,
    Parts\Select,
    Parts\Update,
    Parts\Delete
};

/**
 * @method Insert insert(array $args = [])
 * @method Select select(array $fields = [])
 * @method Update update(array $args = [])
 * @method Delete delete(integer $id = 0, string $field = 'id')
 */
class Builder
{
    use Helper;

    private $table;

    private $placeholders = [];

    private $data = [];

    public function __construct(?string $table = null)
    {
        if ($table) {
            $this->setTable($table);
        }
    }

    public function setTable(string $table): Builder
    {
        $this->table = $table;
        return $this;
    }

    public function table(): string
    {
        return $this->table ? $this->escapeField($this->table) : '';
    }

    public function placeholders(): array
    {
        $return = $this->placeholders;
        $this->placeholders = [];
        return $return;
    }

    public function addPlaceholders($placeholders): void
    {
        $this->placeholders += $placeholders;
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

//    public function __isset(string $name): bool
//    {
//        return isset($this->data[$name]);
//    }
//
//    public function __unset(string $name): void
//    {
//        unset($this->data[$name]);
//    }

    public function __call(string $name, $args)
    {
        $class = "Compolomus\\LSQLQueryBuilder\\Parts\\" . ucfirst($name);
        if (class_exists($class)) {
            $this->$name = new $class(...$args);
            $this->$name->setBase($this);
            return $this->$name;
        }
        throw new BuilderException('Undefined class ' . $class . ' |Builder call|');
    }

    public function __toString(): string
    {
        return current($this->data)->__toString();
    }
}
