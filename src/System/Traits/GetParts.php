<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

trait GetParts
{
    public function getParts(array $fields = ['where', 'group', 'order', 'limit']): string
    {
        $result = '';
        foreach ($fields as $value) {
            $result .= (property_exists($this, $value) && \is_object($this->$value) ? ' ' . $this->$value->result() : '');
        }
        return $result;
    }
}
