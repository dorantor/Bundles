<?php

namespace PHPixie\Bundles;

class AuthRepositories implements \PHPixie\Auth\Repositories\Registry
{
    protected $bundleRegistry = array();
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function repository($name)
    {
        $split = explode('.', $name, 2);
        list($bundleName, $name) = $split;
        
        $bundle = $this->bundleRegistry->get($bundleName);
        
        if($bundle instanceof Bundle\Provides\AuthRepositories) {
            $authRepositories = $bundle->authRepositories();    
            if($authRepositories !== null) {
                return $authRepositories->repository($name);
            }
        }
        
        throw new \PHPixie\Bundles\Exception("Bundle '$bundleName' does not provide auth repositories");
    }
}