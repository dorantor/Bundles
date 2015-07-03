<?php

namespace PHPixie\Bundles;

abstract class FilesystemLocators implements \PHPixie\Filesystem\Locators\Registry
{
    protected $bundleRegistry;
    protected $locators = array();
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function get($name)
    {
        $path = explode(':', $name, 2);
        $locator = $this->bundleLocator($path[0], true);
        
        if($locator === null) {
            return null;
        }
        
        if(count($path) === 1) {
            return $locator;
        }
        
        if($locator instanceof \PHPixie\Filesystem\Locators\Registry) {
            return $locator->get($path[1]);
        }
        
        if(!$isRequired) {
            return null;
        }
                
        throw new \PHPixie\Bundles\Exception(
            "Filesystem locator in '{$path[0]}' is not a bundleRegistry"
        );
    }
    
    public function bundleLocator($name, $isRequired)
    {
        if(!array_key_exists($name, $this->locators)) {
            $locator = null;
            $bundle = $this->bundleRegistry->get($path[0], $isRequired);
            if($bundle !== null) {
                $locator = $this->getBundleLocator($bundle, $isRequired);
            }
            
            $this->locators[$name] = $locator;
        }
        
        return $this->locators[$name];
    }
    
    abstract protected function getBundleLocator($bundle);
}