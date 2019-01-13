<?php


namespace Deployee\Components\Plugins\Locator;

use Deployee\Components\Plugins\PluginInterface;

trait IsPluginTrait
{
    /**
     * @param string $expectedClass
     * @return bool
     */
    private function isPlugin(string $expectedClass): bool
    {
        return class_exists($expectedClass)
            && in_array(PluginInterface::class, class_implements($expectedClass), false);
    }
}
