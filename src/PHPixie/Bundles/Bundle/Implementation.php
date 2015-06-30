<?php

namespace PHPixie\Bundle\Bundle;

abstract class Implementation
{
    protected $builder;
    
    public function __construct($frameworkBuilder)
    {
        $this->builder = $this->buildBuilder($frameworkBuilder);
    }
    
    protected function buildBuilder()
    {
    
    }
}