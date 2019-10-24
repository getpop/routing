<?php
namespace PoP\Routing;

use PoP\Routing\Routes\DefinitionGroups;
use PoP\Definitions\Facades\DefinitionManagerFacade;

abstract class AbstractRoutes {

    /**
     * Construct all the routes, each of them having a unique definition (if the same "name" is used for 2 different routes, it throws an exception)
     */
    public static function init() {
        $definitionManager = DefinitionManagerFacade::getInstance();
        foreach (self::getRouteNameAndVariableRefs() as $route => &$var) {
            $var = $definitionManager->getUniqueDefinition($route, DefinitionGroups::ROUTES);
        }
    }
    protected static abstract function getRouteNameAndVariableRefs();
}
