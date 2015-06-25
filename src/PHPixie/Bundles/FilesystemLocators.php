<?php

namespace PHPixie\Bundles;

abstract class FilesystemLocators implements \PHPixie\Filesystem\Locators\Registry
{
    protected $bundleRegistry;
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function get($name)
    {
        $path = explode('.', $name, 2);
        
        $bundle  = $this->bundleRegistry->get($path[0]);
        $locator = $this->getBundleLocator($bundle);
        
        if(count($path) > 1) {
            if(!($locator instanceof \PHPixie\Filesystem\Locators\Registry)) {
                throw new \PHPixie\Bundles\Exception("Filesystem locator in '{$path[0]}' is not a bundleRegistry");
            }
            
            $locator = $locator->get($path[1]);
        }
        
        return $locator;
    }
    
    abstract protected function getBundleLocator($bundle);
}