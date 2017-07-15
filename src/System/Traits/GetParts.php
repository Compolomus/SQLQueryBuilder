<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

trait GetParts
{
    public function getParts(array $fields = ['where', 'group', 'order', 'limit']): string
    {
        $result = '';
        foreach ($fields as $value) {
            $result .= (is_object($this->$value) ? ' ' . $this->$value->result() : '');
        }
        return $result;
    }
}
