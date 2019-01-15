<?php


namespace Deployee\Components\Plugins;


use Deployee\Components\Container\Container;
use Deployee\Components\Dependency\ContainerResolver;
use PHPUnit\Framework\TestCase;
use UnitTestPlugins\AwesomeTest\AwesomeTestPlugin;
use UnitTestPlugins\GreatTest\GreatTestPlugin;
use UnitTestPlugins\SuperTest\SuperTestPlugin;

class PluginLoaderTest extends TestCase
{
    public function testLoadPlugins()
    {
        $resolver = new ContainerResolver(new Container());
        $loader = new PluginLoader($resolver);
        $plugins = $loader->loadPlugins();

        $this->assertContains(GreatTestPlugin::class, array_keys($plugins));
        $this->assertInstanceOf(GreatTestPlugin::class, $plugins[GreatTestPlugin::class]);
        $this->assertContains(AwesomeTestPlugin::class, array_keys($plugins));
        $this->assertInstanceOf(AwesomeTestPlugin::class, $plugins[AwesomeTestPlugin::class]);
        $this->assertContains(SuperTestPlugin::class, array_keys($plugins));
        $this->assertInstanceOf(SuperTestPlugin::class, $plugins[SuperTestPlugin::class]);
    }
}