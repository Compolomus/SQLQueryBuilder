<?php

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\System\Placeholders as SPlaceholders;

trait Placeholders
{
    private $placeholders;

    public function placeholders(): SPlaceholders
    {
        if (null === $this->placeholders) {
            $this->placeholders = new SPlaceholders;
        }
        return $this->placeholders;
    }
}
