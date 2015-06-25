<?php

namespace PHPixie;

class Bundles
{
    protected $builder;
    
    public function __construct($bundleRegistry)
    {
        $this->builder = $this->buildBuilder($bundleRegistry);
    }
    
    public function builder()
    {
        return $this->builder;
    }
    
    public function registry()
    {
        return $this->builder->registry();
    }
    
    public function bundles()
    {
        return $this->builder->registry()->bundles();
    }
    
    public function get($name)
    {
        return $this->builder->registry()->get($name);
    }
    
    public function httpDispatcher()
    {
        return $this->builder->httpDispatcher();
    }
    
    public function templateLocators()
    {
        return $this->builder->templateLocators();
    }
    
    public function routeResolvers()
    {
        return $this->builder->routeResolvers();
    }
    
    public function ormWrappers()
    {
        return $this->builder->ormWrappers();
    }
    
    protected function buildBuilder($slice)
    {
        return new Bundles\Builder($slice);
    }
}