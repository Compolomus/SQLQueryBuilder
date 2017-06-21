<?php

namespace Compolomus\SQLQueryBuilder\Parts;

use Compolomus\SQLQueryBuilder\System\{
    Helper,
    Traits\Caller,
    Traits\SValues,
    Placeholders
};

/**
 * @method string table()
 */
class Insert
{
    use Caller;

    protected $fields = [];

    protected $values = [];

    public function __construct(array $args = [])
    {
        if (count($args) > 0) {
            if (preg_match('/[a-z]+/i', key($args))) {
                $this->fields(array_keys($args));
            }
            $this->values(array_values($args));
        }
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function values($values)
    {
        $this->values[] = $this->set($values);
        return $this;
    }

    protected function set($values)
    {
        $result = [];
        foreach ($values as $value) {
            $result[] = ':i' . Placeholders::$counter;
            Placeholders::add('i', $value);
        }
        return '(' . implode(',', $result) . ')';
    }

    public function get()
    {
        return 'INSERT INTO ' . $this->table() . ' '
            . (count($this->fields) ? '(' . implode(',', Helper::escapeField($this->fields)) . ')' : '')
            . ' VALUES '
            . (count($this->values)
                ? implode(',', $this->values)
                : (count($this->fields) & !count($this->values)
                    ? '(' . implode(',', array_fill(0, count($this->fields), '?')) . ')'
                    : '')
            );
    }
}
