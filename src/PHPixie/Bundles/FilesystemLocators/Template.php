<?php

namespace PHPixie\Bundles\FilesystemLocators;

class Template extends \PHPixie\Bundles\FilesystemLocators
{
    protected function getBundleLocator($bundle, $isRequired = true)
    {
        if($bundle instanceof \PHPixie\Bundles\Bundle\Provides\TemplateLocator) {
            return $bundle->templateLocator();
        }
        
        if(!$isRequired) {
            return null;
        }
        
        $bundleName = $bundle->name();
        throw new \PHPixie\Bundles\Exception("Bundle '$bundleName' does not provide a template locator");
    }
}