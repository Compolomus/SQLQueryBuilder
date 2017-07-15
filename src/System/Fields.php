<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System;

class Fields
{
    use Traits\Helper;

    private $fields = [];

    public function __construct(array $fields, bool $count = false)
    {
        $count ? $this->count(key($fields), end($fields)) : $this->setFields($fields);
    }

    public function setFields($fields)
    {
        $return = [];
        if (count($fields)) {
            foreach ($fields as $alias => $field) {
                $return[] = is_int($alias) ? $this->escapeField($field) : $this->escapeField($alias) . ' AS ' . $this->escapeField($field);
            }
        } else {
            $return[] = '*';
        }

        $this->fields = $return;
    }

    public function count(string $field = '*', ?string $alias = null): void
    {
        if ($field != '*') {
            $field = $this->escapeField($field);
        }
        $this->fields[] = 'COUNT(' . $field . ')' . (!is_null($alias) ? ' AS ' . $this->escapeField($alias) : '');
    }

    public function result(): string
    {
        return $this->concatFields($this->fields);
    }
}
