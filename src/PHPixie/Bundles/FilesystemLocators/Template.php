<?php

namespace PHPixie\Bundles\FilesystemLocators;

class Template extends \PHPixie\Bundles\FilesystemLocators
{
    protected function getBundleLocator($bundle, $isRequired = true)
    {
        if($isRequired && !($bundle instanceof \PHPixie\Bundles\Bundle\Provides\TemplateLocator)) {
            $bundleName = $bundle->name();
            throw new \PHPixie\Bundles\Exception("Bundle '$bundleName' does not provide a template locator");
        }
        
        return $bundle->templateLocator();
    }
}