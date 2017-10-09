<?php declare(strict_types=1);

namespace Compolomus\LSQLQueryBuilder;

class BuilderFactory
{
    public function __invoke()
    {
        return new Builder;
    }
}
