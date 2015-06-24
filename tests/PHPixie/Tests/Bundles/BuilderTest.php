<?php

namespace PHPixie\Tests\Bundles;

/**
 * @coversDefaultClass PHPixie\Bundles\Builder
 */
class BuilderTest extends \PHPixie\Test\Testcase
{
    protected $bundleRegistry;
    protected $builder;
    
    public function setUp()
    {
        $this->bundleRegistry = $this->quickMock('\PHPixie\Bundles\Registry');
        $this->builder  = new \PHPixie\Bundles\Builder($this->bundleRegistry);
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::registry
     * @covers ::<protected>
     */
    public function testRegistry()
    {
        $this->assertSame($this->bundleRegistry, $this->builder->registry());
    }
    
    /**
     * @covers ::httpDispatcher
     * @covers ::<protected>
     */
    public function testHttpDispatcher()
    {
        $httpDispatcher = $this->builder->httpDispatcher();
        $this->assertInstance($httpDispatcher, '\PHPixie\Bundles\Dispatcher\HTTP', array(
            'bundleRegistry' => $this->bundleRegistry
        ));
        
        $this->assertSame($httpDispatcher, $this->builder->httpDispatcher());
    }
    
    /**
     * @covers ::filesystemLocators
     * @covers ::<protected>
     */
    public function testFilesystemLocators()
    {
        $locators = $this->builder->filesystemLocators();
        $this->assertInstance($locators, '\PHPixie\Bundles\FilesystemLocators', array(
            'bundleRegistry' => $this->bundleRegistry
        ));
        
        $this->assertSame($locators, $this->builder->filesystemLocators());
    }
    
    /**
     * @covers ::routeResolvers
     * @covers ::<protected>
     */
    public function testRouteResolvers()
    {
        $resolvers = $this->builder->routeResolvers();
        $this->assertInstance($resolvers, '\PHPixie\Bundles\RouteResolvers', array(
            'bundleRegistry' => $this->bundleRegistry
        ));
        
        $this->assertSame($resolvers, $this->builder->routeResolvers());
    }
    
    /**
     * @covers ::ormWrappers
     * @covers ::<protected>
     */
    public function testOrmWrappers()
    {
        $this->method($this->bundleRegistry, 'bundles', array(), array(), 0);
        
        $ormWrappers = $this->builder->ormWrappers();
        $this->assertInstance($ormWrappers, '\PHPixie\Bundles\ORMWrappers');
        
        $this->assertSame($ormWrappers, $this->builder->ormWrappers());
    }
}