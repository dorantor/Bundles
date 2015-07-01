<?php

namespace PHPixie\Bundles;

abstract class FilesystemLocators implements \PHPixie\Filesystem\Locators\Registry
{
    protected $bundleRegistry;
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function get($name, $isRequired = true)
    {
        $path = explode('.', $name, 2);
        
        $bundle  = $this->bundleRegistry->get($path[0], $isRequired);
        
        if($bundle === null) {
            return null;
        }
        
        $locator = $this->getBundleLocator($bundle, $isRequired);
        
        if($locator === null) {
            return null;
        }
        
        if(count($path) > 1) {
            if(!($locator instanceof \PHPixie\Filesystem\Locators\Registry)) {
                throw new \PHPixie\Bundles\Exception(
                    "Filesystem locator in '{$path[0]}' is not a bundleRegistry"
                );
            }
            
            $locator = $locator->get($path[1]);
        }
        
        return $locator;
    }
    
    abstract protected function getBundleLocator($bundle);
}