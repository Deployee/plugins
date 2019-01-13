<?php


namespace Deployee\Components\Plugins;


use Deployee\Components\Plugins\Locator\PluginLocator;
use PHPUnit\Framework\TestCase;
use UnitTestPlugins\AwesomeTest\AwesomeTestPlugin;
use UnitTestPlugins\SuperTest\SuperTestPlugin;

class PluginLocatorTest extends TestCase
{
    public function testLocatePlugins()
    {
        $locator = new PluginLocator();
        $plugins = $locator->locatePlugins();

        $this->assertContains(SuperTestPlugin::class, $plugins);
        $this->assertContains(AwesomeTestPlugin::class, $plugins);
    }
}