<?php


namespace Deployee\Components\Plugins;

use Symfony\Component\DependencyInjection\ContainerBuilder;

interface PluginInterface
{
    public function boot(ContainerBuilder $container);
}