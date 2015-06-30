<?php

namespace PHPixie\Bundles\Bundle\Processor\HTTP;

abstract class Dispatcher extends \PHPixie\Bundles\Bundle\Processor\Dispatcher
{
    protected $parameterName = 'processor';
    
    protected function getProcessorNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get($this->parameterName);
    }
}