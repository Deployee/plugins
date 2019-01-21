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

        foreach($list as $plugin){
            $this->configurePlugin($plugin);
        }

        return $list;
    }

    /**
     * @param PluginInterface $plugin
     * @throws \Exception
     */
    private function configurePlugin(PluginInterface $plugin)
    {
        try {
            $method = new \ReflectionMethod(get_class($plugin), 'configure');
        }
        catch(\ReflectionException $e){
            return;
        }

        $args = [];
        foreach ($method->getParameters() as $parameter) {
            if($parameter->getType() === null){
                throw new \InvalidArgumentException(sprintf(
                    'Parameter %s of %s must have a service type hint',
                    $parameter->getName(),
                    get_class($plugin)
                ));
            }

            $args[] = $this->container->get($parameter->getType()->getName());
        }

        $method->invoke($plugin, ...$args);
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
        $expectedServiceFile = $pluginDir . '/config/services.yaml';

        if(is_file($expectedServiceFile)){
            $this->loadPluginServices($expectedServiceFile);
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