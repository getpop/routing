<?php

declare(strict_types=1);

namespace PoP\Routing;

use PoP\Hooks\Facades\HooksAPIFacade;
use PoP\Routing\RoutingUtils;

abstract class AbstractRoutingManager implements RoutingManagerInterface
{
    /**
     * @var string[]|null
     */
    private ?array $routes = null;

    public function getRoutes()
    {
        if (is_null($this->routes)) {
            $this->routes = array_filter(
                (array)HooksAPIFacade::getInstance()->applyFilters(
                    'routes',
                    []
                )
            );

            // // If there are partial endpoints, generate all the combinations of route + partial endpoint
            // // For instance, route = "posts", endpoint = "/api/rest", combined route = "posts/api/rest"
            // if ($partialEndpoints = array_filter(
            //     (array)HooksAPIFacade::getInstance()->applyFilters(
            //         'route-endpoints',
            //         []
            //     )
            // )) {
            //     // Attach the endpoints to each of the routes
            //     $routes = $this->routes;
            //     foreach ($routes as $route) {
            //         foreach ($partialEndpoints as $endpoint) {
            //             $this->routes[] = $route . '/' . trim($endpoint, '/');
            //         }
            //     }
            // }
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
            $route = RoutingUtils::getURLPath();
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
