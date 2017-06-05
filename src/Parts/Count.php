<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\Traits\{
    Caller,
    Limit as TLimit,
    Where as TWhere,
    Order as TOrder,
    Group as TGroup
};

class Count
{
    use Caller, TLimit, TWhere, TOrder, TGroup;
}
