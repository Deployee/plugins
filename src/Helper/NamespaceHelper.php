<?php


namespace Deployee\Components\Plugins\Helper;


class NamespaceHelper
{
    public function basename(string $namespace): string
    {
        $namespace = $this->realpath($namespace);
        return substr($namespace, strrpos($namespace, '\\')+1);
    }

    public function realpath(string $namespace): string
    {
        return substr($namespace, -1) === '\\' ? substr($namespace, 0, -1) : $namespace;
    }
}