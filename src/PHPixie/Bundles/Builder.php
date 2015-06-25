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
    
    public function registry()
    {
        return $this->bundleRegistry;
    }
    
    public function httpDispatcher()
    {
        return $this->instance('httpDispatcher');
    }
    
    public function templateLocators()
    {
        return $this->instance('templateLocators');
    }
    
    public function routeResolvers()
    {
        return $this->instance('routeResolvers');
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
    
    protected function buildTemplateLocators()
    {
        return new FilesystemLocators\Template($this->bundleRegistry);
    }
    
    protected function buildRouteResolvers()
    {
        return new RouteResolvers($this->bundleRegistry);
    }
    
    protected function buildORMWrappers()
    {
        return new ORMWrappers($this->bundleRegistry);
    }
}