<?php

namespace PHPixie\Tests\Bundles\Route;

/**
 * @coversDefaultClass \PHPixie\Bundles\Route\ResolverRegistry
 */
class ResolverRegistryTest extends \PHPixie\Test\Testcase
{
    protected $bundleRegistry;
    
    protected $resolverRegistry;
    
    public function setUp()
    {
        $this->bundleRegistry = $this->quickMock('\PHPixie\Bundles\Registry');
        
        $this->resolverRegistry = new \PHPixie\Bundles\Route\ResolverRegistry(
            $this->bundleRegistry
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::get
     * @covers ::<protected>
     */
    public function testGet()
    {
        $resolverRegistry = $this->resolverRegistry;
        
        $this->prepareGetTest('pixie', false);
        $this->assertException(function() use($resolverRegistry) {
            $resolverRegistry->get('pixie');
        }, '\PHPixie\Bundles\Exception');
        
        $resolver = $this->prepareGetTest('pixie', true);
        $this->assertSame($resolver, $resolverRegistry->get('pixie'));
        
        $this->prepareGetTest('pixie.trixie', true, true, false);
        $this->assertException(function() use($resolverRegistry) {
            $resolverRegistry->get('pixie.trixie');
        }, '\PHPixie\Bundles\Exception');
        
        $resolver = $this->prepareGetTest('pixie.trixie', true, true, true);
        $this->assertSame($resolver, $resolverRegistry->get('pixie.trixie'));
    }
    
    protected function prepareGetTest($name, $providesResolver = false, $nested = false, $isRegistry = false)
    {
        if($providesResolver) {
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle\Provides\RouteResolver');
        }else{
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle');
        }
        
        $name = explode('.', $name, 2);
        $this->method($this->bundleRegistry, 'get', $bundle, array($name[0]), 0);
        
        if(!$providesResolver) {
            return;
        }
        
        if($isRegistry) {
            $resolver = $this->quickMock('\PHPixie\Route\Resolvers\Registry');
        }else{
            $resolver = $this->quickMock('\PHPixie\Route\Resolvers\Resolver');
        }
            
        $this->method($bundle, 'filesystemResolver', $resolver, array(), 0);
        
        if($isRegistry) {
            $nestedResolver = $this->quickMock('\PHPixie\Route\Resolvers\Resolver');
            $this->method($resolver, 'get', $nestedResolver, array($name[1]), 0);
            $resolver = $nestedResolver;
        }
        
        return $resolver;
    }
}