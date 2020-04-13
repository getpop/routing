<?php

declare(strict_types=1);

namespace PoP\Routing;

class Routes
{

    use RoutesTrait;

    public static $MAIN;
    protected static function getRouteNameAndVariableRefs()
    {
        return [
            'main' => &self::$MAIN,
        ];
    }
}
