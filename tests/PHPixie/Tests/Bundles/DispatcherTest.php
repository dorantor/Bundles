<?php

namespace PHPixie\Tests\Bundles;

/**
 * @coversDefaultClass \PHPixie\Bundles\Dispatcher
 */
abstract class DispatcherTest extends \PHPixie\Test\Testcase
{
    protected $bundleRegistry;
    
    protected $dispatcher;
    
    public function setUp()
    {
        $this->bundleRegistry = $this->quickMock('\PHPixie\Bundles\Registry');
        
        $this->dispatcher = $this->dispatcher();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::hasProcessorFor
     * @covers ::<protected>
     */
    public function testHasProcessorFor()
    {
        foreach(array(true, false) as $hasProcessor) {
            $value = $this->getValue();
            $dispatcher = $this->prepareGetDispatcherFor($value);
            $this->method($dispatcher, 'hasProcessorFor', $hasProcessor, array($value), 0);
            $this->assertSame($hasProcessor, $this->dispatcher->hasProcessorFor($value));
        }
    }
    
    /**
     * @covers ::getProcessorFor
     * @covers ::<protected>
     */
    public function testGetProcessorFor()
    {
        $value = $this->getValue();
        $dispatcher = $this->prepareGetDispatcherFor($value);
        
        $processor = $this->getProcessor();
        $this->method($dispatcher, 'getProcessorFor', $processor, array($value), 0);
        $this->assertSame($processor, $this->dispatcher->getProcessorFor($value));
    }
    
    protected function getProcessor()
    {
        return $this->quickMock('\PHPixie\Processors\Processor');
    }
    
    protected function getDispatcher()
    {
        return $this->quickMock('\PHPixie\Processors\Dispatcher');
    }
    
    abstract protected function prepareGetDispatcherFor($value);
    abstract protected function getValue();
    
    abstract protected function dispatcher();
}   