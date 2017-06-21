<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

trait GetParts
{
    public function getParts($fields = ['where', 'group', 'order', 'limit'])
    {
        $result = '';
        foreach ($fields as $value) {
            $result .= (is_object($this->$value) ? ' ' . $this->$value->result() : '');
        }
        return $result;
    }
}
