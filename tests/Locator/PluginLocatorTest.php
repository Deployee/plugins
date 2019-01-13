<?php


namespace Deployee\Components\Plugins;


use Deployee\Components\Plugins\Locator\PluginLocator;
use Deployee\Components\Plugins\TestPlugin\TestPluginPlugin;
use PHPUnit\Framework\TestCase;

class PluginLocatorTest extends TestCase
{
    public function testLocatePlugins()
    {
        $locator = new PluginLocator();
        $plugins = $locator->locatePlugins();

        $this->assertTrue(is_array($plugins));
        $this->assertContains(TestPluginPlugin::class, $plugins, var_export($plugins));
    }
}