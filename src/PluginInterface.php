<?php


namespace Deployee\Components\Plugins;

use Deployee\Components\Container\ContainerInterface;

interface PluginInterface
{
    public function boot(ContainerInterface $container);

    public function configure();
}