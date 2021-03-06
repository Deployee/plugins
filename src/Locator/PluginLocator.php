<?php


namespace Deployee\Components\Plugins\Locator;


use Composer\Autoload\ClassLoader;

class PluginLocator
{
    /**
     * @var LocatorStrategyInterface[]
     */
    private $strategies;

    public function __construct()
    {
        /* @var ClassLoader $classLoader */
        $classLoader = require('vendor/autoload.php');
        $this->strategies = [
            new ComposerNamespaceLocatorStrategy($classLoader),
            new ComposerDirectoryNamespaceLocatorStrategy($classLoader)
        ];
    }

    /**
     * @return array
     */
    public function locatePlugins(): array
    {
        $list = [[]];

        foreach($this->strategies as $strategy){
            $list[] = $strategy->locate();

        }

        return array_merge(...$list);
    }
}