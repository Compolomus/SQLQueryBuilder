<?php

namespace Compolomus\LSQLQueryBuilder;

class BuilderFactory
{
    public function __invoke(?string $table = null)
    {
        return new Builder($table);
    }
}
