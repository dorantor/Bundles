<?php

namespace PHPixie\Tests\Bundles\Bundle\Processor;

/**
 * @coversDefaultClass \PHPixie\Bundles\Bundle\Processor\Dispatcher
 */
class DispatcherTest extends \PHPixie\Tests\Processors\Processor\Dispatcher\BuilderTest
{
    protected $builder;
    
    protected function setUp()
    {
        $this->builder = $this->getBuilder();
    }
    
    /**
     * @covers ::__construct
     * @covers \PHPixie\Bundles\Bundle\Processor\Dispatcher::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        $this->dispatcherMock(array(
            'getProcessorNameFor'
        ));
    }
    
    protected function getBuilder()
    {
        return $this->quickMock('\PHPixie\Bundles\Bundle\Builder');
    }
    
    protected function dispatcherMock($methods = array())
    {
        return $this->getMock(
            '\PHPixie\Bundles\Bundle\Processor\Dispatcher',
            $methods,
            array($this->builder)
        );
    }
}