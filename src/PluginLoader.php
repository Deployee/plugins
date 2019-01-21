<?php


namespace Deployee\Components\Plugins;

use Deployee\Components\Plugins\Locator\PluginLocator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PluginLoader
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var PluginLocator
     */
    private $locator;

    /**
     * @param ContainerBuilder $container
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
        $this->locator = new PluginLocator();
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function loadPlugins(): \ArrayObject
    {
        $list = new \ArrayObject();
        foreach($this->locator->locatePlugins() as $pluginClass){
            $list[$pluginClass] = $this->loadPlugin($pluginClass);
        }

        return $list;
    }

    /**
     * @param string $class
     * @return PluginInterface
     * @throws \Exception
     */
    private function loadPlugin(string $class): PluginInterface
    {
        $reflection = new \ReflectionClass($class);
        $pluginDir = dirname($reflection->getFileName());
        $expectedServiceFiles = [
            $pluginDir . '/config/services.yaml',
            $pluginDir . '/../config/services.yaml'
        ];

        foreach($expectedServiceFiles as $expectedServiceFile) {
            if (is_file($expectedServiceFile)) {
                $this->loadPluginServices($expectedServiceFile);
                break;
            }
        }

        /* @var PluginInterface $object */
        $object = $reflection->newInstance();

        $object->boot($this->container);

        return $object;
    }

    /**
     * @param string $serviceFile
     * @throws \Exception
     */
    private function loadPluginServices(string $serviceFile)
    {
        $loader = new YamlFileLoader($this->container, new FileLocator(dirname($serviceFile)));
        $loader->load(basename($serviceFile));
    }
}