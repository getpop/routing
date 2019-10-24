<?php
namespace PoP\Routing;

interface RoutingManagerInterface
{
    public function getRoutes();
    public function getCurrentNature();
    public function getCurrentRoute();
}
