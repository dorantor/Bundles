<?php

namespace PHPixie\Bundles;

class Builder
{
    protected $bundleRegistry;
    protected $instances = array();
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function httpDispatcher()
    {
        return $this->instance('httpDispatcher');
    }
    
    public function filesystemLocatorRegistry()
    {
        return $this->instance('filesystemLocatorRegistry');
    }
    
    public function routeResolverRegistry()
    {
        return $this->instance('routeResolverRegistry');
    }
    
    public function ormWrappers()
    {
        return $this->instance('ormWrappers');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildHttpDispatcher()
    {
        return new Dispatcher\HTTP($this->bundleRegistry);
    }
    
    protected function buildFilesystemLocatorRegistry()
    {
        return new Filesystem\LocatorRegistry($this->bundleRegistry);
    }
    
    protected function buildORMWrappers()
    {
        return new ORM\Wrappers($this->bundleRegistry);
    }
    
    protected function buildRouteResolverRegistry()
    {
        return new Route\ResolverRegistry($this->bundleRegistry);
    }
}