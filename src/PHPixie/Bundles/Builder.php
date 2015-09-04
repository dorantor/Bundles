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
    
    public function httpProcessors()
    {
        return $this->instance('httpProcessors');
    }
    
    public function templateLocators()
    {
        return $this->instance('templateLocators');
    }
    
    public function routeResolvers()
    {
        return $this->instance('routeResolvers');
    }
    
    public function orm()
    {
        return $this->instance('orm');
    }
    
    public function authRepositories()
    {
        return $this->instance('authRepositories');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildHttpProcessors()
    {
        return new Processors\HTTP($this->bundleRegistry);
    }
    
    protected function buildTemplateLocators()
    {
        return new FilesystemLocators\Template($this->bundleRegistry);
    }
    
    protected function buildRouteResolvers()
    {
        return new RouteResolvers($this->bundleRegistry);
    }
    
    protected function buildOrm()
    {
        return new ORM($this->bundleRegistry);
    }
    
    protected function buildAuthRepositories()
    {
        return new AuthRepositories($this->bundleRegistry);
    }
}