<?php

namespace PHPixie\Tests;

/**
 * @coversDefaultClass \PHPixie\Bundles
 */
class BundlesTest extends \PHPixie\Test\Testcase
{
    protected $bundleRegistry;
    
    protected $bundles;
    
    protected $builder;
    
    public function setUp()
    {
        $this->bundleRegistry = $this->quickMock('\PHPixie\Bundles\Registry');
        
        $this->bundles = $this->getMockBuilder('\PHPixie\Bundles')
            ->setMethods(array('buildBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->builder = $this->quickMock('\PHPixie\Bundles\Builder');
        $this->method($this->bundles, 'buildBuilder', $this->builder, array(
            $this->bundleRegistry
        ), 0);
        
        $this->bundles->__construct(
            $this->bundleRegistry
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructor()
    {
        
    }
    
    /**
     * @covers ::buildBuilder
     * @covers ::<protected>
     */
    public function testBuildBuilder()
    {
        $this->bundles = new \PHPixie\Bundles(
            $this->bundleRegistry
        );
        
        $builder = $this->bundles->builder();
        $this->assertInstance($builder, '\PHPixie\Bundles\Builder', array(
            'bundleRegistry' => $this->bundleRegistry
        ));
    }
    
    /**
     * @covers ::builder
     * @covers ::<protected>
     */
    public function testBuilder()
    {
        $this->assertSame($this->builder, $this->bundles->builder());
    }
    
    /**
     * @covers ::httpDispatcher
     * @covers ::<protected>
     */
    public function testHttpDispatcher()
    {
        $this->instanceTest('httpDispatcher', '\PHPixie\Bundles\Dispatcher\HTTP');
    }
    
    /**
     * @covers ::filesystemLocatorRegistry
     * @covers ::<protected>
     */
    public function testFilesystemLocatorRegistry()
    {
        $this->instanceTest('filesystemLocatorRegistry', '\PHPixie\Bundles\Filesystem\LocatorRegistry');
    }
    
    /**
     * @covers ::routeResolverRegistry
     * @covers ::<protected>
     */
    public function testRouteResolverRegistry()
    {
        $this->instanceTest('routeResolverRegistry', '\PHPixie\Bundles\Route\ResolverRegistry');
    }
    
    /**
     * @covers ::ormWrappers
     * @covers ::<protected>
     */
    public function testOrmWrappers()
    {
        $this->instanceTest('ormWrappers', '\PHPixie\Bundles\ORM\Wrappers');
    }
    
    protected function instanceTest($method, $class)
    {
        $mock = $this->quickMock($class);
        $this->method($this->builder, $method, $mock, array(), 0);
        $this->assertSame($mock, $this->bundles->$method());
    }
}