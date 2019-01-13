<?php


namespace Deployee\Components\Plugins\Locator;


interface LocatorStrategyInterface
{
    /**
     * @return string[]
     */
    public function locate(): array;
}