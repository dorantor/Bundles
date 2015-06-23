<?php

namespace PHPixie\Bundles\Dispatcher;

class HTTP extends \PHPixie\Bundles\Dispatcher
{
    protected function getDispatcherFor($httpRequest)
    {
        $bundleName = $httpRequest->attributes()->getRequired('bundle');
        $bundle = $this->bundleRegistry->get($bundleName);
        
        if(!($bundle instanceof \PHPixie\Bundles\Bundle\Provides\HTTPDispatcher)) {
            throw new \PHPixie\Bundles\Exception("Bundle '$bundleName' does not provide a HTTP dispatcher");
        }
        
        return $bundle->httpDispatcher();
    }
}