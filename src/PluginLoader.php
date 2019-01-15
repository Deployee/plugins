<?php


namespace Deployee\Components\Plugins;

use Deployee\Components\Dependency\ContainerResolver;
use Deployee\Components\Plugins\Locator\PluginLocator;

class PluginLoader
{
    /**
     * @var ContainerResolver
     */
    private $resolver;

    /**
     * @var PluginLocator
     */
    private $locator;

    /**
     * @param ContainerResolver $resolver
     */
    public function __construct(ContainerResolver $resolver)
    {
        $this->resolver = $resolver;
        $this->locator = new PluginLocator();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function loadPlugins(): array
    {
        $list = [];
        foreach($this->locator->locatePlugins() as $pluginClass){
            $list[$pluginClass] = $this->resolver->createInstance($pluginClass);
        }

        array_walk($list, function(PluginInterface $plugin){
            $plugin->boot();
        });

        return $list;
    }
}