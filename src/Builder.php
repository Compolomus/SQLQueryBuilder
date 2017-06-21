<?php

namespace Compolomus\SQLQueryBuilder;

use Compolomus\SQLQueryBuilder\{
    System\Helper,
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
    use PDOInstance, Magic;

    private $table;

    public function __construct($table = false)
    {
        if ($table) {
            $this->setTable($table);
        }
        $this->getPDO();
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function table()
    {
        return $this->table ? Helper::escapeField($this->table) : null;
    }
}
