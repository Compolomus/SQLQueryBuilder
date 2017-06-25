<?php

namespace Compolomus\SQLQueryBuilder\System\Traits;

use Compolomus\SQLQueryBuilder\System\Placeholders as SPlaceholders;

trait Placeholders
{
    private $placeholders = null;

    public function placeholders()
    {
        if (is_null($this->placeholders)) {
            $this->placeholders = new SPlaceholders;
        }
        return $this->placeholders;
    }
}
