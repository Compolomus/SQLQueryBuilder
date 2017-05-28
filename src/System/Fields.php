<?php

namespace Koenig\SQLQueryBuilder\System;

use Koenig\SQLQueryBuilder\System\Helper;

class Fields
{
    private $fields;

    public function __construct(array $fields)
    {
        $return = '*';
        if (count($fields)) {
            $return = [];
            foreach ($fields as $alias => $field) {
                if (is_int($alias)) {
                    $return[] = Helper::escapeField($field);
                } else {
                    $return[] = Helper::escapeField($alias) . ' AS ' . Helper::escapeField($field);
                }
            }
        }
        $this->fields = $return;
    }

    public function result()
    {
        if ($this->fields != '*') {
            return Helper::concatFields($this->fields);
        }
    }
}
