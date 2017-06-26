<?php

namespace Compolomus\LSQLQueryBuilder;

use Compolomus\LSQLQueryBuilder\{
    System\Traits\Helper,
    System\Interfaces\PDOInstanceInterface,
    System\Traits\Magic,
    System\Traits\PDOInstance,
    Parts\Insert,
    Parts\Select,
    Parts\Update,
    Parts\Delete,
    Parts\Count
};

/**
 * @method Insert insert(array $args)
 * @method Select select(array $fields)
 * @method Update update(array $args)
 * @method Delete delete(integer $id)
 * @method Count count(string $field, string|null $alias)
 */
class Builder implements PDOInstanceInterface
{
    use PDOInstance, Magic, Helper;

    private $table;

    private $placeholders = [];

    public function __construct($table)
    {
        if ($table) {
            $this->setTable($table);
        }
        $this->getPDO();
    }

    private function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function table()
    {
        return $this->escapeField($this->table);
    }

    public function placeholders()
    {
        return $this->placeholders;
    }

    public function addPlaceholders($placeholders)
    {

        $this->placeholders = $this->placeholders + $placeholders;
    }
}
