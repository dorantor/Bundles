<?php

namespace PHPixie\Bundles;

abstract class Dispatcher implements \PHPixie\Processors\Dispatcher
{
    protected $bundleRegistry;
    
    public function __construct($bundleRegistry)
    {
        $this->bundleRegistry = $bundleRegistry;
    }
    
    public function hasProcessorFor($value)
    {
        $dispatcher = $this->getDispatcherFor($value);
        return $dispatcher->hasProcessorFor($value);
    }
    
    public function getProcessorFor($value)
    {
        $dispatcher = $this->getDispatcherFor($value);
        return $dispatcher->getProcessorFor($value);
    }
    
    abstract protected function getDispatcherFor($httpRequest);
}