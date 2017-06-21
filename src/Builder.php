<?php

namespace Compolomus\SQLQueryBuilder;

use Compolomus\SQLQueryBuilder\{
    System\Helper,
    System\Interfaces\PDOInstanceInterface,
    System\Traits\PDOInstance,
    Parts\Insert,
    Parts\Select,
    Parts\Update,
    Parts\Delete,
    Parts\Count
};

class Builder implements PDOInstanceInterface
{
    use PDOInstance;

    private $table;

    private $select;

    private $delete;

    private $insert;

    private $count;

    private $update;

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

    public function select(array $fields = [])
    {
        $this->select = new Select($fields);
        $this->select->base($this);
        return $this->select;
    }

    public function count($field = '*', $alias = null)
    {
        $this->count = new Count($field, $alias);
        $this->count->base($this);
        return $this->count;
    }

    public function delete($id = 0)
    {
        $this->delete = new Delete($id);
        $this->delete->base($this);
        return $this->delete;
    }

    public function insert($args = [])
    {
        $this->insert = new Insert($args);
        $this->insert->base($this);
        return $this->insert;
    }

    public function update($args = [])
    {
        $this->update = new Update($args);
        $this->update->base($this);
        return $this->update;
    }
}
