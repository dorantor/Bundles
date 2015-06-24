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
     * @covers ::filesystemLocatorRegistry
     * @covers ::<protected>
     */
    public function testFilesystemLocatorRegistry()
    {
        $locatorRegistry = $this->builder->filesystemLocatorRegistry();
        $this->assertInstance($locatorRegistry, '\PHPixie\Bundles\Filesystem\LocatorRegistry', array(
            'bundleRegistry' => $this->bundleRegistry
        ));
        
        $this->assertSame($locatorRegistry, $this->builder->filesystemLocatorRegistry());
    }
    
    /**
     * @covers ::routeResolverRegistry
     * @covers ::<protected>
     */
    public function testRouteResolverRegistry()
    {
        $resolverRegistry = $this->builder->routeResolverRegistry();
        $this->assertInstance($resolverRegistry, '\PHPixie\Bundles\Route\ResolverRegistry', array(
            'bundleRegistry' => $this->bundleRegistry
        ));
        
        $this->assertSame($resolverRegistry, $this->builder->routeResolverRegistry());
    }
    
    /**
     * @covers ::ormWrappers
     * @covers ::<protected>
     */
    public function testOrmWrappers()
    {
        $this->method($this->bundleRegistry, 'bundles', array(), array(), 0);
        
        $ormWrappers = $this->builder->ormWrappers();
        $this->assertInstance($ormWrappers, '\PHPixie\Bundles\ORM\Wrappers');
        
        $this->assertSame($ormWrappers, $this->builder->ormWrappers());
    }
}