<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\System\{
    Traits\Helper,
    Traits\GetParts,
    Traits\Join as TJoin,
    Traits\Limit as TLimit,
    Traits\Where as TWhere,
    Traits\Order as TOrder,
    Traits\Group as TGroup,
    Traits\Caller,
    Fields
};

/**
 * @method string table()
 */
class Select
{
    use TJoin, TLimit, TWhere, TOrder, TGroup, Caller, GetParts, Helper;

    private $fields = [];

    public function __construct(array $fields = ['*'])
    {
        $this->setFields($fields);
    }

    private function setFields(array $fields): void
    {
        foreach ($fields as $allias => $column) {
            preg_match("#(?<fieldName>.*)\|(?<function>.*)#", $column, $matches);
            if (count($matches)) {
                $field = $matches['fieldName'];
                $object = $this->fields[$field] = new Fields($field);
                $object->setFunction($matches['function']);
            } else {
                $object = $this->fields[$column] = new Fields($column);
            }
            if (!is_int($allias)) {
                $object->setAllias($allias);
            }
        }
    }

    public function setFunction(string $fieldName, string $function): Select
    {
        if (!in_array($fieldName, array_keys($this->fields))) {
            throw new \InvalidArgumentException('Не найдено поле ' . $fieldName . ' |SELECT setFunction|');
        }
        $this->fields[$fieldName]->setFunction($function);
        return $this;
    }

    public function setAllias(string $fieldName, string $allias): Select
    {
        $this->fields[$fieldName]->setAllias($allias);
        return $this;
    }

    public function getFields(): string
    {
        return $this->concat(array_map(function(Fields $field): string {
            return $field->result();
        }, $this->fields));
    }

    public function get(): string
    {
        return 'SELECT ' . $this->getFields() . ' FROM '
            . $this->table()
            . (!is_null($this->join) ? $this->join->result() : '')
            . $this->getParts();
    }
}
