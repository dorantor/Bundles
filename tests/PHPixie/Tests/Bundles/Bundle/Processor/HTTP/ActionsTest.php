<?php

namespace PHPixie\Tests\Bundles\Bundle\Processor\HTTP;

/**
 * @coversDefaultClass \PHPixie\Bundles\Bundle\Processor\HTTP\Actions
 */
class HTTPTest extends \PHPixie\Tests\Processors\Processor\ActionsTest
{
    protected $parameterName = 'action';
    
    /**
     * @covers ::isProcessable
     * @covers ::process
     * @covers ::<protected>
     */
    public function testActionName()
    {
        $processorMock = $this->processorMock(array(
            'pixieAction'
        ));
        
        $request = $this->getValue();
        
        $attributes = $this->quickMock('\PHPixie\Slice\Data');
        $this->method($attributes, 'get', 'pixie', array($this->parameterName));
        
        $this->method($request, 'attributes', $attributes, array());
        
        $this->assertSame(true, $processorMock->isProcessable($request));
        
        $result = new \stdClass();
        $this->method($processorMock, 'pixieAction', $result, array($request));
        $this->assertSame($result, $processorMock->process($request));
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function processorMock($methods = array())
    {
        return $this->quickMock('\PHPixie\Bundles\Bundle\Processor\HTTP\Actions', $methods);
    }
}