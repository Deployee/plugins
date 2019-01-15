<?php


namespace UnitTestPlugins;


use Deployee\Components\Container\ContainerInterface;

trait EmptyPluginInterfaceImplementationTrait
{
    public function boot(ContainerInterface $container)
    {

    }

    public function configure(ContainerInterface $container)
    {

    }
}