<?php


namespace Deployee\Components\Plugins\Locator;


use Composer\Autoload\ClassLoader;

class ComposerDirectoryNamespaceLocatorStrategy implements LocatorStrategyInterface
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

    /**
     * @return array
     */
    public function locate(): array
    {
        $list = [[]];

        foreach($this->classLoader->getPrefixesPsr4() as $namespace => $rootDirs){
            foreach($rootDirs as $rootDir){
                if(!is_dir($rootDir)){
                    trigger_error(sprintf('Composer directory %s does not exist', $rootDir), E_USER_WARNING);
                    continue;
                }

                $list[] = $this->locateInDirectory($namespace, $rootDir);
            }
        }

        return array_merge(...$list);
    }

    /**
     * @param string $rootNamespace
     * @param string $rootDir
     * @return array
     */
    private function locateInDirectory(string $rootNamespace, string $rootDir): array
    {
        $list = [];
        foreach(new \DirectoryIterator($rootDir) as $iterator){
            if($iterator->isFile() || $iterator->isDot()){
                continue;
            }

            $expectedClass = $rootNamespace . sprintf('%1$s\\%1$sPlugin', $iterator->getBasename());
            if($this->isPlugin($expectedClass)){

                $list[] = $expectedClass;
            }
        }

        return $list;
    }
}