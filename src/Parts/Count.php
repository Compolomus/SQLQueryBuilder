<?php

namespace Koenig\SQLQueryBuilder\Parts;

use Koenig\SQLQueryBuilder\System\Traits\{
    Caller,
    Limit,
    Where,
    Order,
    Group
};

class Count
{
    use Caller, Limit, Where, Order, Group;
}
