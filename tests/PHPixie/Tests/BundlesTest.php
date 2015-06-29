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
        $this->method($this->builder, 'registry', $this->bundleRegistry, array());
        
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
     * @covers ::registry
     * @covers ::<protected>
     */
    public function testRegistry()
    {
        $this->assertSame($this->bundleRegistry, $this->bundles->registry());
    }
    
    /**
     * @covers ::bundles
     * @covers ::<protected>
     */
    public function testBundles()
    {
        $bundles = array(
            'pixie' => $this->getBundle()
        );
        
        $this->method($this->bundleRegistry, 'bundles', $bundles, array(), 0);
        $this->assertSame($bundles, $this->bundles->bundles());
    }
    
    /**
     * @covers ::get
     * @covers ::<protected>
     */
    public function testGet()
    {
        $bundle = $this->getBundle();
        
        $this->method($this->bundleRegistry, 'get', $bundle, array('pixie'), 0);
        $this->assertSame($bundle, $this->bundles->get('pixie'));
    }
    
    /**
     * @covers ::httpProcessors
     * @covers ::<protected>
     */
    public function testHttpProcessors()
    {
        $this->instanceTest('httpProcessors', '\PHPixie\Bundles\Processors\HTTP');
    }
    
    /**
     * @covers ::templateLocators
     * @covers ::<protected>
     */
    public function testTemplateLocators()
    {
        $this->instanceTest('templateLocators', '\PHPixie\Bundles\FilesystemLocators\Template');
    }
    
    /**
     * @covers ::routeResolvers
     * @covers ::<protected>
     */
    public function testRouteResolvers()
    {
        $this->instanceTest('routeResolvers', '\PHPixie\Bundles\RouteResolvers');
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
    
    protected function getBundle()
    {
        $this->quickMock('\PHPixie\Bundles\Bundle');
    }
}