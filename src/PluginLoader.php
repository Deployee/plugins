<?php


namespace Deployee\Components\Plugins;

use Deployee\Components\Container\ContainerInterface;
use Deployee\Components\Plugins\Locator\PluginLocator;

class PluginLoader
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var PluginLocator
     */
    private $locator;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->locator = new PluginLocator();
    }

    /**
     * @return array
     */
    public function loadPlugins(): array
    {
        $list = [];
        foreach($this->locator->locatePlugins() as $pluginClass){
            $list[$pluginClass] = new $pluginClass;
        }

        array_walk($list, function(PluginInterface $plugin){
            $plugin->boot($this->container);
        });

        array_walk($list, function(PluginInterface $plugin){
            $plugin->configure();
        });

        return $list;
    }
}