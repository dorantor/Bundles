<?php

namespace PHPixie\Tests\Bundles\Filesystem;

/**
 * @coversDefaultClass \PHPixie\Bundles\Filesystem\LocatorRegistry
 */
class LocatorRegistryTest extends \PHPixie\Test\Testcase
{
    protected $bundleRegistry;
    
    protected $locatorRegistry;
    
    public function setUp()
    {
        $this->bundleRegistry = $this->quickMock('\PHPixie\Bundles\Registry');
        
        $this->locatorRegistry = new \PHPixie\Bundles\Filesystem\LocatorRegistry(
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
        $locatorRegistry = $this->locatorRegistry;
        
        $this->prepareGetTest('pixie', false);
        $this->assertException(function() use($locatorRegistry) {
            $locatorRegistry->get('pixie');
        }, '\PHPixie\Bundles\Exception');
        
        $locator = $this->prepareGetTest('pixie', true);
        $this->assertSame($locator, $locatorRegistry->get('pixie'));
        
        $this->prepareGetTest('pixie.trixie', true, true, false);
        $this->assertException(function() use($locatorRegistry) {
            $locatorRegistry->get('pixie.trixie');
        }, '\PHPixie\Bundles\Exception');
        
        $locator = $this->prepareGetTest('pixie.trixie', true, true, true);
        $this->assertSame($locator, $locatorRegistry->get('pixie.trixie'));
    }
    
    protected function prepareGetTest($name, $providesLocator = false, $nested = false, $isRegistry = false)
    {
        if($providesLocator) {
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle\Provides\FilesystemLocator');
        }else{
            $bundle = $this->quickMock('\PHPixie\Bundles\Bundle');
        }
        
        $name = explode('.', $name, 2);
        $this->method($this->bundleRegistry, 'get', $bundle, array($name[0]), 0);
        
        if(!$providesLocator) {
            return;
        }
        
        if($isRegistry) {
            $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Registry');
        }else{
            $locator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
        }
            
        $this->method($bundle, 'filesystemLocator', $locator, array(), 0);
        
        if($isRegistry) {
            $nestedLocator = $this->quickMock('\PHPixie\Filesystem\Locators\Locator');
            $this->method($locator, 'get', $nestedLocator, array($name[1]), 0);
            $locator = $nestedLocator;
        }
        
        return $locator;
    }
}