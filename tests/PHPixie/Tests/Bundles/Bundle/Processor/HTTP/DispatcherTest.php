<?php

namespace PHPixie\Tests\Bundles\Bundle\Processor\HTTP;

/**
 * @coversDefaultClass \PHPixie\Bundles\Bundle\Processor\HTTP\Dispatcher
 */
class DispatcherTest extends \PHPixie\Tests\Bundles\Bundle\Processor\DispatcherTest
{
    protected $parameterName = 'processor';
    
    /**
     * @covers ::<protected>
     */
    public function testGetProcessorNameFor()
    {
        $dispatcherMock = $this->dispatcherMock(array(
            'buildPixieProcessor'
        ));
        
        $processor = $this->getProcessor();
        $this->method($dispatcherMock, 'buildPixieProcessor', $processor, array(), 'once');
        
        $request = $this->getValue();
        
        $attributes = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($attributes, 'get', 'pixie', array($this->parameterName));
        
        $this->method($request, 'attributes', $attributes, array());
        
        $this->assertSame(true, $dispatcherMock->isProcessable($request));
        
        $result = new \stdClass();
        $this->method($processor, 'process', $result, array($request));
        $this->assertSame($result, $dispatcherMock->process($request));
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function dispatcherMock($methods = array())
    {
        return $this->getMock(
            '\PHPixie\Bundles\Bundle\Processor\HTTP\Dispatcher',
            $methods,
            array($this->builder)
        );
    }
}