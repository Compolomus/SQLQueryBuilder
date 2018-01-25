<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\Traits\{
    Helper,
    Caller,
    GetParts,
    Placeholders,
    Limit as TLimit,
    Where as TWhere,
    Order as TOrder
};

/**
 * @method string table()
 * @method void addPlaceholders($placeholders)
 */
class Update extends Insert
{
    use Caller, TLimit, TWhere, TOrder, GetParts, Placeholders, Helper;

    protected $values = null;

    public function set(array $values): string
    {
        return $this->concat(
            array_map(function ($field, $value) {
                return $field . ' = ' . $value;
            },
                $this->escapeField($this->fields), $this->preSet($values, 'u')));
    }

    public function values(array $values): Insert
    {
        $this->values = $this->set($values);
        return $this;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        $this->addPlaceholders($this->placeholders()->get());
        return 'UPDATE ' . $this->table() . ' SET '
            . (!is_null($this->values)
                ? $this->values
                : $this->concat(array_map(function ($field) {
                    return $this->escapeField($field) . ' = ?';;
                }, $this->fields))
            )
            . $this->getParts();
    }
}
