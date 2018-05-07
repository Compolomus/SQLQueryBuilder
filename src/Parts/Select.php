<?php

namespace Compolomus\LSQLQueryBuilder\Parts;

use Compolomus\LSQLQueryBuilder\BuilderException;
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
        array_map([$this, 'setField'], array_keys($fields), array_values($fields));
    }

    private function setField($allias, $value): void
    {
        preg_match("#(?<fieldName>\w{2,}|\*)(\|(?<function>\w{2,}))?#i", $value, $matches);
        $field = $matches['fieldName'];
        $object = $this->fields[$field] = new Fields($field);
        if (isset($matches['function'])) {
            $object->setFunction($matches['function']);
        }
        if (!\is_int($allias)) {
            $object->setAllias($allias);
        }
    }

    public function setFunction(string $fieldName, string $function): Select
    {
        if (!array_key_exists($fieldName, $this->fields)) {
            throw new BuilderException('Не найдено поле ' . $fieldName . ' |SELECT setFunction|');
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
            . (null !== $this->join ? $this->join->result() : '')
            . $this->getParts();
    }
}
