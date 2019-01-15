<?php


namespace Deployee\Components\Plugins;

interface PluginInterface
{
    public function boot();

    public function run();
}