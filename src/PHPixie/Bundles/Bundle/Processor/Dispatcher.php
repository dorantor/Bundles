<?php

namespace PHPixie\Bundles\Bundle\Processor;

abstract class Dispatcher extends \PHPixie\Processors\Processor\Dispatcher\Builder
{
    protected $builder;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
}