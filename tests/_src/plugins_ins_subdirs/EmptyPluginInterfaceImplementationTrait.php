<?php


namespace UnitTestPlugins;

use Symfony\Component\DependencyInjection\ContainerBuilder;

trait EmptyPluginInterfaceImplementationTrait
{
    public function boot(ContainerBuilder $container)
    {

    }
}