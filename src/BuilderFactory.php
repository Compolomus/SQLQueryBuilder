<?php

namespace Compolomus\LSQLQueryBuilder;

class BuilderFactory
{
    public function __invoke()
    {
        return new Builder;
    }
}
