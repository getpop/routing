<?php
namespace PoP\Routing;
use PoP\Hooks\Facades\HooksAPIFacade;

class RouteProvider {

    private static $routes;

    public static function getRoutes() {

        if (is_null(self::$routes)) {
            self::$routes = array_filter(
                (array)HooksAPIFacade::getInstance()->applyFilters(
                    'routes',
                    []
                )
            );
        }

        return self::$routes;
    }
}
