<?php

namespace Compolomus\SQLQueryBuilder;

use Compolomus\SQLQueryBuilder\System\Helper;
use Compolomus\SQLQueryBuilder\System\Interfaces\PDOInstanceInterface;
use Compolomus\SQLQueryBuilder\System\Traits\PDOInstance;
use Compolomus\SQLQueryBuilder\Parts\{
    Insert, Select, Delete, Count
};

class Builder implements PDOInstanceInterface
{
    use PDOInstance;

    private $table;

    private $select;

    private $delete;

    private $insert;

    private $count;

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
}
