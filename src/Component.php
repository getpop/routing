<?php

declare(strict_types=1);

namespace PoP\Routing;

use PoP\BasicService\Component\AbstractComponent;

/**
 * Initialize component
 */
class Component extends AbstractComponent
{
    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public function getDependedComponentClasses(): array
    {
        return [
            \PoP\BasicService\Component::class,
            \PoP\Definitions\Component::class,
        ];
    }
}
