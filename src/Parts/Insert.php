<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller,
    Placeholders
};

/**
 * @method string table()
 * @method void addPlaceholders($placeholders)
 */
class Insert
{
    use Caller, Placeholders, Helper;

    protected $fields = [];

    protected $values = [];

    public function __construct(array $args = [])
    {
        if (count($args) > 0) {
            if (is_string(key($args))) {
                $this->fields(array_keys($args));
            }
            $this->values(array_values($args));
        }
    }

    public function fields(array $fields): Insert
    {
        $this->fields = $fields;
        return $this;
    }

    public function values(array $values): Insert
    {
        $this->values[] = $this->set($values);
        return $this;
    }

    protected function set(array $values): string
    {
        $result = [];
        foreach ($values as $value) {
            $key = $this->uid('i');
            $result[] = ':' . $key;
            $this->placeholders()->set($key, $value);
        }
        return '(' . implode(',', $result) . ')';
    }

    public function get(): string
    {
        $this->addPlaceholders($this->placeholders()->get());
        return 'INSERT INTO ' . $this->table() . ' '
            . (count($this->fields) ? '(' . implode(',', $this->escapeField($this->fields)) . ')' : '')
            . ' VALUES '
            . (count($this->values)
                ? implode(',', $this->values)
                : (count($this->fields) && !count($this->values)
                    ? '(' . implode(',', array_fill(0, count($this->fields), '?')) . ')'
                    : '')
            );
    }
}
