<?php


namespace Deployee\Components\Plugins;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use UnitTestPlugins\AwesomeTest\AwesomeTestPlugin;
use UnitTestPlugins\GreatTest\GreatTestPlugin;
use UnitTestPlugins\GreatTest\TestService;
use UnitTestPlugins\SuperTest\SuperTestPlugin;

class PluginLoaderTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testLoadPlugins()
    {
        $container = new ContainerBuilder();
        $loader = new PluginLoader($container);
        $plugins = $loader->loadPlugins();

        $pluginArrayKeys = array_keys($plugins->getArrayCopy());
        $this->assertContains(GreatTestPlugin::class, $pluginArrayKeys);
        $this->assertInstanceOf(GreatTestPlugin::class, $plugins[GreatTestPlugin::class]);
        $this->assertContains(AwesomeTestPlugin::class, $pluginArrayKeys);
        $this->assertInstanceOf(AwesomeTestPlugin::class, $plugins[AwesomeTestPlugin::class]);
        $this->assertContains(SuperTestPlugin::class, $pluginArrayKeys);
        $this->assertInstanceOf(SuperTestPlugin::class, $plugins[SuperTestPlugin::class]);

        // test instanciation of services from services.yaml
        $this->assertInstanceOf(TestService::class, $container->get(TestService::class));

        // test overwriting parameters in services.yaml
        $this->assertSame('bar', $container->getParameter('bar'));
    }
}