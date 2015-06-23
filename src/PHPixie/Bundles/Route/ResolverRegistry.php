<?php

namespace PHPixie\Bundles\Route;

class ResolverRegistry implements \PHPixie\Route\Resolvers\Registry
{
    protected $bundleRegistry;
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function get($name)
    {
        $path = explode('.', $name, 2);
        
        $bundle = $this->bundleRegistry->get($path[0]);
        
        if(!($bundle instanceof \PHPixie\Bundles\Bundle\Provides\RouteResolver)) {
            throw new \PHPixie\Bundles\Exception("Bundle '{$path[0]}' does not provide a route resolver");
        }
        
        $resolver = $bundle->routeResolver();
        
        if(count($path) > 1) {
            if(!($resolver instanceof \PHPixie\Route\Resolvers\Registry)) {
                throw new \PHPixie\Bundles\Exception("Route resolver in '{$path[0]}' is not a registry");
            }
            
            $resolver = $resolver->get($path[1]);
        }
        
        return $resolver;
    }
}   