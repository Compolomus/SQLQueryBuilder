<?php

namespace Compolomus\SQLQueryBuilder\System;

use Compolomus\SQLQueryBuilder\System\Helper;

class Fields
{
    private $fields;

    public function __construct(array $fields)
    {
        $return = [];
        if (count($fields)) {
            foreach ($fields as $alias => $field) {
                if (is_int($alias)) {
                    $return[] = Helper::escapeField($field);
                } else {
                    $return[] = Helper::escapeField($alias) . ' AS ' . Helper::escapeField($field);
                }
            }
        } else {
            $return[] = '*';
        }
        $this->fields = $return;
    }

    public function count($field = '*', $alias = null)
    {
        if ($field != '*') {
            $field = Helper::escapeField($field);
        }
        $this->fields[] = 'COUNT(' . $field . ')' . (!is_null($alias) ? ' AS ' . Helper::escapeField($alias) : '');
    }

    public function result()
    {
        return Helper::concatFields($this->fields);
    }
}
