<?php


namespace Deployee\Components\Plugins\Locator;


use Composer\Autoload\ClassLoader;

class ComposerNamespaceLocatorStrategy implements LocatorStrategyInterface
{
    use IsPluginTrait;

    /**
     * @var ClassLoader
     */
    private $classLoader;

    /**
     * ComposerNamespaceLocatorStrategy constructor.
     * @param ClassLoader $classLoader
     */
    public function __construct(ClassLoader $classLoader)
    {
        $this->classLoader = $classLoader;
    }

    public function locate(): array
    {
        $list = [];
        foreach($this->classLoader->getPrefixesPsr4() as $namespace => $rootDirs){

            $namespaceParts = explode('\\', basename(substr($namespace, 0 ,-1)));
            $pluginName = $namespaceParts[count($namespaceParts)-1];

            $expectedClass = $namespace . sprintf(
                '%1$sPlugin',
                    $pluginName
            );

            if($this->isPlugin($expectedClass)){
                $list[] = $expectedClass;
            }
        }

        return $list;
    }
}