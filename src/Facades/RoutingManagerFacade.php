<?php
namespace PoP\Routing\Facades;

use PoP\Routing\RoutingManagerInterface;
use PoP\Root\Container\ContainerBuilderFactory;

class RoutingManagerFacade
{
    public static function getInstance(): RoutingManagerInterface
    {
        return ContainerBuilderFactory::getInstance()->get('routing_manager');
    }
}
