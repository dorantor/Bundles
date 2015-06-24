<?php

namespace PHPixie\Tests\Bundles;

/**
 * @coversDefaultClass \PHPixie\Bundles\Dispatcher\HTTP
 */
class HTTPTest extends \PHPixie\Tests\Bundles\DispatcherTest
{
    
    /**
     * @covers ::hasProcessorFor
     * @covers ::<protected>
     */
    public function testInvalidBundle()
    {
        $value = $this->getValue();
        $this->prepareGetDispatcherFor($value, false);
        
        $dispatcher = $this->dispatcher;
        $this->assertException(function() use($dispatcher, $value) {
            $dispatcher->hasProcessorFor($value);
        }, '\PHPixie\Bundles\Exception');
    }
    
    protected function prepareGetDispatcherFor($httpRequest, $providesDispatcher = true)
    {
        $attributes = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($httpRequest, 'attributes', $attributes, array(), 0);
        
        $this->method($attributes, 'getRequired', 'pixie', array('bundle'), 0);
        
        if($providesDispatcher) {
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle\Provides\HTTPDispatcher');
        }else{
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle');
        }
        
        $this->method($this->bundleRegistry, 'get', $bundle, array('pixie'), 0);
        
        if(!$providesDispatcher) {
            return;
        }
        
        $dispatcher = $this->getDispatcher();
        $this->method($bundle, 'httpDispatcher', $dispatcher, array(), 0);
        
        return $dispatcher;
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function dispatcher()
    {
        return new \PHPixie\Bundles\Dispatcher\HTTP($this->bundleRegistry);
    }
}