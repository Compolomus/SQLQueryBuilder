<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\{
    Caller,
    Fields
};

class Select
{
    use Caller;

    private $fields;

    public function __construct(array $fields = [])
    {
        $this->fields = new Fields($fields);
    }

    public function result() {
        return 'SELECT ' . $this->fields->result() . ' FROM ' . $this->table();
    }
}
