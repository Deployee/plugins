<?php


namespace UnitTestPlugins\SuperTest;

use Deployee\Components\Plugins\PluginInterface;
use UnitTestPlugins\EmptyPluginInterfaceImplementationTrait;
use UnitTestPlugins\GreatTest\TestService;

class SuperTestPlugin implements PluginInterface
{
    use EmptyPluginInterfaceImplementationTrait;

    /**
     * @var TestService
     */
    private $testService;

    public function configure(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * @return TestService
     */
    public function getTestService(): TestService
    {
        return $this->testService;
    }
}