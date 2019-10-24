<?php
namespace PoP\Routing;

class Routes extends AbstractRoutes {

    public static $MAIN;
    protected static function getRouteNameAndVariableRefs() {
        return [
            'main' => self::$MAIN,
        ];
    }
}
