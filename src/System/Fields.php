<?php

namespace Compolomus\SQLQueryBuilder\System;

class Fields
{
    use Traits\Helper;

    private $fields = [];

    public function __construct(array $fields, $count = false)
    {
        if ($count) {
            $this->count(key($fields), end($fields));
        } else {
            $this->setFields($fields);
        }
    }

    public function setFields($fields)
    {
        $return = [];
        if (count($fields)) {
            foreach ($fields as $alias => $field) {
                if (is_int($alias)) {
                    $return[] = $this->escapeField($field);
                } else {
                    $return[] = $this->escapeField($alias) . ' AS ' . $this->escapeField($field);
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
            $field = $this->escapeField($field);
        }
        $this->fields[] = 'COUNT(' . $field . ')' . (!is_null($alias) ? ' AS ' . $this->escapeField($alias) : '');
    }

    public function result()
    {
        return $this->concatFields($this->fields);
    }
}
