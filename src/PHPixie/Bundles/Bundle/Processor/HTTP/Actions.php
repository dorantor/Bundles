<?php

namespace PHPixie\Bundles\Bundle\Processor\HTTP;

abstract class Actions extends \PHPixie\Processors\Processor\Actions
{
    protected $parameterName = 'action';
    
    protected function getActionNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get($this->parameterName);
    }
}