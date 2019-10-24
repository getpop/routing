<?php
namespace PoP\Routing;
use PoP\Hooks\Facades\HooksAPIFacade;

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
    	return Natures::STANDARD;
    }

    public function getCurrentRoute()
    {
    	$nature = $this->getCurrentNature();

    	// If it is a ROUTE, then the URL path is already the route
        if ($nature == Natures::STANDARD) {
            $route = \PoP\ComponentModel\Utils::getURLPath();
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
            '\PoP\ComponentModel\Engine_Vars:route',
            $route,
            $nature
        );
    }
}
