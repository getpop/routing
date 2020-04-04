<?php
namespace PoP\Routing;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\ComponentModel\Misc\RequestUtils;

abstract class AbstractRoutingManager implements RoutingManagerInterface
{
    private $routes;

    public function getRoutes()
    {
        if (is_null($this->routes)) {
            $this->routes = array_filter(
                (array)HooksAPIFacade::getInstance()->applyFilters(
                    'routes',
                    []
                )
            );
        }
        return $this->routes;
    }

    public function getCurrentNature()
    {
    	// By default, everything is a standard route
    	return RouteNatures::STANDARD;
    }

    public function getCurrentRoute()
    {
    	$nature = $this->getCurrentNature();

    	// If it is a ROUTE, then the URL path is already the route
        if ($nature == RouteNatures::STANDARD) {
            $route = RequestUtils::getURLPath();
        } else {

            // If having set URL param "route", then use it
            if (isset($_REQUEST[GD_URLPARAM_ROUTE])) {
                $route = trim(strtolower($_REQUEST[GD_URLPARAM_ROUTE]), '/');
            } else {
                // If not, use the "main" route
                $route = Routes::$MAIN;
            }
        }

        // Allow to change it
        return HooksAPIFacade::getInstance()->applyFilters(
            'ApplicationState:route',
            $route,
            $nature
        );
    }
}
