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

        $this->assertContains(GreatTestPlugin::class, array_keys($plugins));
        $this->assertInstanceOf(GreatTestPlugin::class, $plugins[GreatTestPlugin::class]);
        $this->assertContains(AwesomeTestPlugin::class, array_keys($plugins));
        $this->assertInstanceOf(AwesomeTestPlugin::class, $plugins[AwesomeTestPlugin::class]);
        $this->assertContains(SuperTestPlugin::class, array_keys($plugins));
        $this->assertInstanceOf(SuperTestPlugin::class, $plugins[SuperTestPlugin::class]);

        // test instanciation of services from services.yaml
        $this->assertInstanceOf(TestService::class, $container->get(TestService::class));

        // test overwriting parameters in services.yaml
        $this->assertSame('bar', $container->getParameter('bar'));

        // test autowiring of ::configure method
        /* @var SuperTestPlugin $superTestPlugin */
        $superTestPlugin = $plugins[SuperTestPlugin::class];
        $superTestPlugin->getTestService();
    }
}