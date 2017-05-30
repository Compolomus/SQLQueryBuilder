<?php

namespace Koenig\SQLQueryBuilder;

use Koenig\SQLQueryBuilder\System\Helper;
use Koenig\SQLQueryBuilder\System\Interfaces\PDOInstanceInterface;
use Koenig\SQLQueryBuilder\System\Traits\PDOInstance;
use Koenig\SQLQueryBuilder\Parts\{
    Select,
    Delete
};

class Builder implements PDOInstanceInterface
{
    use PDOInstance;

    private $table;

    private $select;

    private $delete;

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

    public function delete($id = 0)
    {
        $this->delete = new Delete($id);
        $this->delete->base($this);
        return $this->delete;
    }
}
