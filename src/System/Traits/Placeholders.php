<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder\System\Traits;

use Compolomus\LSQLQueryBuilder\System\Placeholders as SPlaceholders;

trait Placeholders
{
    private $placeholders = null;

    public function placeholders(): SPlaceholders
    {
        if (is_null($this->placeholders)) {
            $this->placeholders = new SPlaceholders;
        }
        return $this->placeholders;
    }
}
